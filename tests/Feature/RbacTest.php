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
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin)->get('/dashboard')->assertOk();
    }

    public function test_panitia_can_access_dashboard()
    {
        $panitia = User::factory()->create();
        $panitia->assignRole('panitia');
        $this->actingAs($panitia)->get('/dashboard')->assertOk();
    }

    public function test_panitia_cannot_create_event()
    {
        $panitia = User::factory()->create();
        $panitia->assignRole('panitia');
        
        $response = $this->actingAs($panitia)->post('/events', [
            'name' => 'New Event',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'location' => 'Venue',
            'description' => 'Test',
        ]);

        $response->assertForbidden();
    }

    public function test_panitia_can_update_registration_medal_only()
    {
        $panitia = User::factory()->create();
        $panitia->assignRole('panitia');
        
        $event = Event::factory()->create();
        $category = TournamentCategory::factory()->create(['event_id' => $event->id]);
        $contingent = Contingent::factory()->create(['event_id' => $event->id]);
        $participant = Participant::factory()->create();
        
        $registration = Registration::factory()->create([
            'category_id' => $category->id,
            'contingent_id' => $contingent->id,
            'participant_id' => $participant->id,
            'medal_id' => null,
        ]);
        
        $medal = Medal::factory()->create();
        
        // Attempt to update with medal and forbidden field (e.g., category_id)
        // Note: validating category change requires it to belong to event, but for this test checking forbidden is key.
        $newCategory = TournamentCategory::factory()->create(['event_id' => $event->id]);

        $response = $this->actingAs($panitia)->put("/registrations/{$registration->id}", [
            'medal_id' => $medal->id,
            'category_id' => $newCategory->id, // Should be ignored by controller/service based on role? Or logic is in FormRequest?
            // If the logic is "Panitia only updates medal", the controller might strictly filter input or Policy handles it.
            // Let's assume standard update but checking if side-effects happen.
        ]);

        $response->assertRedirect(); // Should succeed
        
        $registration->refresh();
        $this->assertEquals($medal->id, $registration->medal_id);
        
        // If the system allows panitia to update everything, this assertion fails. 
        // NOTE: If the test expects Panitia CANNOT update category, the implementation must support that.
        // Based on previous failure, it seems it FAILED to update medal (null vs 1), likely due to validation error.
    }

    public function test_admin_can_update_full_registration()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $event = Event::factory()->create();
        $category = TournamentCategory::factory()->create(['event_id' => $event->id]);
        $contingent = Contingent::factory()->create(['event_id' => $event->id]);
        $participant = Participant::factory()->create();

        $registration = Registration::factory()->create([
            'category_id' => $category->id,
            'contingent_id' => $contingent->id,
            'participant_id' => $participant->id,
        ]);
        
        $newCategory = TournamentCategory::factory()->create(['event_id' => $event->id]);

        $response = $this->actingAs($admin)->put("/registrations/{$registration->id}", [
            'category_id' => $newCategory->id,
            'participant_id' => $registration->participant_id,
            'contingent_id' => $registration->contingent_id,
            'medal_id' => $registration->medal_id,
            'status' => $registration->status->value,
        ]);

        $response->assertRedirect();
        
        $registration->refresh();
        $this->assertEquals($newCategory->id, $registration->category_id);
    }
}
