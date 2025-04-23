<?php

namespace App\Livewire\Pages\MyAccount;

use App\Livewire\Forms\MyAccount\EditInfoUserForm;
use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use App\Trait\MyAccount\HomeMyAccount\HandlesUpdateInfoUserTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HomeMyAccount extends Component
{
    use WithPagination;
    use WithFileUploads;

    use HandlesUpdateInfoUserTrait;

    public EditInfoUserForm $form;
    public int $articlesCount = 0;

    public function mount()
    {
        $this->form->user = Auth::user();
        $this->startForm();
    }

    public function render()
    {
        $user = Auth::user();

        $developer = $user->developer;

        $developerArticles = $developer
            ? $developer->articles()->latest()->paginate(5)
            : collect();

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
