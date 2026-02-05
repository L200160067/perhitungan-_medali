<?php

namespace App\Http\Controllers;

use App\Models\Medal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MedalController extends Controller
{
    public function index()
    {
        $medals = Medal::query()->orderBy('rank')->get();

        if (request()->expectsJson()) {
            return response()->json($medals);
        }

        return view('medals.index', compact('medals'));
    }

    public function create()
    {
        return view('medals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $medal = Medal::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($medal, Response::HTTP_CREATED);
        }

        return redirect()->route('medals.index')->with('success', 'Medal created successfully!');
    }

    public function show(Medal $medal)
    {
        if (request()->expectsJson()) {
            return response()->json($medal);
        }

        return redirect()->route('medals.index');
    }

    public function edit(Medal $medal)
    {
        return view('medals.edit', compact('medal'));
    }

    public function update(Request $request, Medal $medal)
    {
        $data = $request->validate($this->rules(true));

        $medal->update($data);

        if (request()->expectsJson()) {
            return response()->json($medal);
        }

        return redirect()->route('medals.index')->with('success', 'Medal updated successfully!');
    }

    public function destroy(Medal $medal)
    {
        $medal->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('medals.index')->with('success', 'Medal deleted successfully!');
    }

    /**
     * @return array<string, string>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';

        return [
            'name' => $prefix . 'string|max:255',
            'rank' => $prefix . 'integer|min:1',
        ];
    }
}
