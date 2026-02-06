<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContingentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'sometimes|required|integer|exists:events,id',
            'dojang_id' => 'sometimes|required|integer|exists:dojangs,id',
            'name' => 'sometimes|required|string|max:255',
        ];
    }
}
