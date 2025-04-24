<?php

use App\Http\Middleware\EnsureUserIsAdministrator;
use App\Livewire\Pages\Administrator\CreateUser;
use App\Livewire\Pages\Administrator\EditUser;
use App\Livewire\Pages\Administrator\HomeAdministrator;
use App\Livewire\Pages\Administrator\ManageUsers;

Route::middleware([EnsureUserIsAdministrator::class])->group(function () {
    Route::get('/administrator', HomeAdministrator::class)
        ->name('home.administrator');

    Route::get('/manage-user', ManageUsers::class)
        ->name('manage-user');

    Route::get('/manage-user/{user_id}', EditUser::class)
        ->name('manage-user.user-id');

    Route::get('/create-user', CreateUser::class)
        ->name('create-user');
});
