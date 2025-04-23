<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $role = auth()->user()->role;

    if ($role === 'administrator') {
        $this->redirectIntended(default: route('home.my_account', absolute: false), navigate: true);
    } else {
        $this->redirectIntended(default: route('home.my_account', absolute: false), navigate: true);
    }
};
?>

<section class="h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border-t-8 border-[#14B8A6] relative overflow-hidden">
        <div class="absolute -top-12 -right-12 bg-[#14B8A6]/10 rounded-full w-40 h-40 z-0"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-center text-[#1F2937] mb-4">Bem-vindo de volta! 🎉</h2>
            <p class="text-center text-gray-600 mb-4">Entre com suas credenciais para continuar.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="space-y-4">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center text-sm text-gray-600">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-[#14B8A6] shadow-sm focus:ring-[#14B8A6]" name="remember">
                        <span class="ml-2">Lembrar-me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#14B8A6] hover:underline" href="{{ route('password.request') }}" wire:navigate>
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div>
                    <button class="w-full justify-center bg-[#14B8A6] hover:bg-[#0D9488] text-white font-semibold py-2 rounded-md shadow-md transition">
                        Entrar
                    </button>
                </div>
            </form>

            <p class="text-sm text-center text-gray-500 mt-4">Não tem uma conta? <a href="{{ route('register') }}" class="text-[#14B8A6] font-medium hover:underline">Cadastre-se</a></p>
        </div>
    </div>
</section>
