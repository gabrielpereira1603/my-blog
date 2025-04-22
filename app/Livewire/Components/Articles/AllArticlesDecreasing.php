<?php

namespace App\Livewire\Components\Articles;

use Livewire\Component;
use App\Models\Article;

class AllArticlesDecreasing extends Component
{
    public $orderBy = 'desc';
    public string $search = '';
    public $articles;
    public $currentPage = 1;
    public $perPage = 10;

    public function mount()
    {
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $query = Article::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNull('deleted_at')
            ->orderBy('published_at', $this->orderBy);

        if ($this->search) {
            $query->where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        $this->articles = $query->skip(($this->currentPage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    public function toggleOrder()
    {
        $this->orderBy = $this->orderBy === 'desc' ? 'asc' : 'desc';
        $this->loadArticles();
    }

    public function updatedSearch()
    {
        $this->currentPage = 1;

        $this->loadArticles();
    }

    public function goToPage($page)
    {
        $this->currentPage = $page;
        $this->loadArticles();
    }

    public function getTotalPages()
    {
        $totalArticles = Article::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNull('deleted_at')
            ->count();

        return ceil($totalArticles / $this->perPage);
    }

    public function render()
    {
        return view('livewire.components.articles.all-articles-decreasing', [
            'articles' => $this->articles,
            'totalPages' => $this->getTotalPages()
        ]);
    }
}
