<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContingentRequest;
use App\Http\Requests\UpdateContingentRequest;
use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Imports\ContingentImport;
use Maatwebsite\Excel\Facades\Excel;

class ContingentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contingent::class, 'contingent');
    }

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

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('contingents.create', compact('events', 'dojangs', 'queryParams'));
    }

    public function store(StoreContingentRequest $request)
    {
        $contingent = Contingent::create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($contingent, Response::HTTP_CREATED);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('contingents.index', $queryParams)->with('success', 'Kontingen berhasil ditambahkan!');
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

        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('contingents.edit', compact('contingent', 'events', 'dojangs', 'queryParams'));
    }

    public function update(UpdateContingentRequest $request, Contingent $contingent)
    {
        $contingent->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($contingent);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('contingents.index', $queryParams)->with('success', 'Kontingen berhasil diperbarui!');
    }

    public function destroy(Contingent $contingent)
    {
        $contingent->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        // Redirect back with params
        $queryParams = request()->except(['_token', '_method']);
        return redirect()->route('contingents.index', $queryParams)->with('success', 'Kontingen berhasil dihapus!');
    }

    public function import()
    {
        $this->authorize('create', Contingent::class);
        return view('contingents.import');
    }

    public function storeImport(Request $request)
    {
        $this->authorize('create', Contingent::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ContingentImport, $request->file('file'));

        return redirect()->route('contingents.index')->with('success', 'Data Kontingen berhasil diimpor!');
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

        Contingent::whereIn('id', $ids)->delete();

        $queryParams = request()->except(['_token', '_method', 'ids']);
        return redirect()->route('contingents.index', $queryParams)->with('success', count($ids) . ' Kontingen berhasil dihapus!');
    }
}
