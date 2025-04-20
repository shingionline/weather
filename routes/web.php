<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', [SiteController::class, 'login'])->name('login')->middleware('guest');
Route::get('register', [SiteController::class, 'register'])->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/home', [SiteController::class, 'home']);
});