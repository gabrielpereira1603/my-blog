<section class="w-full bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
        {{-- Coluna esquerda: artigos 1 e 2 lado a lado --}}
        <div class="lg:col-span-2 grid grid-cols-2">
            @foreach($articles->take(2) as $article)
                <a href="" class="relative group aspect-video">
                    @if($article->cover_image)
                        <img src="{{ asset('logos/logo-transparante.png') }}" alt="{{ $article->title }}" class="w-full h-full object-cover rounded-none">
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4">
                        <h4 class="text-white text-xl font-semibold leading-tight">{{ $article->title }}</h4>
                        <p class="text-white text-sm mt-1">{{ $article->published_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Coluna direita: artigos 3 e 4 empilhados --}}
        <div class="grid grid-rows-2">
            @foreach($articles->skip(2)->take(2) as $article)
                <a href="" class="relative group aspect-[12/3]">
                    @if($article->cover_image)
                        <img src="{{ asset('logos/logo-transparante.png') }}" alt="{{ $article->title }}" class="w-full h-full object-cover rounded-none">
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4">
                        <h4 class="text-white text-base font-semibold leading-tight">{{ $article->title }}</h4>
                        <p class="text-white text-sm mt-1">{{ $article->published_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
