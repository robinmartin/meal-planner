<?php

namespace App\Listeners;

use App\CalendarEntryMeal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RemoveFutureRepeatRuleMealsWhenRepeatRuleUpdated
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
    public function handle($event)
    {
        $repeatRule = $event->repeatRule;

        CalendarEntryMeal::whereHas('calendarEntry', function($query) use($repeatRule){
            $query->where('date', '>', $repeatRule->end_date);
        })

            ->where('rule_id', $repeatRule->id)

            ->delete();

    }
}
