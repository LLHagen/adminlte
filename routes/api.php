<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->name('register');
        Route::post('/login', [AuthController::class, 'login'])
            ->name('login');
    });

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');
