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
use Illuminate\Http\Response;

class RegistrationController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    ) {}

    public function index()
    {
        $perPage = request('per_page', 25);
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');
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

        return view('registrations.create', compact('categories', 'participants', 'contingents', 'medals', 'statuses'));
    }

    public function store(StoreRegistrationRequest $request)
    {
        $registration = $this->registrationService->create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($registration, Response::HTTP_CREATED);
        }

        return redirect()->route('registrations.index')->with('success', 'Pendaftaran berhasil ditambahkan!');
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

        return view('registrations.edit', compact('registration', 'categories', 'participants', 'contingents', 'medals', 'statuses'));
    }

    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        $this->registrationService->update($registration, $request->validated());

        if (request()->expectsJson()) {
            return response()->json($registration);
        }

        return redirect()->route('registrations.index')->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('registrations.index')->with('success', 'Pendaftaran berhasil dihapus!');
    }
}
