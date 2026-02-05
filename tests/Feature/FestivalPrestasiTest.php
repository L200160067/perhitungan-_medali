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
        $category = TournamentCategory::factory()->prestasi()->create();
        $contingent = Contingent::factory()->create();

        // Assign first gold
        Registration::factory()->create([
            'category_id' => $category->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $this->gold->id,
        ]);

        // Attempt second gold
        $response = $this->post(route('registrations.store'), [
            'category_id' => $category->id,
            'contingent_id' => $contingent->id,
            'medal_id' => $this->gold->id,
            'status' => RegistrationStatus::Competed->value,
        ]);

        $response->assertSessionHasErrors('medal_id');
        $this->assertEquals(1, Registration::where('category_id', $category->id)->where('medal_id', $this->gold->id)->count());
    }

    public function test_festival_category_allows_multiple_gold_medals()
    {
        $category = TournamentCategory::factory()->festival()->create();
        $contingent = Contingent::factory()->create();

        // Assign multiple golds
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('registrations.store'), [
                'category_id' => $category->id,
                'contingent_id' => $contingent->id,
                'medal_id' => $this->gold->id,
                'status' => RegistrationStatus::Competed->value,
            ]);
        }

        $this->assertEquals(5, Registration::where('category_id', $category->id)->where('medal_id', $this->gold->id)->count());
    }

    public function test_dashboard_only_counts_prestasi_medals()
    {
        $contingent = Contingent::factory()->create(['name' => 'Test Contingent']);
        
        $prestasiCategory = TournamentCategory::factory()->prestasi()->create();
        $festivalCategory = TournamentCategory::factory()->festival()->create();

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

        $response = $this->get(route('dashboard'));
        
        // Should only see 1 gold in standings
        $response->assertSee('Test Contingent');
        $response->assertSee('1</td>', false); // Gold count text
        $response->assertDontSee('11</td>', false); // Total medals text
    }
}
