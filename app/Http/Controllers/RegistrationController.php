<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::query()->with(['category', 'contingent', 'medal'])->get();

        if (request()->expectsJson()) {
            return response()->json($registrations);
        }

        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $categories = TournamentCategory::all();
        $contingents = Contingent::all();
        $medals = Medal::all();
        $statuses = RegistrationStatus::cases();

        return view('registrations.create', compact('categories', 'contingents', 'medals', 'statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        // Check medal limits for Prestasi
        if (isset($data['medal_id']) && $data['medal_id']) {
            $category = TournamentCategory::find($data['category_id']);
            if ($category && $category->isPrestasi()) {
                $medal = Medal::find($data['medal_id']);
                $limit = match ($medal?->name) {
                    'gold' => 1,
                    'silver' => 1,
                    'bronze' => 2,
                    default => 0
                };

                $count = Registration::where('category_id', $category->id)
                    ->where('medal_id', $medal->id)
                    ->count();

                if ($count >= $limit) {
                    return back()->withErrors(['medal_id' => "Medal limit reached for '{$medal->name}' in this Prestasi category (Max: {$limit})"])->withInput();
                }
            }
        }

        $registration = Registration::query()->create($data);

        if (request()->expectsJson()) {
            return response()->json($registration, Response::HTTP_CREATED);
        }

        return redirect()->route('registrations.index')->with('success', 'Registration created successfully!');
    }

    public function show(Registration $registration)
    {
        $registration->load(['category', 'contingent', 'medal']);

        if (request()->expectsJson()) {
            return response()->json($registration);
        }

        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        $categories = TournamentCategory::all();
        $contingents = Contingent::all();
        $medals = Medal::all();
        $statuses = RegistrationStatus::cases();

        return view('registrations.edit', compact('registration', 'categories', 'contingents', 'medals', 'statuses'));
    }

    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate($this->rules(true));

        // Check medal limits for Prestasi
        if (isset($data['medal_id']) && $data['medal_id']) {
            $categoryId = $data['category_id'] ?? $registration->category_id;
            $category = TournamentCategory::find($categoryId);

            if ($category && $category->isPrestasi()) {
                $medal = Medal::find($data['medal_id']);
                $limit = match ($medal?->name) {
                    'gold' => 1,
                    'silver' => 1,
                    'bronze' => 2,
                    default => 0
                };

                $count = Registration::where('category_id', $category->id)
                    ->where('medal_id', $medal->id)
                    ->where('id', '!=', $registration->id) // Exclude current record
                    ->count();

                if ($count >= $limit) {
                    return back()->withErrors(['medal_id' => "Medal limit reached for '{$medal->name}' in this Prestasi category (Max: {$limit})"])->withInput();
                }
            }
        }

        $registration->update($data);

        if (request()->expectsJson()) {
            return response()->json($registration);
        }

        return redirect()->route('registrations.index')->with('success', 'Registration updated successfully!');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('registrations.index')->with('success', 'Registration deleted successfully!');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $isUpdate = false): array
    {
        $prefix = $isUpdate ? 'sometimes|required|' : 'required|';
        $presenceRules = $isUpdate ? ['sometimes'] : ['sometimes'];
        $statusValues = array_map(fn (RegistrationStatus $status) => $status->value, RegistrationStatus::cases());

        return [
            'category_id' => $prefix.'integer|exists:tournament_categories,id',
            'contingent_id' => $prefix.'integer|exists:contingents,id',
            'medal_id' => $isUpdate ? 'sometimes|nullable|integer|exists:medals,id' : 'nullable|integer|exists:medals,id',
            'status' => [
                ...$presenceRules,
                'string',
                Rule::in($statusValues),
            ],
        ];
    }
}
