<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\CitizenController;
use App\Http\Controllers\Backend\OfficerController;
use App\Http\Controllers\Backend\UnionCouncilController;
use App\Http\Controllers\Backend\VillageController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;



Route::middleware('auth')->prefix('app')->name('app.')->group(function () {

    Route::prefix('setting')->group(function () {

        // ---------------- Department ----------------
        Route::resource('departments', DepartmentController::class);
        Route::post('departments/dt', [DepartmentController::class, 'index'])
            ->name('departments.dt.index');

        // ---------------- Services ----------------
        Route::resource('services', ServiceController::class);
        Route::post('services/dt', [ServiceController::class, 'index'])
            ->name('services.dt.index');

        // ---------------- Officers ----------------
        Route::resource('officers', OfficerController::class);
        Route::post('officers/dt', [OfficerController::class, 'index'])
            ->name('officers.dt.index');

        // ---------------- Citizens ----------------
        Route::resource('citizens', CitizenController::class);
        Route::post('citizens/dt', [CitizenController::class, 'index'])
            ->name('citizens.dt.index');
    });


    // ---------------- User Management ----------------
    Route::prefix('user-management')->group(function () {

        Route::resource('roles', RoleController::class);
        Route::post('roles/dt', [RoleController::class, 'index'])
            ->name('roles.dt.index');

        Route::resource('users', UserController::class);
        Route::post('users/dt', [UserController::class, 'index'])
            ->name('users.dt.index');
    });

});
