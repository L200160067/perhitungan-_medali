<?php

namespace App\Http\Requests;

use App\Enums\RegistrationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|exists:tournament_categories,id',
            'participant_id' => 'required|integer|exists:participants,id',
            'contingent_id' => 'required|integer|exists:contingents,id',
            'medal_id' => 'nullable|integer|exists:medals,id',
            'status' => [
                'sometimes',
                'string',
                Rule::in(array_map(fn ($status) => $status->value, RegistrationStatus::cases())),
            ],
        ];
    }
}
