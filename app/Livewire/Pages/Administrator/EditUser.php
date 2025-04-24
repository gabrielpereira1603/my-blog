<?php

namespace App\Livewire\Pages\Administrator;

use App\Livewire\Forms\MyAccount\EditInfoUserForm;
use App\Models\Category;
use App\Models\User;
use App\Trait\MyAccount\HomeMyAccount\HandlesUpdateInfoUserTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EditUser extends Component
{
    use WithPagination;
    use WithFileUploads;

    use HandlesUpdateInfoUserTrait;

    public EditInfoUserForm $form;

    public int $articlesCount = 0;

    public function mount($user_id)
    {
        $this->form->user = User::findOrFail($user_id);
        $this->startForm();
    }

    public function render()
    {
        $user = $this->form->user;

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

        return view('livewire.pages.administrator.edit-user', [
            'developerArticles' => $developerArticles,
            'topCategories' => $topCategories,
            'latestArticles' => $latestArticles,
        ])->layout('layouts.guest');
    }
}
