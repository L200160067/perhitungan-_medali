<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 25);
        $sort = request('sort', 'start_date');
        $direction = request('direction', 'desc');
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
}
