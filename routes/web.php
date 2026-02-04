<?php

use App\Http\Controllers\ContingentController;
use App\Http\Controllers\DojangController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MedalController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TournamentCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resources([
    'dojangs' => DojangController::class,
    'participants' => ParticipantController::class,
    'events' => EventController::class,
    'contingents' => ContingentController::class,
    'tournament-categories' => TournamentCategoryController::class,
    'medals' => MedalController::class,
    'registrations' => RegistrationController::class,
]);
