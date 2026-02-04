<?php

namespace App\Http\Controllers;

use App\Models\Dojang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DojangController extends Controller
{
    public function index()
    {
        return response()->json(Dojang::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $dojang = Dojang::query()->create($data);

        return response()->json($dojang, Response::HTTP_CREATED);
    }

    public function show(Dojang $dojang)
    {
        return response()->json($dojang);
    }

    public function update(Request $request, Dojang $dojang)
    {
        $data = $request->validate($this->rules(true));

        $dojang->update($data);

        return response()->json($dojang);
    }

    public function destroy(Dojang $dojang)
    {
        $dojang->delete();

        return response()->noContent();
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
