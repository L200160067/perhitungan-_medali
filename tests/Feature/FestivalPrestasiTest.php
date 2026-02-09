<?php

namespace Tests\Feature;

use App\Enums\CategoryType;
use App\Enums\RegistrationStatus;
use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FestivalPrestasiTest extends TestCase
{
    use RefreshDatabase;

    private $gold;
    private $silver;
    private $bronze;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gold = Medal::create(['name' => 'gold', 'rank' => 1]);
        $this->silver = Medal::create(['name' => 'silver', 'rank' => 2]);
        $this->bronze = Medal::create(['name' => 'bronze', 'rank' => 3]);
    }

    public function test_prestasi_category_enforces_gold_medal_limit()
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole(\Spatie\Permission\Models\Role::create(['name' => 'admin']));

        $event = \App\Models\Event::factory()->create(); // Ensure event exists
        $category = TournamentCategory::factory()->prestasi()->create(['event_id' => $event->id]);
        $contingent = Contingent::factory()->create(['event_id' => $event->id]);

        // Assign first gold
        Registration::factory()->create([
            'category_id' => $category->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $this->gold->id,
        ]);

        // Attempt second gold
        $response = $this->actingAs($user)->post(route('registrations.store'), [
            'category_id' => $category->id,
            'contingent_id' => $contingent->id, // Must match
            'participant_id' => \App\Models\Participant::factory()->create()->id, // Needed for new reg
            'medal_id' => $this->gold->id,
            'status' => RegistrationStatus::Competed->value,
        ]);

        $response->assertSessionHasErrors('medal_id');
        $this->assertEquals(1, Registration::where('category_id', $category->id)->where('medal_id', $this->gold->id)->count());
    }

    public function test_festival_category_allows_multiple_gold_medals()
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole(\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']));

        $event = \App\Models\Event::factory()->create();
        $category = TournamentCategory::factory()->festival()->create(['event_id' => $event->id]);
        $contingent = Contingent::factory()->create(['event_id' => $event->id]);

        // Assign multiple golds
        for ($i = 0; $i < 5; $i++) {
            $this->actingAs($user)->post(route('registrations.store'), [
                'category_id' => $category->id,
                'contingent_id' => $contingent->id,
                'participant_id' => \App\Models\Participant::factory()->create()->id,
                'medal_id' => $this->gold->id,
                'status' => RegistrationStatus::Competed->value,
            ]);
        }

        $this->assertEquals(5, Registration::where('category_id', $category->id)->where('medal_id', $this->gold->id)->count());
    }

    public function test_dashboard_only_counts_prestasi_medals()
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole(\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']));

        $event = \App\Models\Event::factory()->create();
        $contingent = Contingent::factory()->create(['name' => 'Test Contingent', 'event_id' => $event->id]);
        
        $prestasiCategory = TournamentCategory::factory()->prestasi()->create(['event_id' => $event->id]);
        $festivalCategory = TournamentCategory::factory()->festival()->create(['event_id' => $event->id]);

        // Award 1 gold in Prestasi
        Registration::factory()->create([
            'category_id' => $prestasiCategory->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $this->gold->id,
        ]);

        // Award 10 golds in Festival
        for ($i = 0; $i < 10; $i++) {
            Registration::factory()->create([
                'category_id' => $festivalCategory->id,
                'contingent_id' => $contingent->id,
                'medal_id' => $this->gold->id,
            ]);
        }

        $response = $this->actingAs($user)->get(route('dashboard'));
        
        // Should only see 1 gold in standings
        $response->assertViewHas('medalStandings', function ($stats) {
            // Check if there is an entry for 'Test Contingent'
            $contingentStats = $stats->firstWhere('name', 'Test Contingent');
            
            if (!$contingentStats) return false;

            return $contingentStats->gold_count == 1 && $contingentStats->total_medals == 1;
        });
    }
}
