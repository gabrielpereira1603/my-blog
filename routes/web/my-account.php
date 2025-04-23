<?php

use App\Livewire\Pages\MyAccount\HomeMyAccount;

Route::middleware('auth')->prefix('my-account')->group(function () {
    Route::get('/', HomeMyAccount::class)
        ->name('home.my_account');
});



