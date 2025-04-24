<div class="px-4 py-1 max-w-7xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 mt-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-[#1F2937]">Gerenciamento de Usuários</h3>

            <a href="{{ route('create-user') }}"
               class="inline-flex items-center gap-2 bg-[#14B8A6] text-white px-4 py-2 rounded-xl shadow hover:bg-[#0D9488] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Criar novo usuário
            </a>
        </div>


        <table class="min-w-full table-auto">
            <thead class="bg-[#14B8A6] text-white">
            <tr>
                <th class="px-4 py-2 text-left">Nome</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Função</th>
                <th class="px-4 py-2 text-left">É Developer?</th>
                <th class="px-4 py-2 text-left">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr class="border-b group">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                    <td class="px-4 py-2">
                        @if ($user->developer)
                            <span class="text-green-600 font-semibold">Sim</span>
                        @else
                            <span class="text-gray-500">Não</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-[#14B8A6] font-medium hover:text-[#1F2937]">
                                Ações
                                <svg class="inline-block w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute z-50 bg-white border border-gray-300 rounded-lg shadow-lg right-0 mt-2 w-40">
                                <ul class="py-2">
                                    @if ($user->trashed())
                                        <li><button wire:click="restoreUser({{ $user->id }})" class="px-4 py-2 text-green-600 hover:text-green-800 w-full text-left">Ativar</button></li>
                                        <li><button wire:click="deleteUser({{ $user->id }})" class="px-4 py-2 text-red-600 hover:text-red-800 w-full text-left">Excluir</button></li>
                                    @else
                                        <li><a href="{{ route('manage-user.user-id', $user->id) }}" class="px-4 py-2 text-blue-600 hover:text-blue-800 w-full text-left">Editar</a></li>

                                        <li><button wire:click="softDeleteUser({{ $user->id }})" class="px-4 py-2 text-red-600 hover:text-red-800 w-full text-left">Desativar</button></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center px-4 py-2 text-gray-500">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-8 flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
            <button wire:click="goToPage({{ $currentPage - 1 }})"
                    class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition"
                {{ $currentPage == 1 ? 'disabled' : '' }}>
                ← Anterior
            </button>

            <span class="text-gray-700 text-sm">Página {{ $currentPage }}</span>

            <button wire:click="goToPage({{ $currentPage + 1 }})"
                    class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition"
                {{ $currentPage >= $totalPages ? 'disabled' : '' }}>
                Próxima →
            </button>
        </div>
    </div>

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
