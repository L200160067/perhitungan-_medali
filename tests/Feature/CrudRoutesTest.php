<?php

use App\Enums\ParticipantGender;
use App\Enums\RegistrationStatus;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\TournamentCategory;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    /** @var \Tests\TestCase $this */
    $user = User::factory()->create();
    $role = Role::firstOrCreate(['name' => 'admin']);
    $user->assignRole($role);
    $this->actingAs($user);
});

it('crud dojangs', function () {
    $create = $this->postJson('/dojangs', ['name' => 'Alpha Dojang']);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/dojangs/{$id}")->assertOk();

    $this->putJson("/dojangs/{$id}", ['name' => 'Beta Dojang'])->assertOk();

    $this->deleteJson("/dojangs/{$id}")->assertNoContent();
});

it('crud participants', function () {
    $dojang = Dojang::factory()->create();

    $create = $this->postJson('/participants', [
        'dojang_id' => $dojang->id,
        'name' => 'John Doe',
        'gender' => ParticipantGender::Male->value,
        'birth_date' => '2005-05-10',
    ]);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/participants/{$id}")->assertOk();
    $this->putJson("/participants/{$id}", ['name' => 'Jane Doe'])->assertOk();
    $this->deleteJson("/participants/{$id}")->assertNoContent();
});

it('crud events', function () {
    $create = $this->postJson('/events', [
        'name' => 'Test Event',
        'start_date' => '2026-03-01',
        'end_date' => '2026-03-03',
    ]);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/events/{$id}")->assertOk();
    $this->putJson("/events/{$id}", ['name' => 'Test Event Updated', 'gold_point' => 7])->assertOk();
    $this->deleteJson("/events/{$id}")->assertNoContent();
});

it('crud contingents', function () {
    $event = Event::factory()->create();
    $dojang = Dojang::factory()->create();

    $create = $this->postJson('/contingents', [
        'event_id' => $event->id,
        'dojang_id' => $dojang->id,
        'name' => 'Alpha Contingent',
    ]);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/contingents/{$id}")->assertOk();
    $this->putJson("/contingents/{$id}", ['name' => 'Beta Contingent'])->assertOk();
    $this->deleteJson("/contingents/{$id}")->assertNoContent();
});

it('crud tournament categories', function () {
    $event = Event::factory()->create();

    $create = $this->postJson('/tournament-categories', [
        'event_id' => $event->id,
        'name' => 'Junior Kyourugi',
        'type' => TournamentType::Kyourugi->value,
        'gender' => TournamentGender::Male->value,
        'age_reference_date' => '2026-02-01',
        'min_age' => 10,
        'max_age' => 12,
        'weight_class_name' => 'Under 45.00 kg',
        'min_weight' => 0,
        'max_weight' => 45,
    ]);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/tournament-categories/{$id}")->assertOk();
    $this->putJson("/tournament-categories/{$id}", ['name' => 'Junior Kyourugi B'])->assertOk();
    $this->deleteJson("/tournament-categories/{$id}")->assertNoContent();
});

it('crud medals', function () {
    $create = $this->postJson('/medals', [
        'name' => 'gold',
        'rank' => 1,
    ]);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/medals/{$id}")->assertOk();
    $this->putJson("/medals/{$id}", ['name' => 'gold', 'rank' => 1])->assertOk();
    $this->deleteJson("/medals/{$id}")->assertNoContent();
});

it('crud registrations', function () {
    $event = Event::factory()->create();
    $category = TournamentCategory::factory()->create(['event_id' => $event->id]);
    $participant = Participant::factory()->create(); // Dojang ID doesn't strictly matter for this test unless validated
    $contingent = Contingent::factory()->create(['event_id' => $event->id]);
    $medal = Medal::factory()->gold()->create();

    $create = $this->postJson('/registrations', [
        'category_id' => $category->id,
        'participant_id' => $participant->id,
        'contingent_id' => $contingent->id,
        'medal_id' => $medal->id,
        'status' => RegistrationStatus::Competed->value,
    ]);
    $create->assertCreated();
    $id = $create->json('id');

    $this->getJson("/registrations/{$id}")->assertOk();
    $this->putJson("/registrations/{$id}", ['status' => RegistrationStatus::Dns->value])->assertOk();
    $this->deleteJson("/registrations/{$id}")->assertNoContent();
});
