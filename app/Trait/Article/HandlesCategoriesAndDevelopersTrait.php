<?php

namespace App\Trait\Article;

use App\Models\Category;
use App\Models\Developer;


trait HandlesCategoriesAndDevelopersTrait
{
    public $selectedCategories = [];
    public $selectedDevelopers = [];

    public $developerSearch = '';

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getFilteredDevelopersProperty()
    {
        return Developer::when($this->developerSearch, function ($query) {
            $query->where('name', 'like', '%' . $this->developerSearch . '%');
        })->limit(10)->get();
    }

    public function updatedSelectedCategories($value)
    {
        $this->form->categories = $this->selectedCategories;
    }

    public function updatedSelectedDevelopers($value)
    {
        $this->form->developers = $this->selectedDevelopers;
    }
}
