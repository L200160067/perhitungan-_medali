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
        $participants = Participant::query()->with('dojang')->get();

        if (request()->expectsJson()) {
            return response()->json($participants);
        }

        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        $dojangs = \App\Models\Dojang::all();
        $genders = ParticipantGender::cases();

        return view('participants.create', compact('dojangs', 'genders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $participant = Participant::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($participant, Response::HTTP_CREATED);
        }

        return redirect()->route('participants.index')->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function show(Participant $participant)
    {
        $participant->load('dojang');

        if (request()->expectsJson()) {
            return response()->json($participant);
        }

        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        $dojangs = \App\Models\Dojang::all();
        $genders = ParticipantGender::cases();

        return view('participants.edit', compact('participant', 'dojangs', 'genders'));
    }

    public function update(Request $request, Participant $participant)
    {
        $data = $request->validate($this->rules(true));

        $participant->update($data);

        if (request()->expectsJson()) {
            return response()->json($participant);
        }

        return redirect()->route('participants.index')->with('success', 'Peserta berhasil diperbarui!');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('participants.index')->with('success', 'Peserta berhasil dihapus!');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $presenceRules = $isUpdate ? ['sometimes', 'required'] : ['required'];
        $genderValues = array_map(fn (ParticipantGender $gender) => $gender->value, ParticipantGender::cases());

        return [
            'dojang_id' => ($isUpdate ? 'sometimes|required|' : 'required|') . 'integer|exists:dojangs,id',
            'name' => ($isUpdate ? 'sometimes|required|' : 'required|') . 'string|max:255',
            'gender' => [
                ...$presenceRules,
                'string',
                Rule::in($genderValues),
            ],
            'birth_date' => ($isUpdate ? 'sometimes|required|' : 'required|') . 'date',
        ];
    }
}
