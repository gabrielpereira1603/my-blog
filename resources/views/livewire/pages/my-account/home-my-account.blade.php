<div class="max-w-7xl mx-auto px-4 py-6">
    @if (auth()->user()->developer)
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
            <form wire:submit="updateUser()" class="mt-8 relative">
                <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Meu Perfil de Autor</h3>

                <div class="flex items-center gap-4">
                    @if ($open)
                        <div x-data="{
                                    editing: false,
                                    tempUrl: null,
                                    revert() {
                                        this.editing = false;
                                        $wire.set('form.photo', null); // Reseta o campo de foto para null
                                    },
                                    handleFileChange(event) {
                                        const file = event.target.files[0];
                                        if (file && file.type.startsWith('image/')) {
                                            this.tempUrl = URL.createObjectURL(file);
                                            this.editing = true;
                                        }
                                    }
                                }" class="relative w-24 h-24">
                            <img
                                :src="editing && tempUrl ? tempUrl : '{{ $form->user->developer?->photo ?? Auth()->user()->developer->photo }}'"
                                alt="Foto de Perfil"
                                class="w-24 h-24 rounded-full object-cover border border-gray-300"
                            >

                            <div
                                class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition rounded-full cursor-pointer"
                                @click="$refs.fileInput.click()"
                            >
                                <x-edit-icon width="24px" height="24px" color="white" />
                            </div>

                            <input
                                type="file"
                                class="hidden"
                                x-ref="fileInput"
                                wire:model="form.photo"
                                @change="handleFileChange"
                                accept="image/*"
                            >

                            <template x-if="editing">
                                <button
                                    type="button"
                                    @click="revert"
                                    class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-xs px-2 py-1 bg-white border border-gray-300 rounded-full shadow text-gray-500 hover:bg-gray-100 transition"
                                >
                                    Cancelar
                                </button>
                            </template>
                        </div>
                    @else
                        <img
                            src="{{ $form->user->developer?->photo ?? 'https://via.placeholder.com/96' }}"
                            alt="Foto de Perfil"
                            class="w-24 h-24 rounded-full object-cover border border-gray-300"
                        >
                    @endif

                    <!-- Nome -->
                    <div class="flex flex-col w-full sm:w-1/3 gap-2">
                        @if ($open)
                            <label class="text-sm text-gray-500">Nome:</label>

                            <input
                                type="text"
                                wire:model.blur="form.name"
                                class="text-[#1F2937] text-base rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-transparent transition w-full"
                            />
                        @else
                            <p class="text-lg font-medium text-[#1F2937]">{{ $form->name }}</p>
                        @endif

                        <!-- Bio -->
                        @if ($open)
                            <label class="text-sm text-gray-500">Biografia:</label>
                            <textarea wire:model.blur="form.bio"
                                      class="w-full text-[#1F2937] text-sm rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-transparent transition w-full resize-none">

                            </textarea>
                        @else
                            <p class="text-sm text-gray-500">{{ $form->bio }}</p>
                        @endif
                    </div>
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <label class="text-sm text-gray-500">E-mail:</label>
                    @if ($open)
                        <input type="email" wire:model.blur="form.email"
                               class="text-[#1F2937] text-base rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-transparent transition w-full" />
                    @else
                        <p class="text-[#1F2937]">{{ $form->email }}</p>
                    @endif
                </div>

                @if (Auth::user()->role === 'administrator')
                    <div class="mt-4">
                        <label class="text-sm text-gray-500">Papel de acesso:</label>
                        @if($open)
                            <select wire:model.blur="form.role"
                                    class="text-[#1F2937] text-base rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-transparent transition w-full">
                                <option value="user">Usuário</option>
                                <option value="administrator">Administrador</option>
                            </select>
                        @else
                            <p class="text-[#1F2937] capitalize">{{ $form->role }}</p>
                        @endif
                    </div>
                @endif


                <!-- Indicador de atividade -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-[#1F2937] mb-2">Atividade de Posts</h4>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-[#14B8A6] h-2 rounded-full"
                             style="width: {{ $articlesCount * 0.5 }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Você já escreveu {{ $articlesCount }} artigos.</p>
                </div>

                <!-- Botões -->
                <div class="sm:absolute sm:right-10 sm:top-0 w-full sm:w-auto mt-4 sm:mt-0 flex gap-4">
                    @if (!$open)
                        <button wire:click="startEdit()"
                                type="button"
                                class="text-[#1F2937] bg-[#14B8A6] px-5 py-1 rounded-md flex items-center justify-center gap-2 w-full">
                            <x-edit-icon width="16px" height="16px" color="currentColor"/>
                            Editar suas informações
                        </button>
                    @else
                        <button wire:click="resetForm"
                                class="bg-gray-300 text-[#1F2937] px-4 py-1 rounded-md font-medium flex items-center justify-center gap-2 hover:bg-red-400 w-full sm:w-auto">
                            <x-delete-icon width="16px" height="16px" color="currentColor"/>
                            Descartar
                        </button>
                        <button type="submit"
                                wire:click="updateUser"
                                class="bg-[#14B8A6] text-[#1F2937] px-4 py-1 rounded-md font-medium flex items-center justify-center gap-2 hover:bg-[#14B8A6]/90 w-full sm:w-auto">
                            <x-save-icon width="16px" height="16px" color="currentColor"/>
                            Salvar alterações
                        </button>
                    @endif
                </div>
            </form>
        </div>

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

            <div>
                <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Categorias mais postadas</h3>
                <ul class="space-y-2">
                    @forelse ($topCategories as $category)
                        <li class="bg-[#F3F4F6] px-4 py-2 rounded-full text-[#14B8A6] font-medium shadow">
                            {{ $category->name }} ({{ $category->articles_count }})
                        </li>
                    @empty
                        <li class="text-gray-500 italic">Nenhuma categoria encontrada.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <!-- Últimos posts -->
        <div class="mt-10">
            <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Últimos 4 artigos publicados</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse ($latestArticles as $article)
                    <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between">
                        <h4 class="text-base font-semibold text-[#1F2937]">{{ $article->title }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $article->published_at->format('d M Y') }}</p>
                        <a href="#" class="text-sm text-[#14B8A6] mt-2 hover:underline">Ver artigo →</a>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 italic">
                        Nenhum artigo publicado ainda.
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
            <h3 class="text-xl font-semibold text-[#1F2937] mb-4">Minha Conta</h3>

            <form wire:submit.prevent="updateUser()" class="space-y-4">
                <!-- Nome -->
                <div>
                    <label class="text-sm text-gray-500">Nome:</label>
                    <input type="text" wire:model.defer="form.name"
                           class="w-full text-[#1F2937] text-base rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-transparent transition" />
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-500">E-mail:</label>
                    <input type="email" wire:model.defer="form.email"
                           class="w-full text-[#1F2937] text-base rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#14B8A6] focus:border-transparent transition" />
                </div>

                <div class="flex justify-end gap-4">

                    <button type="submit"
                            class="bg-[#14B8A6] text-white px-4 py-2 rounded-lg hover:bg-[#14B8A6]/90 transition">
                        Salvar
                    </button>
                </div>
            </form>

            @if ($showDeveloperForm)
                <div class="mt-6 bg-white border border-gray-200 rounded-2xl shadow-md p-6">
                    <h4 class="text-lg font-semibold text-[#1F2937] mb-4">Se tornar um autor</h4>

                    <form wire:submit.prevent="becomeAuthor" class="space-y-4">
                        <div x-data="{
                                editing: false,
                                tempUrl: null,
                                revert() {
                                    this.editing = false;
                                    $wire.set('form.photo', null);
                                },
                                handleFileChange(event) {
                                    const file = event.target.files[0];
                                    if (file && file.type.startsWith('image/')) {
                                        this.tempUrl = URL.createObjectURL(file);
                                        this.editing = true;
                                    }
                                }
                            }" class="flex items-center gap-4">
                            <div class="relative w-24 h-24">
                                <img
                                    :src="editing && tempUrl ? tempUrl : '{{ auth()->user()->developer?->photo ?? 'https://via.placeholder.com/96' }}'"
                                    alt="Foto de Perfil"
                                    class="w-24 h-24 rounded-full object-cover border border-gray-300"
                                >

                                <div
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition rounded-full cursor-pointer"
                                    @click="$refs.fileInput.click()"
                                >
                                    <x-edit-icon width="24px" height="24px" color="white" />
                                </div>

                                <input
                                    type="file"
                                    class="hidden"
                                    x-ref="fileInput"
                                    wire:model="form.photo"
                                    @change="handleFileChange"
                                    accept="image/*"
                                >

                                <template x-if="editing">
                                    <button
                                        type="button"
                                        @click="revert"
                                        class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-xs px-2 py-1 bg-white border border-gray-300 rounded-full shadow text-gray-500 hover:bg-gray-100 transition"
                                    >
                                        Cancelar
                                    </button>
                                </template>
                            </div>

                            <div>
                                <label class="text-sm text-gray-500">Foto de perfil</label>
                                <p class="text-xs text-gray-400">Clique na imagem para alterar</p>
                                @error('form.photo')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Bio -->
                        <div>
                            <label class="text-sm text-gray-500">Bio:</label>
                            <textarea wire:model.defer="form.bio" rows="4"
                                      class="w-full border border-gray-300 rounded-xl px-4 py-2 resize-none"></textarea>
                            @error('form.bio') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-4">
                            <button type="button" wire:click="$set('showDeveloperForm', false)"
                                    class="text-gray-500 hover:text-gray-700 px-4 py-2">
                                Cancelar
                            </button>

                            <button type="submit"
                                    class="bg-[#14B8A6] text-white px-4 py-2 rounded-lg hover:bg-[#14B8A6]/90 transition">
                                Criar perfil de autor
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        <button
            wire:click="$toggle('showDeveloperForm')"
            type="button"
            class="w-full mt-5 py-4 text-xl font-semibold text-white bg-[#14B8A6] hover:bg-[#119b8f] focus:outline-none focus:ring-4 focus:ring-[#14B8A6] shadow-xl transform hover:scale-105 transition-all duration-300 ease-in-out animate-pulse rounded-lg"
        >
            Se tornar um autor
        </button>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10 opacity-40 pointer-events-none select-none">
            <div class="lg:col-span-2">
                <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl p-6 text-center">
                    <h4 class="text-lg font-semibold text-gray-400">Artigos vinculados</h4>
                    <p class="text-sm text-gray-400 mt-2">Se torne um autor para desbloquear esta área.</p>
                </div>
            </div>

            <div>
                <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl p-6 text-center">
                    <h4 class="text-lg font-semibold text-gray-400">Categorias mais postadas</h4>
                    <p class="text-sm text-gray-400 mt-2">Se torne um autor para desbloquear esta área.</p>
                </div>
            </div>
        </div>

        <div class="mt-10 opacity-40 pointer-events-none select-none">
            <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl p-6 text-center">
                <h4 class="text-lg font-semibold text-gray-400">Últimos 4 artigos publicados</h4>
                <p class="text-sm text-gray-400 mt-2">Se torne um autor para desbloquear esta área.</p>
            </div>
        </div>
    @endif
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
