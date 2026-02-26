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

        $allowedSorts = ['name', 'created_at'];
        $sort = in_array(request('sort'), $allowedSorts) ? request('sort') : 'name';
        $direction = in_array(request('direction'), ['asc', 'desc']) ? request('direction') : 'asc';

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
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('dojangs.create', compact('queryParams'));
    }

    public function store(StoreDojangRequest $request)
    {
        $dojang = Dojang::create($request->validated());

        if (request()->expectsJson()) {
            return response()->json($dojang, Response::HTTP_CREATED);
        }

        $queryParams = $request->input('query_params', []);

        return redirect()->route('dojangs.index', $queryParams)->with('success', 'Dojang berhasil ditambahkan!');
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
        $queryParams = request()->only(['search', 'page', 'sort', 'direction', 'per_page']);

        return view('dojangs.edit', compact('dojang', 'queryParams'));
    }

    public function update(UpdateDojangRequest $request, Dojang $dojang)
    {
        $dojang->update($request->validated());

        if (request()->expectsJson()) {
            return response()->json($dojang);
        }

        $queryParams = $request->input('query_params', []);

        return redirect()->route('dojangs.index', $queryParams)->with('success', 'Dojang berhasil diperbarui!');
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

        try {
            Excel::import(new DojangImport, $request->file('file'));

            return redirect()->route('dojangs.index')->with('success', 'Data Dojang berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Baris '.$failure->row().': '.implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors($messages);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()]);
        }
    }

    public function bulkDestroy(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        Dojang::whereIn('id', $ids)->delete();

        $queryParams = request()->except(['_token', '_method', 'ids']);

        return redirect()->route('dojangs.index', $queryParams)->with('success', count($ids).' Dojang berhasil dihapus!');
    }
}
