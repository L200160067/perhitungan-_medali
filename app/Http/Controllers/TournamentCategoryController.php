<?php

namespace App\Http\Controllers;

use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\TournamentCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TournamentCategoryController extends Controller
{
    public function index()
    {
        return response()->json(TournamentCategory::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $category = TournamentCategory::query()->create($data);

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function show(TournamentCategory $tournamentCategory)
    {
        return response()->json($tournamentCategory);
    }

    public function update(Request $request, TournamentCategory $tournamentCategory)
    {
        $data = $request->validate($this->rules(true));

        $tournamentCategory->update($data);

        return response()->json($tournamentCategory);
    }

    public function destroy(TournamentCategory $tournamentCategory)
    {
        $tournamentCategory->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $presenceRules = $isUpdate ? ['sometimes', 'required'] : ['required'];
        $typeValues = array_map(fn (TournamentType $type) => $type->value, TournamentType::cases());
        $genderValues = array_map(fn (TournamentGender $gender) => $gender->value, TournamentGender::cases());
        $poomsaeValues = array_map(fn (PoomsaeType $type) => $type->value, PoomsaeType::cases());

        return [
            'event_id' => $prefix . 'integer|exists:events,id',
            'name' => $prefix . 'string|max:255',
            'type' => [
                ...$presenceRules,
                'string',
                Rule::in($typeValues),
            ],
            'gender' => [
                ...$presenceRules,
                'string',
                Rule::in($genderValues),
            ],
            'age_reference_date' => $prefix . 'date',
            'min_age' => $prefix . 'integer|min:0',
            'max_age' => $prefix . 'integer|min:0',
            'weight_class_name' => $isUpdate ? 'sometimes|nullable|string|max:255' : 'nullable|string|max:255',
            'min_weight' => $isUpdate ? 'sometimes|nullable|numeric|min:0' : 'nullable|numeric|min:0',
            'max_weight' => $isUpdate ? 'sometimes|nullable|numeric|min:0' : 'nullable|numeric|min:0',
            'poomsae_type' => $isUpdate
                ? ['sometimes', 'nullable', 'string', Rule::in($poomsaeValues)]
                : ['nullable', 'string', Rule::in($poomsaeValues)],
        ];
    }
}
