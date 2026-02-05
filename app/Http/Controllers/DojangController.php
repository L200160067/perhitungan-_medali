<?php

namespace App\Http\Controllers;

use App\Models\Dojang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DojangController extends Controller
{
    public function index()
    {
        $dojangs = Dojang::query()->withCount(['participants', 'contingents'])->latest()->get();

        if (request()->expectsJson()) {
            return response()->json($dojangs);
        }

        return view('dojangs.index', compact('dojangs'));
    }

    public function create()
    {
        return view('dojangs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $dojang = Dojang::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($dojang, Response::HTTP_CREATED);
        }

        return redirect()->route('dojangs.index')->with('success', 'Dojang berhasil ditambahkan!');
    }

    public function show(Dojang $dojang)
    {
        $dojang->load(['participants', 'contingents.event']);

        if (request()->expectsJson()) {
            return response()->json($dojang);
        }

        return view('dojangs.show', compact('dojang'));
    }

    public function edit(Dojang $dojang)
    {
        return view('dojangs.edit', compact('dojang'));
    }

    public function update(Request $request, Dojang $dojang)
    {
        $data = $request->validate($this->rules(true));

        $dojang->update($data);

        if (request()->expectsJson()) {
            return response()->json($dojang);
        }

        return redirect()->route('dojangs.index')->with('success', 'Dojang berhasil diperbarui!');
    }

    public function destroy(Dojang $dojang)
    {
        $dojang->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('dojangs.index')->with('success', 'Dojang berhasil dihapus!');
    }

    /**
     * @return array<string, string>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';

        return [
            'name' => $prefix . 'string|max:255',
        ];
    }
}
