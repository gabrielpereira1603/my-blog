<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>
@php
    $menuSections = [
        [
            'label' => 'Navegação',
            'icon' => '',
            'items' => [
                ['label' => 'Início', 'href' => ''],
                ['label' => 'Novidades', 'href' => ''],
                ['label' => 'Artigos', 'href' => ''],
                ['label' => 'Top 10', 'href' => ''],
            ]
        ],
        [
            'label' => 'Conta',
            'icon' => '',
            'items' => [
                ['label' => 'Login', 'href' => ''],
                ['label' => 'Criar Conta', 'href' => ''],
            ]
        ],
        [
            'label' => 'Categorias',
            'icon' => '',
            'items' => [
                ['label' => 'Inteligência Artificial', 'href' => ''],
                ['label' => 'Desenvolvimento Web', 'href' => ''],
                ['label' => 'Mobile', 'href' => ''],
                ['label' => 'DevOps', 'href' => ''],
                ['label' => 'Cloud', 'href' => ''],
            ]
        ],
    ];
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-[#1F2937] fixed top-0 left-0 w-full z-50 shadow-md">
    @if (Auth::check())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Menu Mobile -->
                <button @click="open = true" class="sm:hidden text-[#1F2937] focus:outline-none">
                    ☰
                </button>

                <!-- Logo centralizada -->
                <div class="w-full sm:w-1/3 flex justify-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('/logos/logo-transparante.png') }}" alt="Logo transparente" width="100px"/>
                    </a>
                </div>

                <!-- Dropdown no lado direito -->
                <div class="hidden sm:flex w-1/3 justify-end">
                    <ul class="text-black flex gap-4">
                        <li>Artigos</li>
                        <li>b</li>
                        <li>c</li>
                    </ul>
                </div>
            </div>
        </div>
    @else

        <div class="max-w-7xl p-5 mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center relative">

                <button @click="open = !open" class="sm:hidden text-[#1F2937] focus:outline-none">
                    <template x-if="!open">
                        <span>☰</span>
                    </template>
                    <template x-if="open">
                        <span>✕</span>
                    </template>
                </button>

                <!-- Logo centralizada para telas pequenas -->
                <div class="flex sm:hidden w-full justify-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('/logos/logo-transparante.png') }}" alt="Logo transparente" width="100px"/>
                    </a>
                </div>

                <!-- Links centrais (somente para telas grandes) -->
                <div class="hidden sm:flex flex-1 justify-center transform -translate-x-1/2">
                    <ul class="flex items-center text-center gap-5">
                        <li><a href="#"><x-instagram-icon widht="20px" height="20px" color="#1F2937"/></a></li>
                    </ul>
                </div>

                <!-- Logo centralizada para telas grandes -->
                <div class="hidden sm:flex w-1/3 justify-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('/logos/logo-transparante.png') }}" alt="Logo transparente" width="100px"/>
                    </a>
                </div>

                <!-- Dropdown no lado direito -->
                <div class="hidden sm:flex w-1/3 justify-end">
                    <ul class="flex gap-5 text-black">
                        <li>
                            <a href="{{ route('login') }}">
                                <x-user-icon widht="20px" height="20px" color="#1F2937"/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        @unless(Route::is('login', 'register'))
            <ul class="hidden bg-[#14B8A6] text-[#1F2937] uppercase font-bold sm:flex justify-around items-center text-center gap-5 p-6">
                <li><a href="#">Início</a></li>
                <li><a href="#">Novidades</a></li>
                <li><a href="#">Artigos</a></li>
                <li><a href="#">Top 10</a></li>
            </ul>
        @endunless
    @endif

    <!-- Menu Mobile Tela Cheia -->
    <div x-show="open" x-transition class="sm:hidden bg-[#F9FAFB] dark:bg-[#1E293B] border-l-4 border-[#14B8A6] px-4 py-6 shadow-md relative z-50">
        @foreach ($menuSections as $section)
            <div class="mb-4">
                <p class="flex items-center gap-2 text-[#1F2937] dark:text-[#F8FAFC] font-semibold mb-2">
                    @if (!empty($section['icon']))
                        <x-dynamic-component :component="$section['icon']" width="20px" height="20px" color="currentColor" />
                    @endif
                    {{ $section['label'] }}
                </p>

                <ul class="space-y-2 pl-4 border-l-2 border-[#14B8A6]">
                    @foreach ($section['items'] as $item)
                        <li>
                            <a href="{{ $item['href'] }}"
                               class="block text-[#1F2937] dark:text-[#F8FAFC] hover:text-[#F8FAFC] transition duration-150">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <div class="mt-6">
            <button class="w-full bg-[#14B8A6] p-3 rounded-md hover:bg-gray-600 transition-colors duration-200">
                <p class="text-center text-white font-bold">Junte-se a nós</p>
            </button>
        </div>
    </div>
</nav>
