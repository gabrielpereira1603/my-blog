<?php

namespace App\Livewire\Components\Articles;

use App\Models\Category;
use Livewire\Component;
use App\Models\Article;

class AllArticlesDecreasing extends Component
{
    public $orderBy = 'desc';
    public string $search = '';
    public $articles;
    public $categories;
    public array $selectedCategories = [];
    public $currentPage = 1;
    public $perPage = 10;

    public function mount()
    {
        $this->categories = Category::all();
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $query = Article::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNull('deleted_at')
            ->orderBy('published_at', $this->orderBy);

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selectedCategories)) {
            $query->whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->selectedCategories);
            });
        }

        $this->articles = $query->with('categories')
            ->skip(($this->currentPage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
        }

        $this->currentPage = 1;
        $this->loadArticles();
    }

    public function updatedSearch()
    {
        $this->currentPage = 1;
        $this->loadArticles();
    }

    public function toggleOrder()
    {
        $this->orderBy = $this->orderBy === 'desc' ? 'asc' : 'desc';
        $this->loadArticles();
    }

    public function goToPage($page)
    {
        $this->currentPage = $page;
        $this->loadArticles();
    }

    public function getTotalPages()
    {
        $query = Article::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNull('deleted_at');

        if (!empty($this->selectedCategories)) {
            $query->whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->selectedCategories);
            });
        }

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        return ceil($query->count() / $this->perPage);
    }
    public function render()
    {
        return view('livewire.components.articles.all-articles-decreasing', [
            'articles' => $this->articles,
            'categories' => $this->categories,
            'totalPages' => $this->getTotalPages(),
        ]);
    }
}
