<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Enums\ParticipantGender;
use App\Enums\RegistrationStatus;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RealisticSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Medals
        $medals = [
            'gold' => Medal::firstOrCreate(['name' => 'gold', 'rank' => 1]),
            'silver' => Medal::firstOrCreate(['name' => 'silver', 'rank' => 2]),
            'bronze' => Medal::firstOrCreate(['name' => 'bronze', 'rank' => 3]),
        ];

        // 2. Create Realistic Dojangs
        $dojangNames = [
            'Garuda Academy', 'Satria Muda Taekwondo', 'Black Tiger Club',
            'Eagle Spirit Dojang', 'Siliwangi Taekwondo Center', 'Iron Fist Dojo',
            'Victory Taekwondo Team', 'Harmony Martial Arts', 'Phoenix Rising',
            'Dragon Force Team',
        ];

        $dojangs = collect();
        foreach ($dojangNames as $name) {
            $dojangs->push(Dojang::create(['name' => $name]));
        }

        // 3. Create Events with different rules
        $events = collect();

        // Event A: Standard (Prestasi only counts)
        $events->push(Event::create([
            'name' => 'Kejuaraan Nasional Pelajar '.date('Y'),
            'start_date' => Carbon::now()->addDays(14),
            'end_date' => Carbon::now()->addDays(16),
            'gold_point' => 5,
            'silver_point' => 3,
            'bronze_point' => 1,
            'count_festival_medals' => false, // Standard logic
        ]));

        // Event B: Festival Friendly (Festival counts)
        $events->push(Event::create([
            'name' => 'Festival Taekwondo Ceria '.date('Y'),
            'start_date' => Carbon::now()->addMonths(2),
            'end_date' => Carbon::now()->addMonths(2)->addDays(2),
            'gold_point' => 3,
            'silver_point' => 2,
            'bronze_point' => 1,
            'count_festival_medals' => true, // New Flexible logic
        ]));

        foreach ($events as $event) {
            // 4. Create Categories (Prestasi & Pemula) for THIS event
            $categories = $this->createCategories($event);

            // 5. Create Participants & Contingents per Dojang for THIS event
            foreach ($dojangs as $dojang) {
                // Create a contingent for this Dojang in this Event
                $contingent = Contingent::create([
                    'event_id' => $event->id,
                    'dojang_id' => $dojang->id,
                    'name' => $dojang->name.' - '.substr($event->name, 0, 10),
                ]);

                // Generate 10-15 participants per DOJANG per EVENT
                $numParticipants = rand(10, 15);
                for ($i = 0; $i < $numParticipants; $i++) {
                    $gender = rand(0, 1) ? ParticipantGender::Male : ParticipantGender::Female;
                    $birthDate = Carbon::now()->subYears(rand(6, 17)); // Ages 6-17 (Wider range for Festival)

                    // Re-use participant if exists? No, create new specific to dojang usually
                    // But for realism, maybe create fresh params
                    $participant = Participant::create([
                        'dojang_id' => $dojang->id,
                        'name' => fake()->name($gender->value),
                        'gender' => $gender,
                        'birth_date' => $birthDate,
                    ]);

                    // Register Participant to a suitable Category
                    $this->registerParticipant($participant, $contingent, $categories, $medals);
                }
            }
        }
    }

    private function createCategories(Event $event)
    {
        $classes = [
            // Pra-Cadet (6-11 years) - mostly Festival
            ['name' => 'Pra-Cadet A', 'min_weight' => 0, 'max_weight' => 25, 'min_age' => 6, 'max_age' => 8],
            ['name' => 'Pra-Cadet B', 'min_weight' => 25, 'max_weight' => 35, 'min_age' => 9, 'max_age' => 11],

            // Cadet (12-14 years)
            ['name' => 'Cadet U-33kg', 'min_weight' => 0, 'max_weight' => 33, 'min_age' => 12, 'max_age' => 14],
            ['name' => 'Cadet U-41kg', 'min_weight' => 33, 'max_weight' => 41, 'min_age' => 12, 'max_age' => 14],
            ['name' => 'Cadet U-51kg', 'min_weight' => 41, 'max_weight' => 51, 'min_age' => 12, 'max_age' => 14],

            // Junior (15-17 years)
            ['name' => 'Junior U-45kg', 'min_weight' => 0, 'max_weight' => 45, 'min_age' => 15, 'max_age' => 17],
            ['name' => 'Junior U-55kg', 'min_weight' => 45, 'max_weight' => 55, 'min_age' => 15, 'max_age' => 17],
            ['name' => 'Junior U-63kg', 'min_weight' => 55, 'max_weight' => 63, 'min_age' => 15, 'max_age' => 17],
        ];

        $categories = collect();

        foreach ($classes as $class) {
            foreach ([CategoryType::Prestasi, CategoryType::Festival] as $catType) {
                foreach ([TournamentGender::Male, TournamentGender::Female] as $gender) {
                    $categories->push(TournamentCategory::create([
                        'event_id' => $event->id,
                        'name' => "{$catType->label()} - {$gender->value} - {$class['name']}",
                        'type' => TournamentType::Kyourugi,
                        'category_type' => $catType,
                        'gender' => $gender,
                        'weight_class_name' => $class['name'],
                        'min_weight' => $class['min_weight'],
                        'max_weight' => $class['max_weight'],
                        'min_age' => $class['min_age'],
                        'max_age' => $class['max_age'],
                        'age_reference_date' => $event->start_date,
                    ]));
                }
            }
        }

        return $categories;
    }

    private function registerParticipant($participant, $contingent, $categories, $medals)
    {
        $age = $participant->age; // Assumes age accessor or calc
        // Just calc age roughly
        $age = Carbon::parse($participant->birth_date)->age;

        // Find matching categories
        $matches = $categories->filter(function ($cat) use ($participant, $age) {
            return $cat->gender->value === $participant->gender->value &&
                   $age >= $cat->min_age && $age <= $cat->max_age;
        });

        if ($matches->isEmpty()) {
            return;
        }

        $category = $matches->random();

        // Determine Medal (Simulate Competition Results)
        $medalId = null;
        if (rand(1, 100) <= ($category->isPrestasi() ? 40 : 80)) {
            // Simple distribution logic
            $roll = rand(1, 100);
            if ($roll <= 10) {
                $medalId = $medals['gold']->id;
            } elseif ($roll <= 30) {
                $medalId = $medals['silver']->id;
            } else {
                $medalId = $medals['bronze']->id;
            }

            // CHECK LIMITS for Prestasi
            if ($category->isPrestasi()) {
                $limit = match ($medalId) {
                    $medals['gold']->id => 1,
                    $medals['silver']->id => 1,
                    $medals['bronze']->id => 2,
                    default => 0
                };
                $currentCount = Registration::where('category_id', $category->id)->where('medal_id', $medalId)->count();
                if ($currentCount >= $limit) {
                    $medalId = null; // Quota full, no medal
                }
            }
        }

        Registration::create([
            'category_id' => $category->id,
            'participant_id' => $participant->id,
            'contingent_id' => $contingent->id,
            'status' => RegistrationStatus::Competed,
            'medal_id' => $medalId,
        ]);
    }
}
