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
        $this->validateBusinessRules($data);
        return Registration::create($data);
    }

    public function update(Registration $registration, array $data): Registration
    {
        $this->validateBusinessRules($data, $registration);
        $registration->update($data);
        return $registration;
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
        if (!$medal) return;

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
                'medal_id' => "Batas perolehan medali tercapai. Untuk kategori Prestasi, hanya diperbolehkan: 1 Emas, 1 Perak, dan 2 Perunggu.",
            ]);
        }
    }
}
