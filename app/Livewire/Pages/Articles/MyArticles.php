<?php

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class MyArticles extends Component
{
    use WithPagination;

    public $currentPage = 1;
    public $totalPages;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $articles = auth()->user()->developer->articles()->withTrashed()->paginate(10);

        return view('livewire.pages.articles.my-articles', compact('articles'))->layout('layouts.guest');
    }

    public function softDeleteArticle($articleId)
    {
        $article = Article::find($articleId);
        $article->delete();
        $this->dispatch('success', title: 'Artigo desativado com sucesso!');
    }

    public function restoreArticle($articleId)
    {
        $article = Article::withTrashed()->find($articleId);
        $article->restore();
        $this->dispatch('success', title: 'Artigo restaurado com sucesso!');
    }

    public function deleteArticle($articleId)
    {
        $article = Article::withTrashed()->find($articleId);

        // Desabilitando o "force delete" caso o artigo não esteja na lixeira
        if ($article->trashed()) {
            $article->forceDelete();
            $this->dispatch('success', title: 'Artigo excluído permanentemente!');
        } else {
            $this->dispatch('error', title: 'Este artigo não pode ser excluído permanentemente porque não está desativado.');
        }
    }

    public function goToPage($page)
    {
        if ($page > 0 && $page <= $this->totalPages) {
            $this->currentPage = $page;
        }
    }
}
