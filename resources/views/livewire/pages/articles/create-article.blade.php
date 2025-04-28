<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-[#1F2937]">Criar novo artigo</h1>
        <x-primary-button wire:click="openGenerateArticleAIModal" class="flex items-center gap-2">
            <x-artificial-intelligence-icon width="20px" height="20px" color="currentColor" />
            Gerar Artigo com IA
        </x-primary-button>
        <livewire:components.modals.articles.generate-article-a-i-modal/>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Título --}}
        <div>
            <label class="block mb-2 text-sm font-medium text-[#1F2937]">Título</label>
            <div wire:loading.class="hidden" wire:target="fillGeneratedArticle">
                <input type="text" wire:model.live="form.title"
                   placeholder="Ex: Como escolher a paleta ideal para seu projeto"
                   class="w-full px-4 py-2 border border-[#14B8A6] rounded-xl shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-[#14B8A6] focus:outline-none">
            </div>
            <div wire:loading wire:target="fillGeneratedArticle" class="w-full h-12 bg-gray-300 rounded-lg animate-pulse"></div>
        </div>

        {{-- Conteúdo --}}
        <div>
            <label class="block mb-2 text-sm font-medium text-[#1F2937]">Conteúdo</label>
            <div wire:loading.class="hidden" wire:target="fillGeneratedArticle">
                <textarea wire:model.live="form.content" rows="6"
                  placeholder="Digite o conteúdo do artigo aqui..."
                  class="w-full px-4 py-2 border border-[#14B8A6] rounded-xl shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-[#14B8A6] focus:outline-none resize-none"></textarea>
            </div>
            <div wire:loading wire:target="fillGeneratedArticle" class="w-full h-40 bg-gray-300 rounded-lg animate-pulse"></div>
        </div>

        {{-- Imagem de capa --}}
        <div>
            <label class="block mb-2 text-sm font-medium text-[#1F2937]">Imagem de capa</label>
            <input type="file" wire:model.blur="form.cover_image"
                   class="w-full text-sm text-gray-500 file:bg-[#14B8A6] file:text-white file:rounded-xl file:border-0 file:px-4 file:py-2 hover:file:bg-[#14B8A6]/90 transition-colors">
        </div>

        {{-- Preview da imagem de capa --}}
        @if($form->cover_image)
            <div class="flex flex-col items-center gap-2">
                <div class="relative">
                    <img src="{{ $form->cover_image->temporaryUrl() }}"
                         alt="Foto selecionada"
                         class="w-48 h-48 object-cover rounded-2xl shadow-lg border-2 border-[#14B8A6]">
                    <button type="button" wire:click="clearPhoto"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Categorias --}}
        <div>
            <label class="block mb-2 text-sm font-medium text-[#1F2937]">Categorias</label>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <label class="inline-flex items-center px-3 py-2 bg-white border-2 border-[#14B8A6] rounded-xl cursor-pointer shadow-sm hover:bg-[#14B8A6]/10 transition">
                        <input type="checkbox"
                               wire:model.live="form.categories"
                               value="{{ $category->id }}"
                               class="form-checkbox text-[#14B8A6] rounded focus:ring-0 focus:ring-offset-0 mr-2">
                        <span class="text-sm text-[#1F2937]">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Desenvolvedores --}}
        <div>
            <label class="block mb-2 text-sm font-medium text-[#1F2937]">Autores</label>
            <input type="text" wire:model.live.debounce.300ms="developerSearch"
                   placeholder="Buscar desenvolvedores por nome..."
                   class="w-full px-4 py-2 border border-[#14B8A6] rounded-xl shadow-sm mb-4 placeholder-gray-400 focus:ring-2 focus:ring-[#14B8A6] focus:outline-none">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-48 overflow-y-auto">
                @foreach($filteredDevelopers as $developer)
                    <label class="flex items-center space-x-3 p-3 border-2 border-[#14B8A6] rounded-xl shadow-sm bg-white hover:bg-[#14B8A6]/10 transition cursor-pointer">
                        <input type="checkbox"
                               wire:model="selectedDevelopers"
                               value="{{ $developer->id }}"
                               class="form-checkbox text-[#14B8A6] rounded focus:ring-0 focus:ring-offset-0">
                        <img src="{{ $developer->photo }}" alt="{{ $developer->name }}" class="w-10 h-10 rounded-full object-cover">
                        <span class="text-[#1F2937] text-sm font-medium">{{ $developer->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>


        {{-- Botões --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('home') }}"
               class="flex items-center justify-center gap-2 px-7 py-3 bg-red-500/90 text-white font-semibold rounded-xl shadow-md transition-colors hover:bg-red-600">
                <x-delete-icon width="16px" height="16px" color="currentColor"/>
                Cancelar
            </a>
            <button
                type="submit"
                class="flex items-center justify-center gap-2 px-7 py-3 bg-[#14B8A6] hover:bg-[#14B8A6]/90 text-white font-semibold rounded-xl shadow-md transition-colors"
                wire:loading.attr="disabled">
                <x-send-icon width="16px" height="16px" color="currentColor"/>
                Publicar artigo
            </button>
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
