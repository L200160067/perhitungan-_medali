<?php

namespace App\Http\Requests;

use App\Enums\RegistrationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'medal_id' => 'sometimes|nullable|integer|exists:medals,id',
            'status' => [
                'sometimes',
                'string',
                Rule::in(array_map(fn ($status) => $status->value, RegistrationStatus::cases())),
            ],
        ];

        if ($this->user()->hasRole('participant')) {
            // Participant Logic (if needed later)
        }

        if ($this->user()->hasRole('admin')) {
            $rules['category_id'] = 'sometimes|required|integer|exists:tournament_categories,id';
            $rules['participant_id'] = 'sometimes|required|integer|exists:participants,id';
            $rules['contingent_id'] = 'sometimes|required|integer|exists:contingents,id';
            $rules['status'] = [
                'sometimes',
                'string',
                Rule::in(array_map(fn ($status) => $status->value, RegistrationStatus::cases())),
            ];
        }

        return $rules;
    }
}
