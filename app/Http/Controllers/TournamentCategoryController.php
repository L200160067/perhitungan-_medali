<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Http\Requests\StoreTournamentCategoryRequest;
use App\Http\Requests\UpdateTournamentCategoryRequest;
use App\Models\Event;
use App\Models\TournamentCategory;
use Illuminate\Http\Response;

class TournamentCategoryController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 25);
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $search = request('search');

        $query = TournamentCategory::query()->with('event');

        // Searching
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eq) use ($search) {
                        $eq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting
        if ($sort === 'event') {
            $query->join('events', 'tournament_categories.event_id', '=', 'events.id')
                ->orderBy('events.name', $direction)
                ->select('tournament_categories.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $tournamentCategories = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($tournamentCategories);
        }

        return view('tournament-categories.index', compact('tournamentCategories', 'sort', 'direction', 'perPage', 'search'));
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

    public function store(StoreTournamentCategoryRequest $request)
    {
        $tournamentCategory = TournamentCategory::query()->create($request->validated());

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

    public function update(UpdateTournamentCategoryRequest $request, TournamentCategory $tournamentCategory)
    {
        $tournamentCategory->update($request->validated());

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
}
