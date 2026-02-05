<?php

namespace Database\Seeders;

use App\Enums\RegistrationStatus;
use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $events = \App\Models\Event::with(['tournamentCategories', 'contingents'])->get();
        $participants = Participant::all();
        if ($participants->isEmpty()) {
            $participants = Participant::factory()->count(50)->create();
        }
        $medals = Medal::all();

        foreach ($events as $event) {
            $categories = $event->tournamentCategories;
            $contingents = $event->contingents;

            if ($categories->isEmpty() || $contingents->isEmpty()) {
                continue;
            }

            foreach ($categories as $category) {
                // Create 5 registrations per category for speed
                $regCount = 5;
                $availableParticipants = $participants->shuffle();
                
                for ($i = 0; $i < $regCount; $i++) {
                    $participant = $availableParticipants->pop();
                    $contingent = $contingents->random();

                    $registration = Registration::factory()->create([
                        'participant_id' => $participant->id,
                        'contingent_id' => $contingent->id,
                        'category_id' => $category->id,
                        'status' => RegistrationStatus::Registered,
                        'medal_id' => null,
                    ]);

                    // Simple awarding: first 3 get medals if it's a small set
                    if ($i < 3 && $medals->isNotEmpty()) {
                        $registration->update([
                            'status' => RegistrationStatus::Competed,
                            'medal_id' => $medals[$i % $medals->count()]->id,
                        ]);
                    }
                }
            }
        }
    }
}
