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
    
    Route::get('events/import', [EventController::class, 'import'])->name('events.import');
    Route::post('events/import', [EventController::class, 'storeImport'])->name('events.storeImport');
    Route::resource('events', EventController::class);

    Route::get('tournament-categories/import', [TournamentCategoryController::class, 'import'])->name('tournament-categories.import');
    Route::post('tournament-categories/import', [TournamentCategoryController::class, 'storeImport'])->name('tournament-categories.storeImport');
    Route::resource('tournament-categories', TournamentCategoryController::class);
    
    Route::get('dojangs/import', [DojangController::class, 'import'])->name('dojangs.import');
    Route::post('dojangs/import', [DojangController::class, 'storeImport'])->name('dojangs.storeImport');
    Route::resource('dojangs', DojangController::class);
    Route::get('participant/import', [ParticipantController::class, 'import'])->name('participants.import');
    Route::post('participant/import', [ParticipantController::class, 'storeImport'])->name('participants.storeImport');
    Route::resource('participants', ParticipantController::class);
    
    Route::get('contingents/import', [ContingentController::class, 'import'])->name('contingents.import');
    Route::post('contingents/import', [ContingentController::class, 'storeImport'])->name('contingents.storeImport');
    Route::resource('contingents', ContingentController::class);
    Route::get('registrations/import', [RegistrationController::class, 'import'])->name('registrations.import');
    Route::post('registrations/import', [RegistrationController::class, 'storeImport'])->name('registrations.storeImport');
    Route::resource('registrations', RegistrationController::class);
    Route::resource('medals', MedalController::class);
});

require __DIR__.'/auth.php';
