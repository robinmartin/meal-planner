<?php

namespace App;

use App\Events\RepeatRuleCreated;
use App\Events\RepeatRuleUpdating;
use Illuminate\Database\Eloquent\Model;

class RepeatRule extends Model
{
    protected $fillable = [
        'repeat_frequency', 'start_date', 'user_id',
    ];

    protected $dates = [
        'end_date', 'start_date',
    ];

    protected $dispatchesEvents = [
//        'created' => RepeatRuleCreated::class,
        'updating' => RepeatRuleUpdating::class,
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

}
