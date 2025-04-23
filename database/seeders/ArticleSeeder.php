<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $allCategories = Category::all();
        $allDevelopers = Developer::all();

        Article::factory(15)->create()->each(function ($article) use ($allCategories, $allDevelopers) {
            $randomDevelopers = $allDevelopers->random(rand(1, min(3, $allDevelopers->count())))->pluck('id');
            $article->developers()->attach($randomDevelopers);

            $randomCategories = $allCategories->random(rand(1, min(4, $allCategories->count())))->pluck('id');
            $article->categories()->attach($randomCategories);
        });
    }
}
