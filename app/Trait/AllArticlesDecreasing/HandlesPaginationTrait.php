<?php

namespace App\Trait\AllArticlesDecreasing;

use App\Models\Article;

trait HandlesPaginationTrait
{
    public $currentPage = 1;
    public $perPage = 10;

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
}
