<?php

namespace App\Trait\AllArticlesDecreasing;

trait HandlesCategoryFilterTrait
{
    public array $selectedCategories = [];

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
}
