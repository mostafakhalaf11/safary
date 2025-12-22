<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);

    // Additional API routes for version 1 can be added here
    Route::middleware('auth:sanctum')->group(function () {
        // logout route
        Route::post('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']);

        // user routes
        Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class);

        // driver routes
        Route::apiResource('drivers', \App\Http\Controllers\Api\V1\DriverController::class);

        //booking routes
        Route::apiResource('bookings', \App\Http\Controllers\Api\V1\BookingController::class);

        //vehicle routes
        // Route::apiResource('vehicles', \App\Http\Controllers\Api\V1\VehicleController::class);

        // trip routes
        Route::apiResource('trips', \App\Http\Controllers\Api\V1\TripController::class);

        // trip stop routes
        Route::apiResource('trip-stops', \App\Http\Controllers\Api\V1\TripStopController::class);

        // delivery routes
        Route::apiResource('deliveries', \App\Http\Controllers\Api\V1\DeliveryController::class);
    });
});
