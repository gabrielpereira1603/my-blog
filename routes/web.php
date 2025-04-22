<?php

use App\Livewire\Pages\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
