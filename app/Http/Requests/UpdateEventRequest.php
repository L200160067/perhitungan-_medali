<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
            'gold_point' => 'sometimes|integer|min:0',
            'silver_point' => 'sometimes|integer|min:0',
            'bronze_point' => 'sometimes|integer|min:0',
            'count_festival_medals' => 'sometimes|boolean',
        ];
    }
}
