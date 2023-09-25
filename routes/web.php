<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::view('/', 'welcome')->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');

    Route::get('events/{event}', [\App\Http\Controllers\Events\EventController::class, 'show'])
        ->name('events.show');
});
