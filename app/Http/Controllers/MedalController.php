<?php

namespace App\Http\Controllers;

use App\Models\Medal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class MedalController extends Controller
{
    public function index()
    {
        return response()->json(Medal::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $medal = Medal::query()->create($data);

        return response()->json($medal, Response::HTTP_CREATED);
    }

    public function show(Medal $medal)
    {
        return response()->json($medal);
    }

    public function update(Request $request, Medal $medal)
    {
        $data = $request->validate($this->rules(true, $medal));

        $medal->update($data);

        return response()->json($medal);
    }

    public function destroy(Medal $medal)
    {
        $medal->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false, ?Medal $medal = null): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $nameRule = Rule::unique('medals', 'name');
        if ($medal) {
            $nameRule = $nameRule->ignore($medal->id);
        }

        return [
            'name' => [$prefix . 'string|max:255', $nameRule],
            'rank' => $prefix . 'integer|min:1',
        ];
    }
}
