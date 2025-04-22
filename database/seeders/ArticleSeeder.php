<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory()
            ->count(15)
            ->create()
            ->each(function ($article) {
                $developers = Developer::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $article->developers()->attach($developers);
            });
    }
}
