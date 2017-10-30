<?php

namespace App;

use Laravel\Scout\Searchable;

class Meal extends BaseModel
{
    use Searchable;

    protected $fillable = [
        'name', 'user_id'
    ];

    public function repeatRules()
    {
        return $this->hasMany(RepeatRule::class);
    }

    public function calendarEntries()
    {
        return $this->belongsToMany(CalendarEntry::class)
            ->withTimestamps()
            ->withPivot('rule_id')
            ->using(CalendarEntryMeal::class);
    }






}
