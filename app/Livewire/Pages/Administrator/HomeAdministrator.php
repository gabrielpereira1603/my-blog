<?php

namespace App\Livewire\Pages\Administrator;

use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomeAdministrator extends Component
{
    public $articlesPerMonth = [];
    public $topUsers = [];
    public $counts = [];

    public function mount()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $this->articlesPerMonth = Article::selectRaw('MONTH(published_at) as month, COUNT(*) as count')
            ->whereNotNull('published_at')
            ->where('published_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('MONTH(published_at)'))
            ->pluck('count', 'month')
            ->toArray();

        $this->topUsers = Developer::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(5)
            ->get()
            ->map(function ($dev) {
                return [
                    'name' => $dev->name,
                    'articles_count' => $dev->articles_count,
                ];
            })->toArray();

        $this->counts = [
            'users' => User::count(),
            'developers' => Developer::count(),
            'articles' => Article::count(),
        ];
    }

    public function render()
    {
        $months = [];
        $postsPerMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthNum = $date->month;
            $months[] = $date->format('M');
            $postsPerMonth[] = $this->articlesPerMonth[$monthNum] ?? 0;
        }

        $topUsersNames = array_column($this->topUsers, 'name');
        $topUsersPosts = array_column($this->topUsers, 'articles_count');

        $categoryLabels = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->pluck('name')
            ->toArray();

        $categoryCounts = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->pluck('articles_count')
            ->toArray();

        return view('livewire.pages.administrator.home-administrator', [
            'months' => $months,
            'postsPerMonth' => $postsPerMonth,
            'topUsersNames' => $topUsersNames,
            'topUsersPosts' => $topUsersPosts,
            'counts' => $this->counts,
            'categoryLabels' => $categoryLabels,
            'categoryCounts' => $categoryCounts,
        ])->layout('layouts.guest');
    }

}
