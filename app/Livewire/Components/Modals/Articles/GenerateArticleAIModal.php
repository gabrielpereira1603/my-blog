<?php

namespace App\Livewire\Components\Modals\Articles;

use App\Models\Category;
use App\Service\Google\GenerativeLanguage\GenerativeLanguageService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class GenerateArticleAIModal extends Component
{
    #[Validate('required|string|min:10')]
    public $description = '';

    #[Validate('required|array|min:1')]
    public $selectedCategories = [];

    public $categories;

    protected $messages = [
        'selectedCategories.required' => 'Escolha pelo menos uma categoria.',
        'selectedCategories.array' => 'Formato inválido para categorias.',
        'selectedCategories.min' => 'Escolha pelo menos uma categoria.',
    ];

    protected GenerativeLanguageService $generativeLanguageService;

    public function __construct()
    {
        $this->generativeLanguageService = new GenerativeLanguageService();
    }

    public function mount()
    {
        $this->categories = Category::all();
    }
    public function generate()
    {
        try {
            $this->validate();

            $this->dispatch('start-loading');

            $categoryNames = Category::whereIn('id', $this->selectedCategories)->pluck('name')->toArray();
            $categoryList = implode(', ', $categoryNames);
            $news = $this->generativeLanguageService->generateNews($categoryList, $this->description);

            if ($news === null) {
                throw new \Exception('Erro ao gerar artigo: Nenhuma resposta válida recebida do serviço de IA.');
            }

            $this->dispatch('article-generated', [
                'title' => $news['title'],
                'content' => $news['content'],
                'categories' => $categoryList
            ]);

            $this->dispatch('close-modal', 'generate-article-ai-modal');
        } catch (\Throwable $e) {
            Log::error('Erro ao gerar artigo: ' . $e->getMessage());
            $this->dispatch('error', title: 'Erro ao gerar artigo: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.components.modals.articles.generate-article-a-i-modal');
    }
}
