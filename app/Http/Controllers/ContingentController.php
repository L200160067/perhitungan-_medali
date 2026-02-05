<?php

namespace App\Http\Controllers;

use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContingentController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 25);
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $search = request('search');

        $query = Contingent::query()->with(['event', 'dojang']);

        // Searching
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eq) use ($search) {
                        $eq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dojang', function ($dq) use ($search) {
                        $dq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting
        if ($sort === 'event') {
            $query->join('events', 'contingents.event_id', '=', 'events.id')
                ->orderBy('events.name', $direction)
                ->select('contingents.*');
        } elseif ($sort === 'dojang') {
            $query->join('dojangs', 'contingents.dojang_id', '=', 'dojangs.id')
                ->orderBy('dojangs.name', $direction)
                ->select('contingents.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $contingents = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($contingents);
        }

        return view('contingents.index', compact('contingents', 'sort', 'direction', 'perPage', 'search'));
    }

    public function create()
    {
        $events = Event::all();
        $dojangs = Dojang::all();

        return view('contingents.create', compact('events', 'dojangs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $contingent = Contingent::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($contingent, Response::HTTP_CREATED);
        }

        return redirect()->route('contingents.index')->with('success', 'Kontingen berhasil ditambahkan!');
    }

    public function show(Contingent $contingent)
    {
        $contingent->load(['event', 'dojang']);

        if (request()->expectsJson()) {
            return response()->json($contingent);
        }

        return view('contingents.show', compact('contingent'));
    }

    public function edit(Contingent $contingent)
    {
        $events = Event::all();
        $dojangs = Dojang::all();

        return view('contingents.edit', compact('contingent', 'events', 'dojangs'));
    }

    public function update(Request $request, Contingent $contingent)
    {
        $data = $request->validate($this->rules(true));

        $contingent->update($data);

        if (request()->expectsJson()) {
            return response()->json($contingent);
        }

        return redirect()->route('contingents.index')->with('success', 'Kontingen berhasil diperbarui!');
    }

    public function destroy(Contingent $contingent)
    {
        $contingent->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('contingents.index')->with('success', 'Kontingen berhasil dihapus!');
    }

    /**
     * @return array<string, string>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';

        return [
            'event_id' => $prefix . 'integer|exists:events,id',
            'dojang_id' => $prefix . 'integer|exists:dojangs,id',
            'name' => $prefix . 'string|max:255',
        ];
    }
}
