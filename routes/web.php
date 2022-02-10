<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return view('welcome');
})->name("root",);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource(name: 'users', controller: \App\Http\Controllers\UserController::class);

Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');

Route::get('/clear-cache', function() {
    $configCache = Artisan::call('config:cache');
    $clearCache = Artisan::call('cache:clear');
    return "Cache cleared";
});