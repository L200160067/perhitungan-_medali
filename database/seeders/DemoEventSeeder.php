<?php

namespace Database\Seeders;

use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Models\Event;
use App\Models\TournamentCategory;
use Illuminate\Database\Seeder;

class DemoEventSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::factory()->create([
            'name' => 'Kejuaraan Taekwondo Nasional - Piala Menpora',
            'start_date' => now()->addWeeks(2)->toDateString(),
            'end_date' => now()->addWeeks(2)->addDays(2)->toDateString(),
        ]);

        // --- PRESTASI CATEGORIES ---
        TournamentCategory::factory()->kyourugi()->prestasi()->create([
            'event_id' => $event->id,
            'name' => 'Kyourugi Junior Putra Under 45kg',
            'gender' => TournamentGender::Male,
            'min_age' => 12,
            'max_age' => 14,
            'max_weight' => 45.00,
        ]);

        TournamentCategory::factory()->poomsae()->prestasi()->create([
            'event_id' => $event->id,
            'name' => 'Poomsae Senior Individual Putra',
            'gender' => TournamentGender::Male,
            'poomsae_type' => PoomsaeType::Individual,
            'min_age' => 18,
            'max_age' => 35,
        ]);

        // --- FESTIVAL CATEGORIES ---
        TournamentCategory::factory()->kyourugi()->festival()->create([
            'event_id' => $event->id,
            'name' => 'Kyourugi Pra-Cadet B Putra',
            'gender' => TournamentGender::Male,
            'min_age' => 8,
            'max_age' => 9,
            'max_weight' => 30.00,
        ]);

        TournamentCategory::factory()->poomsae()->festival()->create([
            'event_id' => $event->id,
            'name' => 'Poomsae Cadet Individual Putri',
            'gender' => TournamentGender::Female,
            'poomsae_type' => PoomsaeType::Individual,
            'min_age' => 12,
            'max_age' => 14,
        ]);
    }
}
