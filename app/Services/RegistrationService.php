<?php

namespace App\Services;

use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    public function create(array $data): Registration
    {
        return DB::transaction(function () use ($data) {
            // Lock the Category to prevent race conditions during medal limit check
            $categoryId = $data['category_id'] ?? null;
            if ($categoryId) {
                TournamentCategory::where('id', $categoryId)->lockForUpdate()->first();
            }

            $this->validateBusinessRules($data);

            return Registration::create($data);
        });
    }

    public function update(Registration $registration, array $data): Registration
    {
        return DB::transaction(function () use ($registration, $data) {
            // 1. Resolve Category ID (from data or existing)
            $categoryId = $data['category_id'] ?? $registration->category_id;

            // 2. Lock the Category to prevent race conditions during medal limit check
            // This serializes updates for the same category
            if ($categoryId) {
                TournamentCategory::where('id', $categoryId)->lockForUpdate()->first();
            }

            // 3. Validate Business Rules/Limits
            $this->validateBusinessRules($data, $registration);

            // 4. Perform Update
            $registration->update($data);

            return $registration;
        });
    }

    private function validateBusinessRules(array $data, ?Registration $registration = null): void
    {
        // Resolve IDs to Models
        $categoryId = $data['category_id'] ?? $registration?->category_id;
        $contingentId = $data['contingent_id'] ?? $registration?->contingent_id;
        $medalId = array_key_exists('medal_id', $data) ? $data['medal_id'] : ($registration?->medal_id);

        $category = TournamentCategory::find($categoryId);
        $contingent = Contingent::find($contingentId);

        // 1. Validate Event Match
        if ($category && $contingent && $category->event_id !== $contingent->event_id) {
            throw ValidationException::withMessages([
                'category_id' => 'Kategori dan Kontingen harus berasal dari pertandingan yang sama.',
            ]);
        }

        // 2. Validate Medal Limits for Prestasi
        if ($medalId && $category && $category->isPrestasi()) {
            $this->checkMedalLimit($category, $medalId, $registration?->id);
        }
    }

    private function checkMedalLimit(TournamentCategory $category, int $medalId, ?int $ignoreRegistrationId = null): void
    {
        $medal = Medal::find($medalId);
        if (! $medal) {
            return;
        }

        $limit = match ($medal->name) {
            'gold' => 1,
            'silver' => 1,
            'bronze' => 2,
            default => 0
        };

        $query = Registration::where('category_id', $category->id)
            ->where('medal_id', $medalId);

        if ($ignoreRegistrationId) {
            $query->where('id', '!=', $ignoreRegistrationId);
        }

        $count = $query->count();

        if ($count >= $limit) {
            throw ValidationException::withMessages([
                'medal_id' => 'Batas perolehan medali tercapai. Untuk kategori Prestasi, hanya diperbolehkan: 1 Emas, 1 Perak, dan 2 Perunggu.',
            ]);
        }
    }

    public function getMedalStats(?int $eventId = null, ?string $search = null): array
    {
        $query = Registration::query()
            ->join('tournament_categories', 'registrations.category_id', '=', 'tournament_categories.id')
            ->where('tournament_categories.category_type', \App\Enums\CategoryType::Prestasi);

        // Filter by Event
        if ($eventId) {
            $query->where('tournament_categories.event_id', $eventId);
        }

        // Filter by Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('participant', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })->orWhereHas('contingent', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%");
                })->orWhereHas('category', function ($tq) use ($search) {
                    $tq->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Aggregate Medal Counts
        $stats = $query->join('medals', 'registrations.medal_id', '=', 'medals.id')
            ->selectRaw('medals.name as medal_name, count(*) as count')
            ->groupBy('medals.name')
            ->pluck('count', 'medal_name')
            ->toArray();

        return [
            'gold' => $stats['gold'] ?? 0,
            'silver' => $stats['silver'] ?? 0,
            'bronze' => $stats['bronze'] ?? 0,
        ];
    }
}
