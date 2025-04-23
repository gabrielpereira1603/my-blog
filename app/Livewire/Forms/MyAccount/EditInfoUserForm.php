<?php

namespace App\Livewire\Forms\MyAccount;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class EditInfoUserForm extends Form
{
    use WithFileUploads;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,gif|max:2048')]
    public $photo;

    #[Validate('required|string')]
    public $name;

    #[Validate('required|string|email')]
    public $email;

    #[Validate('nullable|string')]
    public $role;

    #[Validate('nullable')]
    public $user = 0;

    #[Validate('nullable|string|max:255')]
    public $bio;
}
