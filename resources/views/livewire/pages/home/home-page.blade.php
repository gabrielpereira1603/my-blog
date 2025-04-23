<section class="w-full overflow-y-hidden">
    {{-- Grid principal --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
        {{-- Coluna da esquerda: artigos 1 e 2 --}}
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2">
            @foreach($articles->take(2) as $article)
                <a href="" class="relative group aspect-video">
                    @if($article->cover_image)
                        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4">
                        <h4 class="text-white text-xl font-semibold leading-tight">{{ $article->title }}</h4>
                        <p class="text-white text-sm mt-1">{{ $article->published_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Coluna da direita: artigos 3 e 4 (visíveis só em lg+) --}}
        <div class="hidden lg:grid grid-rows-2">
            @foreach($articles->skip(2)->take(2) as $article)
                <a href="" class="relative group aspect-[11/3]">
                    @if($article->cover_image)
                        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4">
                        <h4 class="text-white text-base font-semibold leading-tight">{{ $article->title }}</h4>
                        <p class="text-white text-sm mt-1">{{ $article->published_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    @unless(Route::is('login', 'register'))
        <ul class="hidden sm:flex justify-around items-center text-center gap-5 p-2 bg-[#14B8A6] text-[#1F2937] uppercase font-bold">
            <li><a href="#">Início</a></li>
            <li><a href="#">Novidades</a></li>
            <li><a href="#">Artigos</a></li>
            <li><a href="#">Top 10</a></li>
        </ul>
    @endunless

    <div>
        <livewire:components.articles.all-articles-decreasing/>
    </div>
</section>
