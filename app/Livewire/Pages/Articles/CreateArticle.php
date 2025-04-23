<?php

namespace App\Livewire\Pages\Articles;

use App\Livewire\Forms\Article\CreateArticleForm;
use App\Models\Article;
use App\Trait\Article\HandlesCategoriesAndDevelopersTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticle extends Component
{
    use WithFileUploads;
    use HandlesCategoriesAndDevelopersTrait;

    public CreateArticleForm $form;


    public function mount()
    {
        $this->form->published_at = now()->format('Y-m-d');
    }

    public function updated()
    {

    }

    public function save()
    {
        DB::beginTransaction();

        try {
            $this->form->validate();

            $path = $this->form->cover_image->store('articles/cover_images', 'public');

            $article = Article::create([
                'title' => $this->form->title,
                'content' => $this->form->content,
                'published_at' => $this->form->published_at,
                'cover_image' => asset('storage/' . $path)
            ]);

            $article->categories()->sync($this->form->categories);
            $article->developers()->sync($this->form->developers);

            DB::commit();

            $this->redirectRoute('home');
            $this->dispatch('success', title: 'Artigo publicado com sucesso!');
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = collect($e->errors())->flatten()->first();
            $this->dispatch('error', title: $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao criar artigo: ' . $e->getMessage());
            $this->dispatch('error', title: $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.pages.articles.create-article', [
            'categories' => $this->categories,
            'filteredDevelopers' => $this->filteredDevelopers,
        ])->layout('layouts.guest');
    }
}
