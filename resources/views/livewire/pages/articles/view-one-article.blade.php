<section class="w-full px-4 py-10 max-w-7xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">

        <!-- Título do Artigo -->
        <h1 class="text-3xl font-bold text-[#1F2937] text-center mb-6">{{ $article->title }}</h1>

        <!-- Capa do Artigo -->
        <div class="relative">
            @if($article->cover_image)
                <img src="{{ $article->cover_image }}" alt="Capa do Artigo" class="w-full h-64 object-cover rounded-2xl shadow-lg mb-6">
            @else
                <div class="h-64 bg-gray-200 rounded-2xl shadow-lg mb-6"></div> <!-- Placeholder para capa -->
            @endif
        </div>

        <!-- Conteúdo Completo -->
        <div class="text-lg text-[#1F2937] leading-relaxed mb-6">
            {!! nl2br(e($article->content)) !!}
        </div>

        <!-- Categorias -->
        <div class="mb-6">
            <strong class="text-xl font-semibold text-[#14B8A6]">Categorias:</strong>
            <ul class="list-disc ml-6 text-sm text-[#1F2937]">
                @foreach($article->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Desenvolvedores Vinculados -->
        @if($article->developers->count() > 0)
            <div class="mb-6">
                <strong class="text-xl font-semibold text-[#14B8A6]">Desenvolvedores:</strong>
                <ul class="list-disc ml-6 text-sm text-[#1F2937]">
                    @foreach($article->developers as $developer)
                        <li class="flex items-center mb-3">
                            @if($developer->photo)
                                <img src="{{ $developer->photo }}" alt="{{ $developer->name }}" class="w-12 h-12 rounded-full mr-4">
                            @endif
                            <div>
                                <strong>{{ $developer->name }}</strong>
                                <p class="text-sm">{{ $developer->bio }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Botão de Voltar -->
        <div class="flex justify-center">
            <a href=" {{ route('home') }}"
               class="flex items-center justify-center gap-2 px-6 py-3 bg-[#14B8A6] hover:bg-[#1F2937]/90 text-white font-semibold rounded-xl transition-colors shadow-md">
                Voltar para os artigos
            </a>
        </div>

    </div>
    <style>
        .article-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .article-content {
            margin-top: 20px;
            font-size: 1.125rem;
            line-height: 1.75rem;
            color: #1F2937;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>

</section>

