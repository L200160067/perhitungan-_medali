<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContingentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|integer|exists:events,id',
            'dojang_id' => 'required|integer|exists:dojangs,id',
            'name' => 'required|string|max:255',
        ];
    }
}
