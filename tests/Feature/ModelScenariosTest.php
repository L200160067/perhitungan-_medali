<?php

use App\Enums\ParticipantGender;
use App\Enums\PoomsaeType;
use App\Enums\TournamentType;
use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a dojang via factory', function () {
    $dojang = Dojang::factory()->create();

    expect($dojang->name)->not->toBeEmpty();
    $this->assertDatabaseHas('dojangs', ['id' => $dojang->id]);
});

it('creates a participant with a dojang and enum gender', function () {
    $participant = Participant::factory()->create();

    expect($participant->dojang)->not->toBeNull();
    expect($participant->gender)->toBeInstanceOf(ParticipantGender::class);
    $this->assertDatabaseHas('participants', ['id' => $participant->id]);
});

it('creates an event with default points', function () {
    $event = Event::factory()->create();

    expect($event->gold_point)->toBe(5);
    expect($event->silver_point)->toBe(3);
    expect($event->bronze_point)->toBe(1);
    $this->assertDatabaseHas('events', ['id' => $event->id]);
});

it('creates a poomsae tournament category with proper fields', function () {
    $category = TournamentCategory::factory()->poomsae()->create();

    expect($category->type)->toBe(TournamentType::Poomsae);
    expect($category->poomsae_type)->toBeInstanceOf(PoomsaeType::class);
    expect($category->weight_class_name)->toBeNull();
    expect($category->min_weight)->toBeNull();
    expect($category->max_weight)->toBeNull();
});

it('creates an awarded registration with a medal', function () {
    $registration = Registration::factory()->awarded()->create();

    expect($registration->medal)->not->toBeNull();
    $this->assertDatabaseHas('registrations', ['id' => $registration->id]);
});

it('smoke checks key relationships', function () {
    $contingent = Contingent::factory()->create();

    expect($contingent->event)->not->toBeNull();
    expect($contingent->dojang)->not->toBeNull();

    $registration = Registration::factory()->awarded()->create();

    expect($registration->category)->not->toBeNull();
    expect($registration->contingent)->not->toBeNull();
    expect($registration->medal)->not->toBeNull();
});
