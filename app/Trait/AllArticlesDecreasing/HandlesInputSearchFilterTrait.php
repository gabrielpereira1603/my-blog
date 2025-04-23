<?php

namespace App\Trait\AllArticlesDecreasing;

trait HandlesInputSearchFilterTrait
{
    public string $search = '';

    public function updatedSearch()
    {
        $this->currentPage = 1;
        $this->loadArticles();
    }

}
