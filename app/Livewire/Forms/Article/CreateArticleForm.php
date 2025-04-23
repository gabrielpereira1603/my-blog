<?php

namespace App\Livewire\Forms\Article;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateArticleForm extends Form
{
    use WithFileUploads;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048')]
    public $cover_image;

    #[Validate('required|string')]
    public $title = '';

    #[Validate('required|string|min:10')]
    public $content = '';

    #[Validate('required|date')]
    public $published_at;

    #[Validate('required|array|min:1')]
    public $developers;

    #[Validate('required|array|min:1')]
    public $categories;

    protected $messages = [
        'categories.required' => 'Escolha pelo menos uma categoria.',
        'categories.array' => 'Formato inválido para categorias.',
        'categories.min' => 'Escolha pelo menos uma categoria.',

        'developers.required' => 'Escolha pelo menos um autor.',
        'developers.array' => 'Formato inválido para autores.',
        'developers.min' => 'Escolha pelo menos um autor.',
    ];
}
