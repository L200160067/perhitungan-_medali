<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'gold_point' => 'sometimes|integer|min:0',
            'silver_point' => 'sometimes|integer|min:0',
            'bronze_point' => 'sometimes|integer|min:0',
        ];
    }
}
