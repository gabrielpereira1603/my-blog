<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Gabriel Alves Pereira [administrator]',
            'email' => 'pereiragabrieldev@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'administrator',
        ]);

        User::create([
            'name' => 'Lucas Trabalon',
            'email' => 'Lucas.trabalon@ceopag.com.br [administrator]',
            'password' => Hash::make('suanovasenha'),
            'role' => 'administrator',
        ]);
    }
}
