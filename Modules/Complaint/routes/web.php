<?php

use Modules\Complaint\Http\Controllers\ComplaintController;
use Modules\Complaint\Http\Controllers\ProfileController;
use Modules\Complaint\Http\Controllers\RtsServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ComplaintController::class, 'dashboard'])
        ->middleware('verified')
        ->name('complaint.dashboard');

    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('index');
        Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
        Route::post('/{complaint}/status-update', [ComplaintController::class, 'statusUpdate'])
            ->name('status-update');
    });

    // Keep citizen create route available for sidebar links.
    Route::prefix('citizen')->name('citizen.')->group(function () {
        Route::get('/complaints/create', fn () => redirect()->route('complaints.index'))
            ->name('complaints.create');
    });

    // RTS services pages
    Route::prefix('rts/services')->name('rts.services.')->group(function () {
        Route::get('/', [RtsServiceController::class, 'index'])->name('index');
        Route::get('/statistics', [RtsServiceController::class, 'statistics'])->name('statistics');
        Route::get('/department/{id}', [RtsServiceController::class, 'showDepartment'])->name('department');
         Route::get('/department/user/{id}', [RtsServiceController::class, 'department_user'])->name('department_user');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
