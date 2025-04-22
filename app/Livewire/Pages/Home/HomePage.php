<?php

namespace App\Livewire\Pages\Home;

use App\Models\Article;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $articles = Article::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('livewire.pages.home.home-page', compact('articles'))
            ->layout('layouts.guest');
    }
}
