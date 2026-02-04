<?php

namespace Database\Seeders;

use App\Enums\RegistrationStatus;
use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = TournamentCategory::query()->get();
        if ($categories->isEmpty()) {
            $categories = TournamentCategory::factory()->count(3)->create();
        }

        $contingents = Contingent::query()->get();
        if ($contingents->isEmpty()) {
            $contingents = Contingent::factory()->count(5)->create();
        }

        $medals = Medal::query()->get();

        foreach ($contingents as $contingent) {
            foreach ($categories as $category) {
                Registration::factory()->create([
                    'contingent_id' => $contingent->id,
                    'category_id' => $category->id,
                    'status' => RegistrationStatus::Registered,
                    'medal_id' => null,
                ]);
            }
        }

        if ($medals->isNotEmpty()) {
            $awarded = $categories->take(3)->values();
            foreach ($awarded as $index => $category) {
                Registration::factory()->awarded()->create([
                    'category_id' => $category->id,
                    'contingent_id' => $contingents->random()->id,
                    'status' => RegistrationStatus::Competed,
                    'medal_id' => $medals->get($index % $medals->count())->id,
                ]);
            }
        }
    }
}
