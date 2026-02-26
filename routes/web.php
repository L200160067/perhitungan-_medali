<?php

use App\Http\Controllers\ContingentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DojangController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MedalController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TournamentCategoryController;
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

    Route::get('events/import', [EventController::class, 'import'])->name('events.import');
    Route::post('events/import', [EventController::class, 'storeImport'])->name('events.storeImport');
    Route::delete('events/bulk-destroy', [EventController::class, 'bulkDestroy'])->name('events.bulkDestroy');
    Route::patch('events/{event}/toggle-lock', [EventController::class, 'toggleLock'])->name('events.toggleLock');
    Route::resource('events', EventController::class);

    Route::get('tournament-categories/import', [TournamentCategoryController::class, 'import'])->name('tournament-categories.import');
    Route::post('tournament-categories/import', [TournamentCategoryController::class, 'storeImport'])->name('tournament-categories.storeImport');
    Route::delete('tournament-categories/bulk-destroy', [TournamentCategoryController::class, 'bulkDestroy'])->name('tournament-categories.bulkDestroy');
    Route::resource('tournament-categories', TournamentCategoryController::class);

    Route::get('dojangs/import', [DojangController::class, 'import'])->name('dojangs.import');
    Route::post('dojangs/import', [DojangController::class, 'storeImport'])->name('dojangs.storeImport');
    Route::delete('dojangs/bulk-destroy', [DojangController::class, 'bulkDestroy'])->name('dojangs.bulkDestroy');
    Route::resource('dojangs', DojangController::class);

    Route::get('participants/import', [ParticipantController::class, 'import'])->name('participants.import');
    Route::post('participants/import', [ParticipantController::class, 'storeImport'])->name('participants.storeImport');
    Route::delete('participants/bulk-destroy', [ParticipantController::class, 'bulkDestroy'])->name('participants.bulkDestroy');
    Route::resource('participants', ParticipantController::class);

    Route::get('contingents/import', [ContingentController::class, 'import'])->name('contingents.import');
    Route::post('contingents/import', [ContingentController::class, 'storeImport'])->name('contingents.storeImport');
    Route::delete('contingents/bulk-destroy', [ContingentController::class, 'bulkDestroy'])->name('contingents.bulkDestroy');
    Route::resource('contingents', ContingentController::class);

    Route::get('registrations/import', [RegistrationController::class, 'import'])->name('registrations.import');
    Route::post('registrations/import', [RegistrationController::class, 'storeImport'])->name('registrations.storeImport');
    Route::delete('registrations/bulk-destroy', [RegistrationController::class, 'bulkDestroy'])->name('registrations.bulkDestroy');
    Route::resource('registrations', RegistrationController::class);
    Route::resource('medals', MedalController::class);
});

require __DIR__.'/auth.php';
