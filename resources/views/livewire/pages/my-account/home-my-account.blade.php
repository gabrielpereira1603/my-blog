<div class="max-w-7xl mx-auto px-4 py-6">
    @if (auth()->user()->developer)
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
                <div class="mt-8 relative">
                    <div class="absolute right-10 top-0">
                        <button class="text-[#1F2937] bg-[#14B8A6] px-5 py-1 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M17.293 2.707a1 1 0 011.414 1.414L8.707 13H6v-2.707L13.586 2.707a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Editar suas informações
                        </button>
                    </div>

                    <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Meu Perfil de Autor</h3>

                    <div class="flex items-center gap-4">
                        <!-- Imagem de Perfil -->
                        <img src="{{ auth()->user()->developer->photo }}" alt="Foto de Perfil" class="w-24 h-24 rounded-full object-cover">

                        <!-- Informações do Developer -->
                        <div>
                            <p class="text-lg font-medium text-[#1F2937]">{{ auth()->user()->developer->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->developer->bio }}</p>
                        </div>
                    </div>

                    <!-- Indicador de atividade -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-[#1F2937] mb-2">Atividade de Posts</h4>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#14B8A6] h-2 rounded-full"
                                 style="width: {{ $articlesCount * 0.50 }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Você já escreveu {{ $articlesCount }} artigos.</p>
                    </div>
                </div>
        </div>
        <!-- Artigos vinculados -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">
                <!-- Artigos vinculados -->
                <div class="lg:col-span-2">
                    <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Artigos vinculados</h3>
                    @forelse ($developerArticles as $article)
                        <div class="mb-4 p-4 bg-white rounded-xl shadow">
                            <h4 class="text-lg font-semibold text-[#14B8A6]">{{ $article->title }}</h4>
                            <p class="text-sm text-gray-500 mb-2">{{ $article->published_at->format('d/m/Y') }}</p>

                            <div class="flex items-center flex-wrap gap-2">
                                @foreach ($article->developers as $dev)
                                    <div class="flex items-center gap-2 bg-[#F9FAFB] px-3 py-1 rounded-full shadow-sm">
                                        <svg class="w-4 h-4 text-[#14B8A6]" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M5.121 17.804A8.966 8.966 0 0012 21c2.254 0 4.304-.832 5.879-2.196M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $dev->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Nenhum artigo encontrado.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $developerArticles->links() }}
                    </div>
                </div>


                <!-- Mais postadas -->
                <div>
                    <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Categorias mais postadas</h3>
                    <ul class="space-y-2">
                        @foreach ($topCategories as $category)
                            <li class="bg-[#F3F4F6] px-4 py-2 rounded-full text-[#14B8A6] font-medium shadow">
                                {{ $category->name }} ({{ $category->articles_count }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        <!-- Últimos posts -->
        <div class="mt-10">
                <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Últimos 4 artigos publicados</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($latestArticles as $article)
                        <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between">
                            <h4 class="text-base font-semibold text-[#1F2937]">{{ $article->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $article->published_at->format('d M Y') }}</p>
                            <a href="#" class="text-sm text-[#14B8A6] mt-2 hover:underline">Ver artigo →</a>
                        </div>
                    @endforeach
                </div>
            </div>
    @endif
</div>
