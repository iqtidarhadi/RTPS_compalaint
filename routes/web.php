<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\DynamicController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//make it Global
Route::any('dropdown', [App\Http\Controllers\DynamicController::class, 'dropDown'])->name('dynamic.dropDown');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard',
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/dc', [DashboardController::class, 'dc'])->name('dashboard.dc');
Route::get('/dashboard/dmo', [DashboardController::class, 'dmo'])->name('dashboard.dmo');
Route::get('/report/dmo', [DashboardController::class, 'report_dmo'])->name('report.dmo');
Route::get('/report/dc', [DashboardController::class, 'report_dc'])->name('report.dc');
Route::get('/report/kprts', [DashboardController::class, 'kprts'])->name('report.kprts');
Route::get('/dashboard/rtcp', [DashboardController::class, 'rtcp'])->name('dashboard.rtcp');
Route::get('/dashboard/fazal-manan', [DashboardController::class, 'fazalManan'])->name('dashboard.fazal-manan');
Route::get('/dashboard/arms-licence', [DashboardController::class, 'armsLicence'])->name('dashboard.arms-licence');
Route::get('/dashboard/arms-licence-detail', [DashboardController::class, 'armsLicenceDetail'])->name('dashboard.arms-licence-detail');
Route::get('/dashboard/arms-licence-forward', [DashboardController::class, 'armsLicenceForward'])->name('dashboard.arms-licence-forward');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/app.php';
