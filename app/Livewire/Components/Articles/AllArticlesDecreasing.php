<?php

namespace App\Livewire\Components\Articles;

use App\Models\Category;
use App\Trait\AllArticlesDecreasing\HandlesCategoryFilterTrait;
use App\Trait\AllArticlesDecreasing\HandlesInputSearchFilterTrait;
use App\Trait\AllArticlesDecreasing\HandlesOrderByDesAscTrait;
use App\Trait\AllArticlesDecreasing\HandlesPaginationTrait;
use Livewire\Component;
use App\Models\Article;

class AllArticlesDecreasing extends Component
{
    use HandlesPaginationTrait;
    use HandlesCategoryFilterTrait;
    use HandlesInputSearchFilterTrait;
    use HandlesOrderByDesAscTrait;

    public $articles;
    public $categories;

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

    public function render()
    {
        return view('livewire.components.articles.all-articles-decreasing', [
            'articles' => $this->articles,
            'categories' => $this->categories,
            'totalPages' => $this->getTotalPages(),
        ]);
    }
}
