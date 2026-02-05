<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
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
                ->orderBy('tournament_categories.type', $direction)
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
                ->orderBy('medals.rank', $direction)
                ->select('registrations.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $registrations = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($registrations);
        }

        return view('registrations.index', compact('registrations', 'events', 'eventId', 'sort', 'direction', 'perPage', 'search'));
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

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $category = TournamentCategory::find($data['category_id']);
        $contingent = Contingent::find($data['contingent_id']);

        if ($category && $contingent && $category->event_id !== $contingent->event_id) {
            return back()->withErrors(['category_id' => 'Kategori dan Kontingen harus berasal dari pertandingan yang sama.'])->withInput();
        }

        // Check medal limits for Prestasi
        if (isset($data['medal_id']) && $data['medal_id']) {
            $category = TournamentCategory::find($data['category_id']);
            if ($category && $category->isPrestasi()) {
                $medal = Medal::find($data['medal_id']);
                $limit = match ($medal?->name) {
                    'gold' => 1,
                    'silver' => 1,
                    'bronze' => 2,
                    default => 0
                };

                $count = Registration::where('category_id', $category->id)
                    ->where('medal_id', $medal->id)
                    ->count();

                if ($count >= $limit) {
                    return back()->withErrors(['medal_id' => "Batas perolehan medali tercapai. Untuk kategori Prestasi, hanya diperbolehkan: 1 Emas, 1 Perak, dan 2 Perunggu."])->withInput();
                }
            }
        }

        $registration = Registration::query()->create($data);

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

    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate($this->rules(true));

        $categoryId = $data['category_id'] ?? $registration->category_id;
        $contingentId = $data['contingent_id'] ?? $registration->contingent_id;

        $category = TournamentCategory::find($categoryId);
        $contingent = Contingent::find($contingentId);

        if ($category && $contingent && $category->event_id !== $contingent->event_id) {
            return back()->withErrors(['category_id' => 'Kategori dan Kontingen harus berasal dari pertandingan yang sama.'])->withInput();
        }

        // Check medal limits for Prestasi
        if (isset($data['medal_id']) && $data['medal_id']) {
            $categoryId = $data['category_id'] ?? $registration->category_id;
            $category = TournamentCategory::find($categoryId);

            if ($category && $category->isPrestasi()) {
                $medal = Medal::find($data['medal_id']);
                $limit = match ($medal?->name) {
                    'gold' => 1,
                    'silver' => 1,
                    'bronze' => 2,
                    default => 0
                };

                $count = Registration::where('category_id', $category->id)
                    ->where('medal_id', $medal->id)
                    ->where('id', '!=', $registration->id) // Exclude current record
                    ->count();

                if ($count >= $limit) {
                    return back()->withErrors(['medal_id' => "Batas perolehan medali tercapai. Untuk kategori Prestasi, hanya diperbolehkan: 1 Emas, 1 Perak, dan 2 Perunggu."])->withInput();
                }
            }
        }

        $registration->update($data);

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

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $presenceRules = $isUpdate ? ['sometimes'] : ['sometimes'];
        $statusValues = array_map(fn (RegistrationStatus $status) => $status->value, RegistrationStatus::cases());

        return [
            'category_id' => $prefix.'integer|exists:tournament_categories,id',
            'participant_id' => $prefix.'integer|exists:participants,id',
            'contingent_id' => $prefix.'integer|exists:contingents,id',
            'medal_id' => $isUpdate ? 'sometimes|nullable|integer|exists:medals,id' : 'nullable|integer|exists:medals,id',
            'status' => [
                ...$presenceRules,
                'string',
                Rule::in($statusValues),
            ],
        ];
    }
}
