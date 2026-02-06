<?php

namespace App\Http\Controllers;

use App\Enums\ParticipantGender;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Participant;
use Illuminate\Http\Response;

class ParticipantController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 25);
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $search = request('search');

        $query = Participant::query()->with('dojang');

        // Searching
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('dojang', function ($dq) use ($search) {
                        $dq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting
        if ($sort === 'dojang') {
            $query->join('dojangs', 'participants.dojang_id', '=', 'dojangs.id')
                ->orderBy('dojangs.name', $direction)
                ->select('participants.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $participants = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($participants);
        }

        return view('participants.index', compact('participants', 'sort', 'direction', 'perPage', 'search'));
    }

    public function create()
    {
        $dojangs = \App\Models\Dojang::all();
        $genders = ParticipantGender::cases();

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('participants.create', compact('dojangs', 'genders', 'queryParams'));
    }

    public function store(StoreParticipantRequest $request)
    {
        $participant = Participant::query()->create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($participant, Response::HTTP_CREATED);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('participants.index', $queryParams)->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function show(Participant $participant)
    {
        $participant->load('dojang');

        if (request()->expectsJson()) {
            return response()->json($participant);
        }

        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        $dojangs = \App\Models\Dojang::all();
        $genders = ParticipantGender::cases();

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('participants.edit', compact('participant', 'dojangs', 'genders', 'queryParams'));
    }

    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        $participant->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($participant);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('participants.index', $queryParams)->with('success', 'Peserta berhasil diperbarui!');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        // Redirect back with params
        $queryParams = request()->except(['_token', '_method']);
        return redirect()->route('participants.index', $queryParams)->with('success', 'Peserta berhasil dihapus!');
    }
}
