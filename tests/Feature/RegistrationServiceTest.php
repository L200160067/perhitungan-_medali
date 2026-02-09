<?php

namespace Tests\Feature;

use App\Enums\CategoryType;
use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use App\Services\RegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RegistrationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(RegistrationService::class);
        $this->seed(\Database\Seeders\MedalSeeder::class);
    }

    public function test_prestasi_category_enforces_gold_medal_limit()
    {
        $event = Event::factory()->create();
        $category = TournamentCategory::factory()->create([
            'event_id' => $event->id,
            'category_type' => CategoryType::Prestasi,
        ]);
        $goldMedal = Medal::where('name', 'gold')->first();
        $dojang = Dojang::factory()->create();
        $contingent = Contingent::factory()->create(['event_id' => $event->id, 'dojang_id' => $dojang->id]);

        // 1. First Gold Registration
        $participant1 = Participant::factory()->create(['dojang_id' => $dojang->id]);
        $this->service->create([
            'category_id' => $category->id,
            'participant_id' => $participant1->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $goldMedal->id,
            'status' => \App\Enums\RegistrationStatus::Registered,
        ]);

        // 2. Second Gold Registration (Should Fail)
        $participant2 = Participant::factory()->create(['dojang_id' => $dojang->id]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Batas perolehan medali tercapai');

        $this->service->create([
            'category_id' => $category->id,
            'participant_id' => $participant2->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $goldMedal->id, // Trying to add second gold
            'status' => \App\Enums\RegistrationStatus::Registered,
        ]);
    }

    public function test_festival_category_allows_multiple_gold_medals()
    {
        $event = Event::factory()->create();
        $category = TournamentCategory::factory()->create([
            'event_id' => $event->id,
            'category_type' => CategoryType::Festival,
        ]);
        $goldMedal = Medal::where('name', 'gold')->first();
        $dojang = Dojang::factory()->create();
        $contingent = Contingent::factory()->create(['event_id' => $event->id, 'dojang_id' => $dojang->id]);

        // 1. First Gold Registration
        $participant1 = Participant::factory()->create(['dojang_id' => $dojang->id]);
        $this->service->create([
            'category_id' => $category->id,
            'participant_id' => $participant1->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $goldMedal->id,
            'status' => \App\Enums\RegistrationStatus::Registered,
        ]);

        // 2. Second Gold Registration (Should Succeed)
        $participant2 = Participant::factory()->create(['dojang_id' => $dojang->id]);

        $registration2 = $this->service->create([
            'category_id' => $category->id,
            'participant_id' => $participant2->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $goldMedal->id,
            'status' => \App\Enums\RegistrationStatus::Registered,
        ]);

        $this->assertDatabaseHas('registrations', ['id' => $registration2->id]);
    }

    public function test_cannot_register_contingent_from_different_event()
    {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();

        $category = TournamentCategory::factory()->create(['event_id' => $event1->id]);
        $dojang = Dojang::factory()->create();
        $contingent = Contingent::factory()->create(['event_id' => $event2->id, 'dojang_id' => $dojang->id]); // Different Event
        $participant = Participant::factory()->create(['dojang_id' => $dojang->id]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kategori dan Kontingen harus berasal dari pertandingan yang sama');

        $this->service->create([
            'category_id' => $category->id,
            'participant_id' => $participant->id,
            'contingent_id' => $contingent->id,
            'medal_id' => null,
            'status' => \App\Enums\RegistrationStatus::Registered,
        ]);
    }

    public function test_prestasi_bronze_limit_is_two()
    {
        $event = Event::factory()->create();
        $category = TournamentCategory::factory()->create([
            'event_id' => $event->id,
            'category_type' => CategoryType::Prestasi,
        ]);
        $bronzeMedal = Medal::where('name', 'bronze')->first();
        $dojang = Dojang::factory()->create();
        $contingent = Contingent::factory()->create(['event_id' => $event->id, 'dojang_id' => $dojang->id]);

        // 2 Bronze Registrations (Should Succeed)
        for ($i = 0; $i < 2; $i++) {
            $p = Participant::factory()->create(['dojang_id' => $dojang->id]);
            $this->service->create([
                'category_id' => $category->id,
                'participant_id' => $p->id,
                'contingent_id' => $contingent->id,
                'medal_id' => $bronzeMedal->id,
                'status' => \App\Enums\RegistrationStatus::Registered,
            ]);
        }

        // 3rd Bronze (Should Fail)
        $p3 = Participant::factory()->create(['dojang_id' => $dojang->id]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Batas perolehan medali tercapai');

        $this->service->create([
            'category_id' => $category->id,
            'participant_id' => $p3->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $bronzeMedal->id,
            'status' => \App\Enums\RegistrationStatus::Registered,
        ]);
    }
}
