<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

Route::middleware('guest')->group(function () {
    Route::get('/', [WebController::class, 'login_page'])->name('login');
    Route::get('register', [WebController::class, 'register_page']);
    Route::post('web-login', [WebController::class, 'web_login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [WebController::class, 'home_page']);
    Route::post('/web-logout', [WebController::class, 'web_logout']);
});