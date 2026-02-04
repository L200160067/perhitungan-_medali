<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function index()
    {
        return response()->json(Registration::query()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $registration = Registration::query()->create($data);

        return response()->json($registration, Response::HTTP_CREATED);
    }

    public function show(Registration $registration)
    {
        return response()->json($registration);
    }

    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate($this->rules(true));

        $registration->update($data);

        return response()->json($registration);
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $statusValues = array_map(fn (RegistrationStatus $status) => $status->value, RegistrationStatus::cases());

        return [
            'category_id' => $prefix . 'integer|exists:tournament_categories,id',
            'contingent_id' => $prefix . 'integer|exists:contingents,id',
            'medal_id' => $isUpdate ? 'sometimes|nullable|integer|exists:medals,id' : 'nullable|integer|exists:medals,id',
            'status' => $isUpdate
                ? ['sometimes', 'string', Rule::in($statusValues)]
                : ['sometimes', 'string', Rule::in($statusValues)],
        ];
    }
}
