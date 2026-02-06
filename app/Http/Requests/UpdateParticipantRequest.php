<?php

namespace App\Http\Requests;

use App\Enums\ParticipantGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $genderValues = array_map(fn (ParticipantGender $gender) => $gender->value, ParticipantGender::cases());

        return [
            'dojang_id' => 'sometimes|required|integer|exists:dojangs,id',
            'name' => 'sometimes|required|string|max:255',
            'gender' => [
                'sometimes',
                'required',
                'string',
                Rule::in($genderValues),
            ],
            'birth_date' => 'sometimes|required|date',
        ];
    }
}
