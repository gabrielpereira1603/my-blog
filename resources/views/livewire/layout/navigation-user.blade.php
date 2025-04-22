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
                    <a href="{{ route('dashboard') }}">
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
                <!-- Menu Mobile -->
                <button @click="open = true" class="sm:hidden text-[#1F2937] focus:outline-none">
                    ☰
                </button>

                <!-- Logo centralizada para telas pequenas -->
                <div class="flex sm:hidden w-full justify-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('/logos/logo-transparante.png') }}" alt="Logo transparente" width="100px"/>
                    </a>
                </div>

                <!-- Links centrais (somente para telas grandes) -->
                <div class="hidden sm:flex flex-1 justify-center transform -translate-x-1/2">
                    <ul class="flex items-center text-center gap-5">
                        <li><a href="#"><x-instagram-icon widht="20px" height="20px" color="#1F2937"/></a></li>
                        <li><a href="#"><x-whatsapp-icon widht="20px" height="20px" color="#1F2937"/></a></li>
                    </ul>
                </div>

                <!-- Logo centralizada para telas grandes -->
                <div class="hidden sm:flex w-1/3 justify-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('/logos/logo-transparante.png') }}" alt="Logo transparente" width="100px"/>
                    </a>
                </div>

                <!-- Dropdown no lado direito -->
                <div class="hidden sm:flex w-1/3 justify-end">
                    <ul class="flex gap-5 text-black">
                        <li>
                            <span>
                                <x-user-icon widht="20px" height="20px" color="#1F2937"/>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <ul class="hidden bg-[#14B8A6] text-[#1F2937] uppercase font-bold sm:flex justify-around items-center text-center gap-5 p-6">
            <li><a href="#">Início</a></li>
            <li><a href="#">Novidades</a></li>
            <li><a href="#">Artigos</a></li>
            <li><a href="#">Top 10</a></li>
        </ul>
    @endif

    <!-- Menu Mobile Tela Cheia -->
    <div x-show="open" class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center text-[#1F2937] text-xl space-y-6">
        <button @click="open = false" class="absolute top-5 right-5 text-3xl">✕</button>
        <ul class="text-center space-y-4">
            <li><a href="#">Início</a></li>
            <li><a href="#">Novidades</a></li>
            <li><a href="#">Artigos</a></li>
            <li><a href="#">Login</a></li>
            <li><a href="#">Criar Conta</a></li>
        </ul>
    </div>
</nav>
