<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Auth Routes
Route::middleware('throttle:20,1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'store']);
});

// Private Auth Routes
Route::middleware('auth:sanctum', 'throttle:30,1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'show']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::delete('/user', [AuthController::class, 'destroy']);
    Route::post('/user/avatar', [AuthController::class, 'updateAvatar']);
});

Route::middleware('auth:sanctum', 'account.type:admin', 'throttle:60,1')->group(function () {
    Route::apiResource('/users', UserController::class)->except('store');
});
