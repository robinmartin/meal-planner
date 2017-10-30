<?php

namespace App\Http\Controllers;

use App\CalendarEntry;
use App\Http\Requests\RepeatRuleStoreRequest;
use App\Meal;
use App\RepeatRule;

class MealRepeatRuleApiController extends Controller
{
    public function store(RepeatRuleStoreRequest $request, Meal $meal)
    {
        $repeatRule = new RepeatRule([
            'start_date' => $request->input('start_date', '2017-10-16'),
            'repeat_frequency' => $request->input('repeat_frequency'),
            'user_id' => auth()->user()->id
        ]);

        $meal->repeatRules()->save($repeatRule);

        //Find current future calendar entries where day of date matches every_week_on
        CalendarEntry::where('date', '>=', $repeatRule->start_date)
            ->whereRaw("DATEDIFF(date, ?)%? = 0", [$repeatRule->start_date, $repeatRule->repeat_frequency])
            ->get()
            ->each(function($calendarEntry) use($meal, $repeatRule){
                $calendarEntry->meals()->syncWithoutDetaching([$meal->id => ['rule_id' => $repeatRule->id]]);
            });

        return response(null, 201);
    }
}
