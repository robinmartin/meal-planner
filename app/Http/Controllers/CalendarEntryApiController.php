<?php

namespace App\Http\Controllers;

use App\CalendarEntry;
use App\Http\Resources\CalendarEntryResource;
use Carbon\Carbon;

class CalendarEntryApiController extends Controller
{
    public function index()
    {
        //Get all dates within the range (1 week for now by default)
        $dates = collect(range(0,6))->map(function($days){
            return Carbon::parse(request('start_date', date('Y-m-d')))
                ->addDays($days)
                ->format('Y-m-d');
        });

        //Check which dates exist as Calendar Entries already for the user
        $existingCalendarEntries = CalendarEntry::whereIn('date', $dates)
            ->where('user_id', auth()->user()->id)
            ->get(['date'])
            ->map(function($entry){
                return $entry->date->format('Y-m-d');
            });

        //For the dates that don't exist create them
        $dates->diff($existingCalendarEntries)
            ->each(function($date){
                CalendarEntry::create(['date' => $date, 'user_id' => auth()->user()->id]);
            });

        //Return all dates within the range with meals
        $calendarEntries = CalendarEntry::with('meals.pivot.rule')
            ->where('user_id', auth()->user()->id)
            ->orderBy('date')
            ->whereIn('date', $dates)
            ->get();

        return CalendarEntryResource::collection($calendarEntries);
    }

    public function show(CalendarEntry $calendarEntry)
    {
        $this->authorize('view', $calendarEntry);

        $calendarEntry->load('meals');

        return new CalendarEntryResource($calendarEntry);
    }

}
