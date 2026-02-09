<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDojangRequest;
use App\Http\Requests\UpdateDojangRequest;
use App\Imports\DojangImport;
use App\Models\Dojang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class DojangController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Dojang::class, 'dojang');
    }

    public function index()
    {
        $perPage = request('per_page', 25);
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $search = request('search');

        $query = Dojang::query()->withCount(['participants', 'contingents']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->orderBy($sort, $direction);

        $dojangs = $query->paginate($perPage)->withQueryString();

        if (request()->expectsJson()) {
            return response()->json($dojangs);
        }

        return view('dojangs.index', compact('dojangs', 'sort', 'direction', 'perPage', 'search'));
    }

    public function create()
    {
        return view('dojangs.create');
    }

    public function store(StoreDojangRequest $request)
    {
        $dojang = Dojang::query()->create($request->validated());

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

    public function update(UpdateDojangRequest $request, Dojang $dojang)
    {
        $dojang->update($request->validated());

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

    public function import()
    {
        $this->authorize('create', Dojang::class);
        return view('dojangs.import');
    }

    public function storeImport(Request $request)
    {
        $this->authorize('create', Dojang::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new DojangImport, $request->file('file'));

        return redirect()->route('dojangs.index')->with('success', 'Data Dojang berhasil diimpor!');
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

        Dojang::whereIn('id', $ids)->delete();

        $queryParams = request()->except(['_token', '_method', 'ids']);
        return redirect()->route('dojangs.index', $queryParams)->with('success', count($ids) . ' Dojang berhasil dihapus!');
    }
}
