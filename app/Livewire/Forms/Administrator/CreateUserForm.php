<?php

namespace App\Livewire\Forms\Administrator;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateUserForm extends Form
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = 'João Caetano';

    #[Validate('required|email|unique:users,email')]
    public string $email = 'joao@teste.com';

    #[Validate('required|min:6')]
    public string $password = 'joao12345';

    #[Validate('required|in:administrator,user')]
    public string $role = 'user';

    public bool $isDeveloper = true;

    // Campos de Developer
    #[Validate('nullable|image|max:1024')]
    public $photo;

    #[Validate('nullable|string|max:255')]
    public string $bio = 'hy, my name is joão!s';
}
