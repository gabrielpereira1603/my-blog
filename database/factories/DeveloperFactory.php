<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class DeveloperFactory extends Factory
{
    protected static $usedUserIds = [];

    public function definition(): array
    {
        $availableUsers = User::whereNotIn('id', static::$usedUserIds)->get();

        if ($availableUsers->isEmpty()) {
            return [
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'photo' => $this->faker->imageUrl(200, 200, 'people', true, 'Developer'),
                'bio' => $this->faker->paragraph(3),
                'user_id' => null,
            ];
        }

        $user = $availableUsers->random();
        static::$usedUserIds[] = $user->id;

        return [
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $this->faker->imageUrl(200, 200, 'people', true, 'Developer'),
            'bio' => $this->faker->paragraph(3),
            'user_id' => $user->id,
        ];
    }
}
