<?php

namespace App\Http\Controllers;

use App\Models\Contingent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContingentController extends Controller
{
    public function index()
    {
        return response()->json(Contingent::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $contingent = Contingent::query()->create($data);

        return response()->json($contingent, Response::HTTP_CREATED);
    }

    public function show(Contingent $contingent)
    {
        return response()->json($contingent);
    }

    public function update(Request $request, Contingent $contingent)
    {
        $data = $request->validate($this->rules(true));

        $contingent->update($data);

        return response()->json($contingent);
    }

    public function destroy(Contingent $contingent)
    {
        $contingent->delete();

        return response()->noContent();
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
