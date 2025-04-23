<?php

namespace App\Trait\MyAccount\HomeMyAccount;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

trait HandlesUpdateInfoUserTrait
{
    public bool $open = false;

    public function updateUser()
    {
        try {
            $this->form->validate();

            $this->form->user->update([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'role' => $this->form->role,
            ]);

            if ($this->form->user->developer) {
                $developer = $this->form->user->developer;

                if ($this->form->photo) {
                    $oldPhotoPath = str_replace(asset('storage/'), '', $developer->photo);
                    if (Storage::disk('public')->exists($oldPhotoPath)) {
                        Storage::disk('public')->delete($oldPhotoPath);
                    }

                    $path = $this->form->photo->store('profile_images', 'public');
                    $developer->photo = asset('storage/' . $path);
                }

                $developer->bio = $this->form->bio;
                $developer->save();
            }

            $this->resetForm();
            $this->dispatch('success', title: 'Informações atualizadas com sucesso!');
        } catch (ValidationException $e) {
            $message = collect($e->errors())->flatten()->first();
            $this->dispatch('error', title: $message);
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar dados do usuário: ' . $e->getMessage());
            $this->dispatch('error', title: $e->getMessage());
        }
    }

    public function startEdit()
    {
        $this->open = true;
    }

    public function startForm()
    {
        $this->extracted();
        $this->articlesCount = optional($this->form->user->developer)->articles->count();
    }
    public function resetForm()
    {
        $this->extracted();

        $this->open = false;
    }


    public function extracted(): void
    {
        $this->form->name = $this->form->user->name;
        $this->form->email = $this->form->user->email;
        $this->form->role = $this->form->user->role;
        $this->form->bio = optional($this->form->user->developer)->bio;

        $this->form->photo = null;
    }
}
