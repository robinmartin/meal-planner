<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CalendarEntryMealDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delete_future_meals' => 'sometimes|accepted',
        ];
    }

    /**
     * Add additional conditional rules.
     *
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->sometimes('rule_id', 'required|exists:repeat_rules,id', function ($input) {
            return $input->delete_future_meals;
        });
    }
}
