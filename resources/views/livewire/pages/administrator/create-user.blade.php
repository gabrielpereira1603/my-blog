<div class="max-w-4xl mx-auto mt-10 space-y-8 px-2 pt-14">
    <h2 class="text-3xl font-bold text-[#14B8A6]" >Criar Novo Usuário</h2>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col">
                <label for="name" class="text-sm font-medium text-gray-700">Nome</label>
                <input id="name" type="text" wire:model.defer="form.name" class="mt-1 p-3 border border-[#14B8A6] rounded-lg focus:ring-2 focus:ring-[#14B8A6]" placeholder="Nome completo" required>
                @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" wire:model.defer="form.email" class="mt-1 p-3 border border-[#14B8A6] rounded-lg focus:ring-2 focus:ring-[#14B8A6]" placeholder="email@exemplo.com" required>
                @error('form.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label for="password" class="text-sm font-medium text-gray-700">Senha</label>
                <input id="password" type="password" wire:model.defer="form.password" class="mt-1 p-3 border border-[#14B8A6] rounded-lg focus:ring-2 focus:ring-[#14B8A6]" placeholder="********" required>
                @error('form.password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label for="role" class="text-sm font-medium text-gray-700">Função</label>
                <select id="role" wire:model.defer="form.role" class="mt-1 p-3 border border-[#14B8A6] rounded-lg focus:ring-2 focus:ring-[#14B8A6]" required>
                    <option value="administrator">Administrador</option>
                    <option value="user">Usuário</option>
                </select>
                @error('form.role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="space-y-2">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" wire:model.live="form.isDeveloper" class="form-checkbox text-[#14B8A6] rounded-lg" >
                <span class="text-sm text-gray-700">Este usuário será um autor?</span>
            </label>
        </div>

        @if ($form->isDeveloper)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#F3F4F6] p-6 rounded-xl shadow-lg">
                <div class="flex flex-col">
                    <label for="bio" class="text-sm font-medium text-gray-700">Bio</label>
                    <input id="bio" type="text" wire:model.live="form.bio" class="mt-1 p-3 border border-[#14B8A6] rounded-lg focus:ring-2 focus:ring-[#14B8A6]" placeholder="Escreva uma breve biografia">
                    @error('form.bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col">
                    <label for="photo" class="text-sm font-medium text-gray-700">Foto de Perfil</label>
                    <input id="photo" type="file" wire:model.live="form.photo" class="mt-1 p-3 border border-[#14B8A6] rounded-lg focus:ring-2 focus:ring-[#14B8A6]">
                    @if ($form->photo)
                        <div class="mt-2">
                            <span class="block text-sm font-medium text-gray-700">Pré-visualização:</span>
                            <img src="{{ $form->photo->temporaryUrl() }}" class="h-24 w-24 rounded-full mt-2 ring-2 ring-[#14B8A6]">
                        </div>
                    @endif
                    @error('form.photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center">
            <a href="{{ route('manage-user') }}" class="text-sm text-gray-500 hover:text-[#14B8A6]">Cancelar</a>
            <button primary type="submit" class="px-4 py-2 bg-[#14B8A6] hover:bg-[#1F2937] text-white rounded-xl shadow-md font-semibold transition-colors">Salvar usuário</button>
        </div>
    </form>

    @script
    <script>
        $wire.on('success', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: event.title,
                confirmButtonText: 'Ok'
            });
        });

        $wire.on('error', (event) => {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: event.title,
                confirmButtonText: 'Ok'
            });
        });

    </script>
    @endscript
</div>
