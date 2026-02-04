<?php

namespace Database\Seeders;

use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\Event;
use App\Models\TournamentCategory;
use Illuminate\Database\Seeder;

class DemoEventSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->addWeeks(2)->toDateString(),
            'end_date' => now()->addWeeks(2)->addDays(2)->toDateString(),
        ]);

        TournamentCategory::factory()->kyourugi()->create([
            'event_id' => $event->id,
            'name' => 'Junior Kyourugi Under 45kg',
            'type' => TournamentType::Kyourugi,
            'gender' => TournamentGender::Male,
            'age_reference_date' => now()->toDateString(),
            'min_age' => 12,
            'max_age' => 14,
            'weight_class_name' => 'Under 45.00 kg',
            'min_weight' => 0,
            'max_weight' => 45,
            'poomsae_type' => null,
        ]);

        TournamentCategory::factory()->poomsae()->create([
            'event_id' => $event->id,
            'name' => 'Senior Poomsae Individual',
            'type' => TournamentType::Poomsae,
            'gender' => TournamentGender::Mixed,
            'age_reference_date' => now()->toDateString(),
            'min_age' => 18,
            'max_age' => 35,
            'poomsae_type' => PoomsaeType::Individual,
            'weight_class_name' => null,
            'min_weight' => null,
            'max_weight' => null,
        ]);
    }
}
