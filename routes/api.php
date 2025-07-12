<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function() {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::apiResource('reports', ReportController::class)->only(['index', 'store', 'show']);

    Route::middleware('can:isAdmin')->prefix('admin')->group(function() {
        Route::get('reports', [AdminReportController::class, 'index']);
        Route::get('reports/{report}', [AdminReportController::class, 'show']);
        Route::put('reports/{report}', [AdminReportController::class, 'update']);
        Route::get('statistics', [AdminReportController::class, 'statistics']);
    });
});

Route::fallback(function() {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found'
    ], 404);
});
