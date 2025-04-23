<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    Auth::login($user);

    $this->redirect(route('dashboard', absolute: false), navigate: true);
};

?>

<section class="h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border-t-8 border-[#14B8A6] relative overflow-hidden">
        {{-- Ilustração decorativa --}}
        <div class="absolute -top-12 -right-12 bg-[#14B8A6]/10 rounded-full w-40 h-40 z-0"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-center text-[#1F2937] mb-4">Crie sua conta 🚀</h2>
            <p class="text-center text-gray-600 mb-4">Preencha os campos abaixo para começar.</p>

            <form wire:submit="register" class="space-y-4">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between">
                    <a class="text-sm text-[#14B8A6] hover:underline" href="{{ route('login') }}" wire:navigate>
                        Já tem uma conta?
                    </a>

                    <button class="bg-[#14B8A6] hover:bg-[#0D9488] text-white font-semibold py-2 px-4 rounded-md shadow-md transition">
                        Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
