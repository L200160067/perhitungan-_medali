<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedalRequest;
use App\Http\Requests\UpdateMedalRequest;
use App\Models\Medal;
use Symfony\Component\HttpFoundation\Response;

class MedalController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Medal::class, 'medal');
    }

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
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('medals.create', compact('queryParams'));
    }

    public function store(StoreMedalRequest $request)
    {
        $medal = Medal::create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($medal, Response::HTTP_CREATED);
        }

        $queryParams = $request->input('query_params', []);
        return redirect()->route('medals.index', $queryParams)->with('success', 'Medali berhasil ditambahkan!');
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
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('medals.edit', compact('medal', 'queryParams'));
    }

    public function update(UpdateMedalRequest $request, Medal $medal)
    {
        $medal->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($medal);
        }

        $queryParams = $request->input('query_params', []);
        return redirect()->route('medals.index', $queryParams)->with('success', 'Medali berhasil diperbarui!');
    }

    public function destroy(Medal $medal)
    {
        $medal->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('medals.index')->with('success', 'Medali berhasil dihapus!');
    }
}
