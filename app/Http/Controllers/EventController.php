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
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::query()->create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($event, Response::HTTP_CREATED);
        }

        return redirect()->route('events.index')->with('success', 'Pertandingan berhasil ditambahkan!');
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
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($event);
        }

        return redirect()->route('events.index')->with('success', 'Pertandingan berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('events.index')->with('success', 'Pertandingan berhasil dihapus!');
    }
}
