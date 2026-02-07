<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Contingent;
use App\Models\TournamentCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed Roles
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::role('admin')->first();
        $this->actingAs($admin)->get('/dashboard')->assertOk();
    }

    public function test_panitia_can_access_dashboard()
    {
        $panitia = User::role('panitia')->first();
        $this->actingAs($panitia)->get('/dashboard')->assertOk();
    }

    public function test_panitia_cannot_create_event()
    {
        $panitia = User::role('panitia')->first();
        
        $response = $this->actingAs($panitia)->post('/events', [
            'name' => 'New Event',
            'date' => '2024-01-01',
            'location' => 'Venue',
            'status' => 'active',
        ]);

        $response->assertForbidden();
    }

    public function test_panitia_can_update_registration_medal_only()
    {
        $panitia = User::role('panitia')->first();
        $registration = Registration::factory()->create();
        $medal = Medal::factory()->create();

        // Attempt to update with medal and forbidden field (e.g., category_id)
        $newCategory = TournamentCategory::factory()->create();

        $response = $this->actingAs($panitia)->put("/registrations/{$registration->id}", [
            'medal_id' => $medal->id,
            'category_id' => $newCategory->id, // Should be ignored or fail validation depending on request
        ]);

        $response->assertRedirect(); // Should succeed
        
        $registration->refresh();
        $this->assertEquals($medal->id, $registration->medal_id);
        $this->assertNotEquals($newCategory->id, $registration->category_id); // Ensure category did NOT change
    }

    public function test_admin_can_update_full_registration()
    {
        $admin = User::role('admin')->first();
        $registration = Registration::factory()->create();
        $newCategory = TournamentCategory::factory()->create();

        $response = $this->actingAs($admin)->put("/registrations/{$registration->id}", [
            'category_id' => $newCategory->id,
            'participant_id' => $registration->participant_id,
            'contingent_id' => $registration->contingent_id,
        ]);

        $response->assertRedirect();
        
        $registration->refresh();
        $this->assertEquals($newCategory->id, $registration->category_id);
    }
}
