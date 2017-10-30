<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RepeatRuleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'meal_id' => $this->meal_id,
            'repeat_frequency' => $this->repeat_frequency,
            'start_date' => optional($this->start_date)->format('Y-m-d'),
            'end_date' => optional($this->end_date)->format('Y-m-d'),
        ];
    }
}
