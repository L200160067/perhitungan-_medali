<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Imports\EventImport;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }

    public function index()
    {
        $perPage = request('per_page', 25);

        $allowedSorts = ['name', 'start_date', 'end_date', 'created_at'];
        $sort = in_array(request('sort'), $allowedSorts) ? request('sort') : 'start_date';
        $direction = in_array(request('direction'), ['asc', 'desc']) ? request('direction') : 'desc';

        $search = request('search');

        $query = Event::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->orderBy($sort, $direction);

        $events = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($events);
        }

        return view('events.index', compact('events', 'sort', 'direction', 'perPage', 'search'));
    }

    public function create()
    {
        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('events.create', compact('queryParams'));
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($event, Response::HTTP_CREATED);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('events.index', $queryParams)->with('success', 'Pertandingan berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        if (request()->expectsJson()) {
            return response()->json($event);
        }

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        // Capture query params
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('events.edit', compact('event', 'queryParams'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($event);
        }

        // Redirect back with params
        $queryParams = $request->input('query_params', []);
        return redirect()->route('events.index', $queryParams)->with('success', 'Pertandingan berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        // Redirect back with params
        $queryParams = request()->except(['_token', '_method']);
        return redirect()->route('events.index', $queryParams)->with('success', 'Pertandingan berhasil dihapus!');
    }

    public function import()
    {
        $this->authorize('create', Event::class);
        return view('events.import');
    }

    public function storeImport(Request $request)
    {
        $this->authorize('create', Event::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {


            // Force Xlsx reader if file extension is xlsx, or auto detect
            // Sometimes auto detection fails with streams.
            Excel::import(new EventImport, $request->file('file'));
            

            return redirect()->route('events.index')->with('success', 'Data Pertandingan berhasil diimpor!');
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

        Event::whereIn('id', $ids)->delete();

        // Capture query params for redirect
        $queryParams = request()->except(['_token', '_method', 'ids']);
        return redirect()->route('events.index', $queryParams)->with('success', count($ids) . ' Pertandingan berhasil dihapus!');
    }
}
