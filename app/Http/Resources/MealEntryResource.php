<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MealEntryResource extends Resource
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
            'name' => $this->name,
            'rule' => optional($this->pivot)->rule ? new RepeatRuleResource($this->pivot->rule) : null,
        ];
    }
}
