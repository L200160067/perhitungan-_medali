<?php

namespace App\Http\Controllers;

use App\Enums\ParticipantGender;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Participant;
use App\Models\Dojang;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Imports\ParticipantImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Participant::class, 'participant');
    }

    public function index()
    {
        $perPage = request('per_page', 25);

        $allowedSorts = ['name', 'dojang', 'gender', 'created_at'];
        $sort = in_array(request('sort'), $allowedSorts) ? request('sort') : 'name';
        $direction = in_array(request('direction'), ['asc', 'desc']) ? request('direction') : 'asc';

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
        $dojangs = Dojang::all();
        $genders = ParticipantGender::cases();

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('participants.create', compact('dojangs', 'genders', 'queryParams'));
    }

    public function store(StoreParticipantRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('participants-photos', 'public');
            $data['photo'] = $path;
        }

        $participant = Participant::create($data);

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
        $dojangs = Dojang::all();
        $genders = ParticipantGender::cases();

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('participants.edit', compact('participant', 'dojangs', 'genders', 'queryParams'));
    }

    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($participant->photo) {
                Storage::disk('public')->delete($participant->photo);
            }
            $path = $request->file('photo')->store('participants-photos', 'public');
            $data['photo'] = $path;
        }

        $participant->update($data);

        if (request()->expectsJson()) {
            return response()->json($participant);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('participants.index', $queryParams)->with('success', 'Peserta berhasil diperbarui!');
    }

    public function destroy(Participant $participant)
    {
        if ($participant->photo) {
            Storage::disk('public')->delete($participant->photo);
        }

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

        try {
            Excel::import(new ParticipantImport, $request->file('file'));

            return redirect()->route('participants.index')->with('success', 'Data Peserta berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($messages);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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

        $participants = Participant::whereIn('id', $ids)->get();
        foreach ($participants as $participant) {
             if ($participant->photo) {
                Storage::disk('public')->delete($participant->photo);
            }
            $participant->delete();
        }

        $queryParams = request()->except(['_token', '_method', 'ids']);
        return redirect()->route('participants.index', $queryParams)->with('success', count($ids) . ' Peserta berhasil dihapus!');
    }
}
