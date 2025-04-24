<?php

namespace App\Livewire\Pages\Administrator;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageUsers extends Component
{
    use WithPagination;
    public $currentPage = 1;
    public $totalPages;

    protected $paginationTheme = 'tailwind';

    public function softDeleteUser($userId)
    {
        $user = User::find($userId);
        $user->delete();
        $this->dispatch('success', title: 'Usuário desativado com sucesso!');
    }

    public function restoreUser($userId)
    {
        $user = User::withTrashed()->find($userId);
        $user->restore();
        $this->dispatch('success', title: 'Usuário restaurado com sucesso!');
    }

    public function deleteUser($userId)
    {
        $user = User::withTrashed()->find($userId);

        if ($user->trashed()) {
            $user->forceDelete();
            $this->dispatch('success', title: 'Usuário excluído permanentemente!');
        } else {
            $this->dispatch('error', title: 'Este usuário precisa ser desativado antes de ser excluído permanentemente.');
        }
    }

    public function goToPage($page)
    {
        if ($page > 0 && $page <= $this->totalPages) {
            $this->currentPage = $page;
        }
    }

    public function render()
    {
        $users = User::with('developer')->withTrashed()->paginate(10);
        $this->totalPages = $users->lastPage();

        return view('livewire.pages.administrator.manage-users', compact('users'))->layout('layouts.guest');
    }
}
