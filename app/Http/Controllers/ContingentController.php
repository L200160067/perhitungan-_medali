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
        $contingents = Contingent::query()->with(['event', 'dojang'])->latest()->get();

        if (request()->expectsJson()) {
            return response()->json($contingents);
        }

        return view('contingents.index', compact('contingents'));
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
