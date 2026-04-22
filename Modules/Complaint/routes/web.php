<?php

use Modules\Complaint\Http\Controllers\ComplaintController;
use Modules\Complaint\Http\Controllers\ProfileController;
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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
