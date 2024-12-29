<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('jwt.auth')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('send-password-change-code', [AuthController::class, 'sendPasswordChangeCode']);
            Route::post('verify-password-change-code', [AuthController::class, 'verifyPasswordChangeCode']);
            Route::post('change-password', [AuthController::class, 'changePassword']);
        });

        Route::prefix('users')->group(function () {
            Route::get('{user}', [UserController::class, 'show']);
            Route::get('profile', [UserController::class, 'profile']);
        });
    });
});
