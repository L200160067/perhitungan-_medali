<?php

namespace App\Http\Controllers;

use App\Enums\ParticipantGender;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Participant;
use App\Models\Dojang;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Imports\ParticipantImport;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Participant::class, 'participant');
    }

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

    public function import()
    {
        $this->authorize('create', Participant::class);
        return view('participants.import');
    }

    public function storeImport(Request $request)
    {
        $this->authorize('create', Participant::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ParticipantImport, $request->file('file'));

        return redirect()->route('participants.index')->with('success', 'Data Peserta berhasil diimpor!');
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

        Participant::whereIn('id', $ids)->delete();

        $queryParams = request()->except(['_token', '_method', 'ids']);
        return redirect()->route('participants.index', $queryParams)->with('success', count($ids) . ' Peserta berhasil dihapus!');
    }
}
