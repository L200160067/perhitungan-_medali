<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    ) {
        $this->authorizeResource(Registration::class, 'registration');
    }

    public function index()
    {
        $perPage = request('per_page', 25);

        $allowedSorts = ['created_at', 'category', 'type', 'participant', 'contingent', 'medal', 'status'];
        $sort = in_array(request('sort'), $allowedSorts) ? request('sort') : 'created_at';
        $direction = in_array(request('direction'), ['asc', 'desc']) ? request('direction') : 'desc';

        $eventId = request('event_id');
        $search = request('search');

        $events = \App\Models\Event::all();

        $query = Registration::query()
            ->with(['category', 'participant', 'contingent', 'medal']);

        // Filtering
        if ($eventId) {
            $query->whereHas('category', function ($q) use ($eventId) {
                $q->where('event_id', $eventId);
            });
        }

        // Searching
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('participant', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })->orWhereHas('contingent', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%");
                })->orWhereHas('category', function ($tq) use ($search) {
                    $tq->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Sorting
        if ($sort === 'category') {
            $query->join('tournament_categories', 'registrations.category_id', '=', 'tournament_categories.id')
                ->orderBy('tournament_categories.name', $direction)
                ->select('registrations.*');
        } elseif ($sort === 'type') {
            $query->join('tournament_categories', 'registrations.category_id', '=', 'tournament_categories.id')
                ->orderByRaw("CASE WHEN tournament_categories.category_type = 'prestasi' THEN 1 ELSE 2 END $direction")
                ->select('registrations.*');
        } elseif ($sort === 'participant') {
            $query->join('participants', 'registrations.participant_id', '=', 'participants.id')
                ->orderBy('participants.name', $direction)
                ->select('registrations.*');
        } elseif ($sort === 'contingent') {
            $query->join('contingents', 'registrations.contingent_id', '=', 'contingents.id')
                ->orderBy('contingents.name', $direction)
                ->select('registrations.*');
        } elseif ($sort === 'medal') {
            $query->leftJoin('medals', 'registrations.medal_id', '=', 'medals.id')
                ->orderByRaw("COALESCE(medals.rank, 99) $direction")
                ->select('registrations.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $registrations = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($registrations);
        }

        $medalStats = $this->registrationService->getMedalStats($eventId, $search);

        return view('registrations.index', compact('registrations', 'events', 'eventId', 'sort', 'direction', 'perPage', 'search', 'medalStats'));
    }

    public function create()
    {
        $categories = TournamentCategory::all();
        $participants = Participant::all();
        $contingents = Contingent::all();
        $medals = Medal::all();
        $statuses = RegistrationStatus::cases();

        // Capture query params to preserve context
        $queryParams = request()->only(['event_id', 'search', 'page', 'sort', 'direction', 'per_page']);

        return view('registrations.create', compact('categories', 'participants', 'contingents', 'medals', 'statuses', 'queryParams'));
    }

    public function store(StoreRegistrationRequest $request)
    {
        $registration = $this->registrationService->create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($registration, Response::HTTP_CREATED);
        }

        // Redirect back with original query params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('registrations.index', $queryParams)->with('success', 'Pendaftaran berhasil ditambahkan!');
    }

    public function show(Registration $registration)
    {
        $registration->load(['category', 'participant', 'contingent', 'medal']);

        if (request()->expectsJson()) {
            return response()->json($registration);
        }

        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        $categories = TournamentCategory::all();
        $participants = Participant::all();
        $contingents = Contingent::all();
        $medals = Medal::all();
        $statuses = RegistrationStatus::cases();

        // Capture query params to preserve context
        $queryParams = request()->only(['event_id', 'search', 'page', 'sort', 'direction', 'per_page']);

        return view('registrations.edit', compact('registration', 'categories', 'participants', 'contingents', 'medals', 'statuses', 'queryParams'));
    }

    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        $this->registrationService->update($registration, $request->validated());

        if (request()->expectsJson()) {
            return response()->json($registration);
        }

        // Redirect back with original query params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('registrations.index', $queryParams)->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        // Redirect back with original query params (passed via hidden input in delete form)
        $queryParams = request()->except(['_token', '_method']);
        return redirect()->route('registrations.index', $queryParams)->with('success', 'Pendaftaran berhasil dihapus!');
    }
    public function import()
    {
        // Check policy if needed, though authorizeResource handles standard CRUD
        $this->authorize('create', Registration::class);
        return view('registrations.import');
    }

    public function storeImport(Request $request)
    {
        $this->authorize('create', Registration::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\RegistrationImport, $request->file('file'));
            return redirect()->route('registrations.index')->with('success', 'Data pendaftaran berhasil diimport!');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Terjadi kesalahan saat import: ' . $e->getMessage()]);
        }
    }

    public function bulkDestroy(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        Registration::whereIn('id', $ids)->delete();

        $queryParams = request()->except(['_token', '_method', 'ids']);
        return redirect()->route('registrations.index', $queryParams)->with('success', count($ids) . ' Pendaftaran berhasil dihapus!');
    }
}
