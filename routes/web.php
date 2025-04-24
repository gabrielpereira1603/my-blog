<?php

use App\Livewire\Pages\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)
->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
require __DIR__.'/web/my-account.php';
require __DIR__.'/web/articles.php';
require __DIR__.'/web/administrator.php';

