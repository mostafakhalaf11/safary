<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
        Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
        Route::post('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
    });
});
