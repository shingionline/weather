<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\WeatherController;

Route::prefix('v1')->group(function () {

    Route::post('register', [AuthController::class, 'register']); 
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::middleware('throttle:rate-limit')->group(function () {
            Route::post('/weather', [WeatherController::class, 'weather']);
            Route::post('/forecast', [WeatherController::class, 'forecast']);
            Route::post('/history', [WeatherController::class, 'history']);
            Route::post('/direct', [WeatherController::class, 'direct']);
        });

    });

});