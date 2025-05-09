<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(5, true),
            'cover_image' => $this->faker->imageUrl(800, 600, 'tech', true, 'Article'),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
