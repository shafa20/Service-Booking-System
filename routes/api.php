<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\ServiceController;

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


// Customer routes (token required)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('services', [ServiceController::class, 'index']); // List services
    Route::post('bookings', [BookingController::class, 'store']); // Create booking
    Route::get('bookings', [BookingController::class, 'index']); // My bookings

    // Admin routes (token + admin role)
    Route::middleware('admin')->group(function () {
        Route::post('services', [ServiceController::class, 'store']);
        Route::put('services/{service}', [ServiceController::class, 'update']);
        Route::delete('services/{service}', [ServiceController::class, 'destroy']);
        Route::get('admin/bookings', [BookingController::class, 'all']);
    });
});