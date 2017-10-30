<?php

namespace App;

use App\Events\CalendarEntryCreated;

class CalendarEntry extends BaseModel
{
    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'date', 'user_id'
    ];

    protected $dispatchesEvents = [
        'created' => CalendarEntryCreated::class,
    ];

    public function meals()
    {
        return $this->belongsToMany(Meal::class)
            ->withTimestamps()
            ->withPivot('rule_id')
            ->using(CalendarEntryMeal::class);
    }
}
