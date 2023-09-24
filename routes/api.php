<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Events\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')
    ->group(function () {
        Route::post('register', [AuthController::class, 'register'])
            ->name('register');
        Route::post('login', [AuthController::class, 'login'])
            ->name('login');
    });

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');


Route::prefix('events')->name('events.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('', [EventController::class, 'index'])
            ->name('index');
        Route::post('create', [EventController::class, 'create'])
            ->name('create');
        Route::delete('{event}', [EventController::class, 'delete'])
            ->name('delete');

        Route::get('participants/{event}', [EventController::class, 'participants'])
            ->name('participants');
        Route::post('participants/{event}/attach', [EventController::class, 'participantsAttach'])
            ->name('participants.attach');
        Route::post('participants/{event}/detach', [EventController::class, 'participantsDetach'])
            ->name('participants.detach');
    });
