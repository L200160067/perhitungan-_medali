<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TournamentCategoryController;
use App\Http\Controllers\DojangController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ContingentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MedalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('events', EventController::class);
    Route::resource('tournament-categories', TournamentCategoryController::class);
    Route::resource('dojangs', DojangController::class);
    Route::resource('participants', ParticipantController::class);
    Route::resource('contingents', ContingentController::class);
    Route::resource('registrations', RegistrationController::class);
    Route::resource('medals', MedalController::class);
});

require __DIR__.'/auth.php';
