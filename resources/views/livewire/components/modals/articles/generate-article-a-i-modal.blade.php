<x-modal name="generate-article-ai-modal">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h2 class="flex items-center justify-start gap-2 text-2xl font-bold text-[#1F2937] mb-6">
            <x-artificial-intelligence-icon width="20px" height="20px" color="currentColor" />
            Gerar notícia com IA
        </h2>

        <form wire:submit.prevent="generate" class="space-y-6">
            {{-- Descrição --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-[#1F2937]">Descrição</label>
                <textarea wire:model.live="description" rows="4"
                          placeholder="Digite uma breve descrição para o artigo..."
                          class="w-full px-4 py-2 border border-[#14B8A6] rounded-xl shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-[#14B8A6] focus:outline-none resize-none"></textarea>
                @error('description')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Categorias --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-[#1F2937]">Categorias</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $category)
                        <label class="inline-flex items-center px-3 py-2 bg-white border-2 border-[#14B8A6] rounded-xl cursor-pointer shadow-sm hover:bg-[#14B8A6]/10 transition">
                            <input type="checkbox"
                                   wire:model.live="selectedCategories"
                                   value="{{ $category->id }}"
                                   class="form-checkbox text-[#14B8A6] rounded focus:ring-0 focus:ring-offset-0 mr-2">
                            <span class="text-sm text-[#1F2937]">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('selectedCategories')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botões --}}
            <div class="flex justify-end gap-4 pt-4">
                <button type="button"
                        wire:click="$dispatch('closeModal')"
                        class="flex items-center justify-center gap-2 px-6 py-2 bg-red-500/90 text-white font-semibold rounded-xl shadow-md transition-colors hover:bg-red-600">
                    Cancelar
                </button>

                <button type="submit"
                        class="flex items-center justify-center gap-2 px-6 py-2 bg-[#14B8A6] hover:bg-[#14B8A6]/90 text-white font-semibold rounded-xl shadow-md transition-colors"
                        wire:loading.attr="disabled"
                        wire:loading.class="bg-[#14B8A6]/70 cursor-wait"
                        wire:loading.class.remove="hover:bg-[#14B8A6]/90">
                    <span wire:loading.remove>Gerar Notícia</span>
                    <span wire:loading>Carregando...</span>
                </button>
            </div>
        </form>
    </div>
</x-modal>
