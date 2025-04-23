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
            'items' => Auth::check() ? [
                ['label' => 'Minha conta', 'href' => route('home.my_account')],
            ] : [
                ['label' => 'Login', 'href' => route('login')],
                ['label' => 'Criar Conta', 'href' => route('register')],
            ],
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

                <div x-data="{ open: false }" class="hidden sm:flex w-1/3 justify-end relative">
                    <button @click="open = !open" class="focus:outline-none transition hover:scale-105">
                        <x-user-icon width="20px" height="20px" color="#1F2937"/>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute top-8 right-0 w-52 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 overflow-hidden"
                    >
                        <a href="{{ route('home.my_account') }}"
                           class="flex items-center gap-2 px-4 py-3 text-sm text-[#1F2937] hover:bg-[#14B8A6]/10 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#14B8A6]" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 1115 0H4.5z" />
                            </svg>
                            Minha conta
                        </a>
                        @if(Auth::User()->developer)
                            <a href="{{ route('view-my-articles') }}"
                               class="flex items-center gap-2 px-4 py-3 text-sm text-[#1F2937] hover:bg-[#14B8A6]/10 transition-all duration-150">
                                <x-newspaper-icon width="16px" height="16px" color="#14B8A6"/>
                                Meus Artigos
                            </a>
                        @endif

                        <button wire:click="logout" class="w-full text-start">
                            <div
                                class="flex items-center gap-2 px-4 py-3 text-sm text-[#DC2626] hover:bg-[#DC2626]/10 transition-all duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#DC2626]" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21H13.5a2.25 2.25 0 002.25-2.25V15m3-3h-9m0 0l3-3m-3 3l3 3" />
                                </svg>
                                Sair
                            </div>
                        </button>
                    </div>
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
        <div class="mt-6 flex flex-col gap-2">
            @if(Auth::check() && !Auth::user()->developer)
            <a href="{{ route('home.my_account') }}">
                <button class="w-full bg-[#14B8A6] p-3 rounded-md hover:bg-[#0D9488] transition-colors duration-200">
                    <p class="text-center text-white font-bold">
                        Se tornar autor!
                    </p>
                </button>
            </a>
            @endif

            @if(Auth::check())
                <button wire:click="logout" type="button" class="w-full bg-red-500 p-3 rounded-md hover:bg-red-600 transition-colors duration-200">
                    <p class="text-center text-white font-bold">Sair da sua conta</p>
                </button>
            @endif
        </div>
    </div>
</nav>
