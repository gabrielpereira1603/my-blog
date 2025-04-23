<?php

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use Livewire\Component;

class ViewOneArticle extends Component
{
    public $article;

    public function mount($article_id)
    {
        $this->article = Article::with(['categories', 'developers'])->findOrFail($article_id);
    }

    public function render()
    {
        return view('livewire.pages.articles.view-one-article')->layout('layouts.guest');
    }
}
