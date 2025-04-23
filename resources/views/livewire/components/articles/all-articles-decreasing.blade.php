<div class="overflow-y-hidden px-4 py-1 max-w-7xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 mt-10">
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#14B8A6] mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <h3 class="text-xl font-semibold text-[#1F2937]">Categorias</h3>
        </div>

        <div class="flex flex-wrap gap-3 mb-6">
            @foreach ($categories as $category)
                <button wire:click="toggleCategory({{ $category->id }})"
                        class="inline-block px-4 py-2 rounded-xl text-sm font-medium shadow-sm transition-colors duration-200
            {{ in_array($category->id, $selectedCategories)
                ? 'bg-[#14B8A6] text-white'
                : 'bg-[#F3F4F6] text-[#14B8A6] hover:bg-[#14B8A6]/90 hover:text-white' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
    <input
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Pesquisar artigos..."
        class="mb-6 mt-4 px-4 py-2 border border-[#14B8A6] rounded-lg w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6]">

    <div class="flex justify-end mb-6">
        <button wire:click="toggleOrder"
                class="px-4 py-2 bg-[#14B8A6] hover:bg-[#14B8A6]/90 text-white text-sm font-semibold rounded-xl transition-colors shadow-md">
            Ordenar por: {{ $orderBy === 'desc' ? 'Mais recentes' : 'Mais antigos' }}
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($articles as $article)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col transition-transform hover:-translate-y-1 hover:shadow-xl cursor-pointer">
                <img src="{{ $article->cover_image }}" alt="Capa do artigo"
                     class="w-full h-48 object-cover">

                <div class="p-4 flex flex-col justify-between flex-1">
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#14B8A6]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 000 2h8a1 1 0 100-2H6zM3 6a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6zm2 2v8h10V8H5z" clip-rule="evenodd" />
                        </svg>
                        Publicado em {{ \Carbon\Carbon::parse($article->published_at)->format('d/m/Y') }}
                    </div>

                    <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ $article->title }}</h2>

                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($article->content, 300) }}</p>
                    @if ($article->developers->isNotEmpty())
                        <div class="flex items-start sm:justify-start text-sm text-gray-700 mb-3">
                            <svg class="w-4 h-4 mr-1 mt-[0.8px] text-[#14B8A6]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a5 5 0 00-3.87 8.13A7.005 7.005 0 003 17h2a5 5 0 1110 0h2a7.005 7.005 0 00-3.13-6.87A5 5 0 0010 2z" />
                            </svg>
                            <span>Autor{{ $article->developers->count() > 1 ? 'es' : '' }}:
                                {{ $article->developers->pluck('name')->join(', ') }}
                            </span>
                        </div>
                    @endif
                    @if ($article->categories->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach ($article->categories as $category)
                                <span class="inline-block bg-[#F3F4F6] text-[#14B8A6] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <a href=""
                       class="text-[#14B8A6] font-medium hover:underline mt-auto inline-block transition-colors">
                        Ver mais →
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center text-lg">Nenhum artigo encontrado com este filtro.</p>
        @endforelse

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
