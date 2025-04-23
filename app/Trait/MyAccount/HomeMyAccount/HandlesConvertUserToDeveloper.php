<?php

namespace App\Trait\MyAccount\HomeMyAccount;

trait HandlesConvertUserToDeveloper
{
    public bool $showDeveloperForm = false;

    public function becomeAuthor()
    {
        $this->validate([
            'form.bio' => 'required|string|min:10',
            'form.photo' => 'nullable|image|max:2048',
        ]);

        $user = $this->form->user;

        $photoPath = null;
        if ($this->form->photo) {
            $photoPath = $this->form->photo->store('profile_images', 'public');
            $photoPath = asset('storage/' . $photoPath);
        }

        $user->developer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $photoPath,
            'bio' => $this->form->bio,
        ]);

        $this->showDeveloperForm = false;
        $this->dispatch('success', title: 'Parabéns! Agora você é um autor.');
    }
}
