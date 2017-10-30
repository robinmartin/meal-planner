<?php

namespace App\Listeners;

use App\Events\CalendarEntryCreated;
use App\RepeatRule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AddRepeatRuleMealsToCalendarEntry
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CalendarEntryCreated $event)
    {
        $calendarEntry = $event->calendarEntry;

        RepeatRule::where('user_id',$calendarEntry->user_id)

            ->where(function($query) use($calendarEntry){
                $query->where('end_date', '>=', $calendarEntry->date->format('Y-m-d'))
                    ->orWhereNull('end_date');
            })

            ->where(function($query) use($calendarEntry){
                $query->where('start_date', '<=', $calendarEntry->date->format('Y-m-d'))
                    ->orWhereNull('start_date');
            })

            ->get()

            ->each(function($rule) use($calendarEntry){
                if($calendarEntry->date->diffInDays($rule->start_date) % $rule->repeat_frequency == 0){
                    $calendarEntry->meals()->syncWithoutDetaching([$rule->meal_id => ['rule_id' => $rule->id]]);
                }
            });
    }
}
