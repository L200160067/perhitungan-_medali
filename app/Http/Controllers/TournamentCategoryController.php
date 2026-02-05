<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\Event;
use App\Models\TournamentCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TournamentCategoryController extends Controller
{
    public function index()
    {
        $tournamentCategories = TournamentCategory::query()->with('event')->latest()->get();

        if (request()->expectsJson()) {
            return response()->json($tournamentCategories);
        }

        return view('tournament-categories.index', compact('tournamentCategories'));
    }

    public function create()
    {
        $events = Event::all();
        $types = TournamentType::cases();
        $genders = TournamentGender::cases();
        $poomsaeTypes = PoomsaeType::cases();
        $categoryTypes = CategoryType::cases();

        return view('tournament-categories.create', compact('events', 'types', 'genders', 'poomsaeTypes', 'categoryTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $tournamentCategory = TournamentCategory::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($tournamentCategory, Response::HTTP_CREATED);
        }

        return redirect()->route('tournament-categories.index')->with('success', 'Kategori pertandingan berhasil ditambahkan!');
    }

    public function show(TournamentCategory $tournamentCategory)
    {
        $tournamentCategory->load('event');

        if (request()->expectsJson()) {
            return response()->json($tournamentCategory);
        }

        return view('tournament-categories.show', compact('tournamentCategory'));
    }

    public function edit(TournamentCategory $tournamentCategory)
    {
        $events = Event::all();
        $types = TournamentType::cases();
        $genders = TournamentGender::cases();
        $poomsaeTypes = PoomsaeType::cases();
        $categoryTypes = CategoryType::cases();

        return view('tournament-categories.edit', compact('tournamentCategory', 'events', 'types', 'genders', 'poomsaeTypes', 'categoryTypes'));
    }

    public function update(Request $request, TournamentCategory $tournamentCategory)
    {
        $data = $request->validate($this->rules(true));

        $tournamentCategory->update($data);

        if (request()->expectsJson()) {
            return response()->json($tournamentCategory);
        }

        return redirect()->route('tournament-categories.index')->with('success', 'Kategori pertandingan berhasil diperbarui!');
    }

    public function destroy(TournamentCategory $tournamentCategory)
    {
        $tournamentCategory->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('tournament-categories.index')->with('success', 'Kategori pertandingan berhasil dihapus!');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $presenceRules = $isUpdate ? ['sometimes'] : ['sometimes'];

        $typeValues = array_map(fn (TournamentType $type) => $type->value, TournamentType::cases());
        $genderValues = array_map(fn (TournamentGender $gender) => $gender->value, TournamentGender::cases());
        $poomsaeTypeValues = array_map(fn (PoomsaeType $type) => $type->value, PoomsaeType::cases());
        $categoryTypeValues = array_map(fn (CategoryType $type) => $type->value, CategoryType::cases());

        return [
            'event_id' => $prefix . 'integer|exists:events,id',
            'name' => $prefix . 'string|max:255',
            'type' => [
                ...$presenceRules,
                'required',
                'string',
                Rule::in($typeValues),
            ],
            'category_type' => [
                ...$presenceRules,
                'required',
                'string',
                Rule::in($categoryTypeValues),
            ],
            'gender' => [
                ...$presenceRules,
                'required',
                'string',
                Rule::in($genderValues),
            ],
            'age_reference_date' => $isUpdate ? 'sometimes|nullable|date' : 'nullable|date',
            'min_age' => $isUpdate ? 'sometimes|nullable|integer|min:0' : 'nullable|integer|min:0',
            'max_age' => $isUpdate ? 'sometimes|nullable|integer|min:0' : 'nullable|integer|min:0',
            'weight_class_name' => $isUpdate ? 'sometimes|nullable|string|max:255' : 'nullable|string|max:255',
            'min_weight' => $isUpdate ? 'sometimes|nullable|numeric|min:0' : 'nullable|numeric|min:0',
            'max_weight' => $isUpdate ? 'sometimes|nullable|numeric|min:0' : 'nullable|numeric|min:0',
            'poomsae_type' => [
                ...$presenceRules,
                'nullable',
                'string',
                Rule::in($poomsaeTypeValues),
            ],
        ];
    }
}
