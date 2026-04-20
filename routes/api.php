<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintController;
use Illuminate\Support\Facades\Route;
Route::prefix('v1')->group(function () {
    
    // Public routes (no authentication required)
    Route::prefix('auth')->group(function () {
        Route::post('/request-code', [AuthController::class, 'requestVerificationCode']);
        Route::post('/verify-code', [AuthController::class, 'verifyCode']);
        Route::post('/complete-registration', [AuthController::class, 'completeRegistration']);
        Route::post('/resend-code', [AuthController::class, 'resendCode']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    
    // Protected routes - CITIZEN ONLY
   Route::middleware(['auth:sanctum', 'role:citizen'])
    ->prefix('citizen')
    ->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/dashboard', function () {

            return response()->json([
                'success' => true,
                'message' => 'Welcome to Citizen Dashboard',
                'data' => [
                    'user' => auth()->user(),
                    'stats' => [
                        'total_services' => 5,
                        'pending_requests' => 2,
                        'completed_services' => 3
                    ]
                ]
            ]);
        });

});
});
//  Route::middleware(['auth:sanctum', 'role:citizen'])->prefix('complaints')->group(function () {
//     // ... existing routes ...
    
//     // Status History Routes
//     Route::get('/{id}/status-history', [ComplaintController::class, 'getStatusHistory']);
//     Route::get('/{id}/status-timeline', [ComplaintController::class, 'getStatusTimeline']);
//     Route::patch('/{id}/status-with-history', [ComplaintController::class, 'updateStatusWithHistory']);
    
//     // Analytics Routes
//     Route::get('/analytics/status-stats', [ComplaintController::class, 'getGlobalStatusStats']);
//     Route::get('/analytics/status-changes', [ComplaintController::class, 'getStatusAnalytics']);
// });

// Route::middleware(['auth:sanctum', 'role:citizen'])->prefix('complaints')->group(function () {
//     Route::post('/', [ComplaintController::class, 'store']);
//     Route::post('/appeal', [ComplaintController::class, 'fileAppeal']);
//     Route::get('/{id}', [ComplaintController::class, 'show']);
//     Route::get('/track/{complaintNumber}', [ComplaintController::class, 'track']);
//     Route::get('/history/{cnic}', [ComplaintController::class, 'complainantHistory']);
//     Route::patch('/{id}/status', [ComplaintController::class, 'updateStatus']);
// });
Route::middleware(['auth:sanctum', 'role:citizen'])->prefix('complaints')->group(function () {
    Route::post('/', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::post('/appeal', [ComplaintController::class, 'fileAppeal'])->name('complaints.appeal');
    Route::get('/{id}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/track/{complaintNumber}', [ComplaintController::class, 'track'])->name('complaints.track');
    Route::get('/history/{cnic}', [ComplaintController::class, 'complainantHistory'])->name('complaints.history');
    Route::patch('/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
    
    // Status History Routes
    Route::get('/{id}/status-history', [ComplaintController::class, 'getStatusHistory'])->name('complaints.status-history');
    Route::get('/{id}/status-timeline', [ComplaintController::class, 'getStatusTimeline'])->name('complaints.status-timeline');
    Route::patch('/{id}/status-with-history', [ComplaintController::class, 'updateStatusWithHistory'])->name('complaints.status-with-history');
    
    // Analytics Routes
    Route::get('/analytics/status-stats', [ComplaintController::class, 'getGlobalStatusStats'])->name('complaints.status-stats');
    Route::get('/analytics/status-changes', [ComplaintController::class, 'getStatusAnalytics'])->name('complaints.status-changes');
});