<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Inteligência Artificial',
            'Desenvolvimento Web',
            'Mobile',
            'DevOps',
            'Cloud',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
