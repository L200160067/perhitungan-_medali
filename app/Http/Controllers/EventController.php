<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $event = Event::query()->create($data);

        return response()->json($event, Response::HTTP_CREATED);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate($this->rules(true));

        $event->update($data);

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, string>
     */
    private function rules(bool $isUpdate = false): array
    {
        $datePrefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $pointsPrefix = $isUpdate ? 'sometimes|integer|min:0' : 'sometimes|integer|min:0';

        return [
            'start_date' => $datePrefix . 'date',
            'end_date' => $isUpdate
                ? $datePrefix . 'date'
                : $datePrefix . 'date|after_or_equal:start_date',
            'gold_point' => $pointsPrefix,
            'silver_point' => $pointsPrefix,
            'bronze_point' => $pointsPrefix,
        ];
    }
}
