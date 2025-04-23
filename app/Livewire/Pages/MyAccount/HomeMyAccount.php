<?php

namespace App\Livewire\Pages\MyAccount;

use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class HomeMyAccount extends Component
{
    use WithPagination;

    public string $name = '';
    public string $email = '';
    public string $bio = '';
    public int $articlesCount = 0; // Contagem de artigos do Developer
    public bool $open = false; // Controle de exibição do formulário de edição

    // Método chamado ao carregar o componente
    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        // Se o usuário for developer, carrega os dados específicos
        if ($user->developer) {
            $this->bio = $user->developer->bio;
            $this->articlesCount = $user->developer->articles()->count();
        }
    }

    // Método para atualizar as informações do usuário
    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        session()->flash('message', 'Informações atualizadas com sucesso!');
    }

    public function render()
    {
        $user = Auth::user();
        $developer = $user->developer;

        // Carrega os artigos do developer
        $developerArticles = $developer
            ? $developer->articles()->latest()->paginate(5)
            : collect();

        // Carrega as categorias com mais artigos do developer
        $topCategories = $developer
            ? Category::whereHas('articles.developers', function ($query) use ($developer) {
                $query->where('developers.id', $developer->id);
            })
                ->withCount(['articles as articles_count' => function ($query) use ($developer) {
                    $query->whereHas('developers', function ($q) use ($developer) {
                        $q->where('developers.id', $developer->id);
                    });
                }])
                ->orderByDesc('articles_count')
                ->take(5)
                ->get()
            : collect();

        // Carrega os últimos artigos do developer
        $latestArticles = $developer
            ? $developer->articles()->latest()->take(4)->get()
            : collect();

        return view('livewire.pages.my-account.home-my-account', [
            'developerArticles' => $developerArticles,
            'topCategories' => $topCategories,
            'latestArticles' => $latestArticles,
        ])->layout('layouts.guest');
    }
}
