<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Domínio: Usuários
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/suggestions', [UserController::class, 'suggestions']);
    Route::get('/{username}', [UserController::class, 'show']);
});
