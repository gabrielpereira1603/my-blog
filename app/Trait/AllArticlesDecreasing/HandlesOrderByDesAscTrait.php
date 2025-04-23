<?php

namespace App\Trait\AllArticlesDecreasing;

trait HandlesOrderByDesAscTrait
{
    public $orderBy = 'desc';


    public function toggleOrder()
    {
        $this->orderBy = $this->orderBy === 'desc' ? 'asc' : 'desc';
        $this->loadArticles();
    }

}
