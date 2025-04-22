<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'photo' => $this->faker->imageUrl(200, 200, 'people', true, 'Developer'),
            'bio' => $this->faker->paragraph(3),
        ];
    }

}
