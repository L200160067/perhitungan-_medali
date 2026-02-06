<?php

namespace App\Http\Requests;

use App\Enums\CategoryType;
use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTournamentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $typeValues = array_map(fn (TournamentType $type) => $type->value, TournamentType::cases());
        $genderValues = array_map(fn (TournamentGender $gender) => $gender->value, TournamentGender::cases());
        $poomsaeTypeValues = array_map(fn (PoomsaeType $type) => $type->value, PoomsaeType::cases());
        $categoryTypeValues = array_map(fn (CategoryType $type) => $type->value, CategoryType::cases());

        return [
            'event_id' => 'required|integer|exists:events,id',
            'name' => 'required|string|max:255',
            'type' => [
                'sometimes',
                'required',
                'string',
                Rule::in($typeValues),
            ],
            'category_type' => [
                'sometimes',
                'required',
                'string',
                Rule::in($categoryTypeValues),
            ],
            'gender' => [
                'sometimes',
                'required',
                'string',
                Rule::in($genderValues),
            ],
            'age_reference_date' => 'nullable|date',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'weight_class_name' => 'nullable|string|max:255',
            'min_weight' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0',
            'poomsae_type' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in($poomsaeTypeValues),
            ],
        ];
    }
}
