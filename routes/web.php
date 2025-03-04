<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', ['App\Http\Controllers\HomeController', 'index']);
Route::get('/', function () {
    return view('welcome');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
