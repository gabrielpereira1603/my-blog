<?php

namespace App\Livewire\Pages\Administrator;

use App\Livewire\Forms\Administrator\CreateUserForm;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateUser extends Component
{
    use WithFileUploads;

    public CreateUserForm $form;

    public function save()
    {
        $this->form->validate();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => Hash::make($this->form->password),
                'role' => $this->form->role,
            ]);

            if ($this->form->isDeveloper) {
                $photoPath = $this->form->photo?->store('developers/photos', 'public');

                Developer::create([
                    'name' => $this->form->name,
                    'email' => $this->form->email,
                    'user_id' => $user->id,
                    'bio' => $this->form->bio,
                    'photo' => $photoPath ? asset("storage/{$photoPath}") : null,
                ]);
            }

            DB::commit();

            $this->redirectRoute('manage-user');
            $this->dispatch('success', title: 'Usuário criado com sucesso!');
        } catch (ValidationException $e) {
            DB::rollBack();
            $message = collect($e->errors())->flatten()->first();
            $this->dispatch('error', title: $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            $this->dispatch('error', title: 'Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.administrator.create-user', [
        ])->layout('layouts.guest');
    }
}
