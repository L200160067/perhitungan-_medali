<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query()->get();

        if (request()->expectsJson()) {
            return response()->json($events);
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $event = Event::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($event, Response::HTTP_CREATED);
        }

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
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

    public function update(Request $request, Event $event)
    {
        $data = $request->validate($this->rules(true));

        $event->update($data);

        if (request()->expectsJson()) {
            return response()->json($event);
        }

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    /**
     * @return array<string, string>
     */
    private function rules(bool $isUpdate = false): array
    {
        $datePrefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $pointsPrefix = $isUpdate ? 'sometimes|integer|min:0' : 'sometimes|integer|min:0';

        return [
            'name' => 'required|string|max:255',
            'start_date' => $datePrefix.'date',
            'end_date' => $isUpdate
                ? $datePrefix.'date'
                : $datePrefix.'date|after_or_equal:start_date',
            'gold_point' => $pointsPrefix,
            'silver_point' => $pointsPrefix,
            'bronze_point' => $pointsPrefix,
        ];
    }
}
