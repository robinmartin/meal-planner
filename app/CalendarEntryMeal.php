<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CalendarEntryMeal extends Pivot
{
    public function calendarEntry()
    {
        return $this->hasMany(CalendarEntry::class, 'id','calendar_entry_id');
    }

    public function meal()
    {
        return $this->hasMany(Meal::class, 'id', 'meal_id');
    }

    public function rule(){
        return $this->belongsTo(RepeatRule::class);
    }
}