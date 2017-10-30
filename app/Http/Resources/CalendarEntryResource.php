<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CalendarEntryResource extends Resource
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
            'meals' => MealEntryResource::collection($this->whenLoaded('meals')),
            'date' => $this->date->format('Y-m-d'),
        ];
    }
}
