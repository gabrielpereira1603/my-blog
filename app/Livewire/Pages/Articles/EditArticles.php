<?php

namespace App\Livewire\Pages\Articles;

use App\Livewire\Forms\Article\CreateArticleForm;
use App\Models\Article;
use App\Trait\Article\HandlesCategoriesAndDevelopersTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditArticles extends Component
{
    use WithFileUploads;
    use HandlesCategoriesAndDevelopersTrait;

    public CreateArticleForm $form;
    public Article $article;

    public function mount($article_id)
    {
        $this->article = Article::with(['categories', 'developers'])->findOrFail($article_id);

        $this->form->title = $this->article->title;
        $this->form->content = $this->article->content;
        $this->form->published_at = $this->article->published_at->format('Y-m-d');
        $this->form->categories = $this->article->categories->pluck('id')->toArray();
        $this->form->developers = $this->article->developers->pluck('id')->toArray();

        $this->selectedCategories = $this->form->categories;
        $this->selectedDevelopers = $this->form->developers;
    }

    public function save()
    {
        DB::beginTransaction();

        try {
            $this->form->validate();

            if ($this->form->cover_image) {
                if ($this->article->cover_image) {
                    $path = str_replace(asset('storage/') . '/', '', $this->article->cover_image);
                    Storage::disk('public')->delete($path);
                }

                $path = $this->form->cover_image->store('articles/cover_images', 'public');
                $this->article->cover_image = asset('storage/' . $path);
            }

            $this->article->update([
                'title' => $this->form->title,
                'content' => $this->form->content,
                'published_at' => $this->form->published_at,
                'cover_image' => $this->article->cover_image
            ]);

            $this->article->categories()->sync($this->form->categories);
            $this->article->developers()->sync($this->form->developers);

            DB::commit();

            $this->redirectRoute('home');
            $this->dispatch('success', title: 'Artigo atualizado com sucesso!');
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->dispatch('error', title: collect($e->errors())->flatten()->first());
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao editar artigo: ' . $e->getMessage());
            $this->dispatch('error', title: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.articles.edit-articles', [
            'categories' => $this->categories,
            'filteredDevelopers' => $this->filteredDevelopers,
        ])->layout('layouts.guest');
    }
}
