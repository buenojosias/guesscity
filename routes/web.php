<?php

use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Place\CreatePlace;
use App\Livewire\Admin\Place\ListPlace;
use App\Livewire\Player;
use Illuminate\Support\Facades\Route;

// Route::get('/', ['App\Http\Controllers\HomeController', 'index']);
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('player', Player::class)->name('player');

Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('places', ListPlace::class)->name('places.list');
    Route::get('places/create', CreatePlace::class)->name('places.create');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
