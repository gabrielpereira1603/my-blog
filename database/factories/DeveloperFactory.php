<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    public function definition(): array
    {
        $userIds = User::whereIn('email', [
            'pereiragabrieldev@gmail.com',
            'Lucas.trabalon@ceopag.com.br',
        ])->pluck('id');

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'photo' => $this->faker->imageUrl(200, 200, 'people', true, 'Developer'),
            'bio' => $this->faker->paragraph(3),
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }

}
