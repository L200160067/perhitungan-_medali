<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Http\Requests\StoreTournamentCategoryRequest;
use App\Http\Requests\UpdateTournamentCategoryRequest;
use App\Imports\TournamentCategoryImport;
use App\Models\Event;
use App\Models\TournamentCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class TournamentCategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TournamentCategory::class, 'tournament_category');
    }

    public function index()
    {
        $perPage = request('per_page', 25);

        $allowedSorts = ['name', 'event', 'category_type', 'type', 'gender', 'created_at'];
        $sort = in_array(request('sort'), $allowedSorts) ? request('sort') : 'name';
        $direction = in_array(request('direction'), ['asc', 'desc']) ? request('direction') : 'asc';

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

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('tournament-categories.create', compact('events', 'types', 'genders', 'poomsaeTypes', 'categoryTypes', 'queryParams'));
    }

    public function store(StoreTournamentCategoryRequest $request)
    {
        $category = TournamentCategory::create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($category, Response::HTTP_CREATED);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);

        return redirect()->route('tournament-categories.index', $queryParams)->with('success', 'Kategori berhasil ditambahkan!');
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

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('tournament-categories.edit', compact('tournamentCategory', 'events', 'types', 'genders', 'poomsaeTypes', 'categoryTypes', 'queryParams'));
    }

    public function update(UpdateTournamentCategoryRequest $request, TournamentCategory $tournamentCategory)
    {
        $tournamentCategory->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($tournamentCategory);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);

        return redirect()->route('tournament-categories.index', $queryParams)->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(TournamentCategory $tournamentCategory)
    {
        $tournamentCategory->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        // Redirect back with params
        $queryParams = request()->except(['_token', '_method']);

        return redirect()->route('tournament-categories.index', $queryParams)->with('success', 'Kategori berhasil dihapus!');
    }

    public function import()
    {
        $this->authorize('create', TournamentCategory::class);

        return view('tournament-categories.import');
    }

    public function storeImport(Request $request)
    {
        $this->authorize('create', TournamentCategory::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new TournamentCategoryImport, $request->file('file'));

            return redirect()->route('tournament-categories.index')->with('success', 'Data Kategori berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Baris '.$failure->row().': '.implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors($messages);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()]);
        }
    }

    public function bulkDestroy(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        TournamentCategory::whereIn('id', $ids)->delete();

        $queryParams = request()->except(['_token', '_method', 'ids']);

        return redirect()->route('tournament-categories.index', $queryParams)->with('success', count($ids).' Kategori berhasil dihapus!');
    }
}
