<?php

namespace App\Http\Requests;

use App\Enums\ParticipantGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $genderValues = array_map(fn (ParticipantGender $gender) => $gender->value, ParticipantGender::cases());

        return [
            'dojang_id' => 'required|integer|exists:dojangs,id',
            'name' => 'required|string|max:255',
            'gender' => [
                'required',
                'string',
                Rule::in($genderValues),
            ],
            'birth_date' => 'required|date',
        ];
    }
}
