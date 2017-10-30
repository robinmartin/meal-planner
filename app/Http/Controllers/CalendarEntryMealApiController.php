<?php

namespace App\Http\Controllers;

use App\CalendarEntry;
use App\Http\Requests\CalendarEntryMealDestroyRequest;
use App\Http\Requests\CalendarEntryMealStoreRequest;
use App\Meal;
use App\RepeatRule;
use Illuminate\Http\Request;

class CalendarEntryMealApiController extends Controller
{

    public function store(CalendarEntryMealStoreRequest $request, CalendarEntry $calendarEntry)
    {
        $meal = Meal::find($request->input('meal_id'));

        $this->authorize('store-meal', [$calendarEntry, $meal]);

        $calendarEntry->meals()->syncWithoutDetaching($meal->id);

        return response(null, 201);
    }

    public function destroy(CalendarEntryMealDestroyRequest $request, CalendarEntry $calendarEntry, Meal $meal)
    {
        $this->authorize('remove-meal', $calendarEntry);

        if($request->has('delete_future_meals')){
            $futureCalendarEntryIdsForDeletedMeal = $meal->calendarEntries()
                ->where('date','>',$calendarEntry->date)
                ->get()
                ->pluck('id');

            $meal->calendarEntries()
                ->wherePivot('rule_id', $request->input('rule_id'))
                ->detach($futureCalendarEntryIdsForDeletedMeal);

            //Add an end date to the repeat rule to prevent future instance of the rule being initialised
            $repeatRule = RepeatRule::find($request->input('rule_id'));
            $repeatRule->end_date = $calendarEntry->date;
            $repeatRule->save();
        }

        $calendarEntry->meals()->detach($meal->id);

        return response(null, 204);
        
    }
}
