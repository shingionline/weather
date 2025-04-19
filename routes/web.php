<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;

// authentication
Route::get('/', [AuthController::class, 'index'])->name('login')->middleware(['guest']);
Route::get('login/token/{token}', [AuthController::class, 'login_token'])->middleware(['guest']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login-post', [AuthController::class, 'login_post']);
Route::post('security-post', [AuthController::class, 'security_post']);
Route::get('register', [AuthController::class, 'register'])->name('register-user')->middleware(['guest']);
Route::post('register-post', [AuthController::class, 'register_post']); 
Route::post('register-email', [AuthController::class, 'register_email']);


Route::get('/home', [SiteController::class, 'index'])->middleware('auth');
Route::get('/weather', [SiteController::class, 'weather'])->middleware('auth');