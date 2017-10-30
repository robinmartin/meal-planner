<?php

namespace App\Listeners;

use App\CalendarEntry;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AddRepeatRuleMealToFutureCalendarEntries
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

        CalendarEntry::where('date', '>=', $repeatRule->start_date)
            ->whereRaw("DATEDIFF(date, ?)%? = 0", [$repeatRule->start_date, $repeatRule->repeat_frequency])
            ->get()
            ->each(function($calendarEntry) use($repeatRule){
                $calendarEntry->meals()
                    ->syncWithoutDetaching([
                        $repeatRule->meal_id => ['rule_id' => $repeatRule->id]
                    ]);
            });

    }
}
