<?php


use App\Livewire\Pages\Articles\CreateArticle;
use App\Livewire\Pages\Articles\ViewOneArticle;

Route::middleware('auth')->prefix('articles')->group(function () {
    Route::get('/create', CreateArticle::class)
        ->name('create.article');

    Route::get('/view_one/{article_id}', ViewOneArticle::class)
        ->name('view-one.article');
});



