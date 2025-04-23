<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    public function run(): void
    {
        $maxDevelopers = User::count();
        Developer::factory()->count(min(10, $maxDevelopers))->create();
    }
}
