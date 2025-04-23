<div class="px-4 py-1 max-w-7xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 mt-10 overflow-visible relative">
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#14B8A6] mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <h3 class="text-xl font-semibold text-[#1F2937]">Meus Artigos</h3>
        </div>

        <div class="overflow-x">
            <table class="min-w-full table-auto">
                <thead class="bg-[#14B8A6] text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Título</th>
                    <th class="px-4 py-2 text-left">Publicado em</th>
                    <th class="px-4 py-2 text-left">Categorias</th>
                    <th class="px-4 py-2 text-left">Autores</th>
                    <th class="px-4 py-2 text-left">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($articles as $article)
                    <tr class="border-b relative group">
                        <td class="px-4 py-2">{{ $article->title }}</td>
                        <td class="px-4 py-2">{{ $article->published_at->format('d M Y') }}</td>

                        {{-- CATEGORIAS --}}
                        <td class="px-4 py-2 relative">
                            <div x-data="{ showCategories: false }" class="relative">
                                <div @mouseenter="showCategories = true" @mouseleave="showCategories = false">
                                    @php $count = count($article->categories); @endphp
                                    @if ($count > 0)
                                        <span class="bg-[#F3F4F6] text-[#14B8A6] text-xs font-semibold px-2 py-1 rounded-full shadow-sm">{{ $article->categories[0]->name }}</span>
                                        @if ($count > 1)
                                            <span class="text-xs text-gray-500">+{{ $count - 1 }}</span>
                                        @endif
                                    @endif

                                    <div x-show="showCategories" x-transition
                                         class="absolute z-50 bg-white border border-gray-200 shadow-xl rounded-lg p-4 top-full mt-2 w-64">
                                        <h4 class="text-sm font-semibold text-[#14B8A6] mb-1">Categorias</h4>
                                        <ul>
                                            @foreach ($article->categories as $category)
                                                <li class="text-xs text-gray-600">{{ $category->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- AUTORES --}}
                        <td class="px-4 py-2 relative">
                            <div x-data="{ showAuthors: false }" class="relative">
                                <div @mouseenter="showAuthors = true" @mouseleave="showAuthors = false">
                                    <div class="flex items-center gap-1 flex-wrap">
                                        @foreach ($article->developers->take(2) as $developer)
                                            <img src="{{ $developer->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($developer->name) }}" class="w-6 h-6 rounded-full border-2 border-white -ml-2" alt="{{ $developer->name }}">
                                        @endforeach
                                        @if ($article->developers->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $article->developers->count() - 2 }}</span>
                                        @endif
                                    </div>

                                    <div x-show="showAuthors" x-transition
                                         class="absolute z-50 bg-white border border-gray-200 shadow-xl rounded-lg p-4 top-full mt-2 w-64">
                                        <h4 class="text-sm font-semibold text-[#14B8A6] mb-1">Participantes</h4>
                                        <ul>
                                            @foreach ($article->developers as $developer)
                                                <li class="text-xs text-gray-600">{{ $developer->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- AÇÕES --}}
                        <td class="px-4 py-2">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="text-[#14B8A6] font-medium hover:text-[#1F2937]">
                                    Ações
                                    <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 9l6 6 6-6" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                     class="absolute z-50 bg-white border border-gray-300 rounded-lg shadow-lg right-0 mt-2 w-40">
                                    <ul class="py-2">
                                        @if ($article->trashed())
                                            <li><button wire:click="restoreArticle({{ $article->id }})"
                                                        class="px-4 py-2 text-green-600 hover:text-green-800 w-full text-left">Ativar</button></li>
                                            <li><button wire:click="deleteArticle({{ $article->id }})"
                                                        class="px-4 py-2 text-red-600 hover:text-red-800 w-full text-left">Excluir</button></li>
                                        @else
                                            <li>
                                                <a href="{{ route('edit.article', $article->id) }}"
                                                   class="px-4 py-2 text-yellow-600 hover:text-yellow-800 w-full text-left">Editar</a>
                                            </li>
                                            <li><button wire:click="softDeleteArticle({{ $article->id }})"
                                                        class="px-4 py-2 text-yellow-600 hover:text-yellow-800 w-full text-left">Desativar</button></li>
                                            <li><a href="{{ route('view-one.article', $article->id) }}"
                                                   class="px-4 py-2 text-blue-600 hover:text-blue-800 w-full text-left">Visualizar</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2 text-gray-500">Você ainda não tem artigos.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

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
