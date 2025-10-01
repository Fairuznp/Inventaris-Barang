<?php

use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\LoanRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Routes for Mobile App
Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/barangs', [BarangController::class, 'index']);
    Route::get('/barangs/{id}', [BarangController::class, 'show']);
    Route::get('/categories', [BarangController::class, 'categories']);
    Route::get('/locations', [BarangController::class, 'locations']);

    // Loan requests
    Route::get('/loan-requests', [LoanRequestController::class, 'index']);
    Route::post('/loan-requests', [LoanRequestController::class, 'store']);
    Route::get('/loan-requests/{id}', [LoanRequestController::class, 'show']);
    Route::patch('/loan-requests/{id}/cancel', [LoanRequestController::class, 'cancel']);
});
