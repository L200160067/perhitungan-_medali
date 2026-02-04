<?php

namespace App\Http\Controllers;

use App\Enums\ParticipantGender;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    public function index()
    {
        return response()->json(Participant::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $participant = Participant::query()->create($data);

        return response()->json($participant, Response::HTTP_CREATED);
    }

    public function show(Participant $participant)
    {
        return response()->json($participant);
    }

    public function update(Request $request, Participant $participant)
    {
        $data = $request->validate($this->rules(true));

        $participant->update($data);

        return response()->json($participant);
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $genderValues = array_map(fn (ParticipantGender $gender) => $gender->value, ParticipantGender::cases());

        return [
            'dojang_id' => $prefix . 'integer|exists:dojangs,id',
            'name' => $prefix . 'string|max:255',
            'gender' => [$prefix . 'string', Rule::in($genderValues)],
            'birth_date' => $prefix . 'date',
        ];
    }
}
