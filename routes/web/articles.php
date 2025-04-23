<?php


use App\Livewire\Pages\Articles\CreateArticle;
use App\Livewire\Pages\Articles\EditArticles;
use App\Livewire\Pages\Articles\MyArticles;
use App\Livewire\Pages\Articles\ViewOneArticle;

Route::middleware('auth')->prefix('articles')->group(function () {
    Route::get('/create', CreateArticle::class)
        ->name('create.article');

    Route::get('/view_one/{article_id}', ViewOneArticle::class)
        ->name('view-one.article');

    Route::get('/my_articles', MyArticles::class)
        ->name('view-my-articles');

    Route::get('/edit/{article_id}', EditArticles::class)
        ->name('edit.article');
});



