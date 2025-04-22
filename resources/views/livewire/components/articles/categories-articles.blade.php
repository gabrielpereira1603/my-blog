<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#14B8A6] mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <h3 class="text-xl font-semibold text-[#1F2937]">Categorias</h3>
        </div>

        <div class="flex flex-wrap gap-3">
            @foreach ([
                ['label' => 'Inteligência Artificial', 'href' => '#'],
                ['label' => 'Desenvolvimento Web', 'href' => '#'],
                ['label' => 'Mobile', 'href' => '#'],
                ['label' => 'DevOps', 'href' => '#'],
                ['label' => 'Cloud', 'href' => '#'],
            ] as $category)
                <a href="{{ $category['href'] }}"
                   class="inline-block px-4 py-2 rounded-xl bg-[#F3F4F6] text-[#14B8A6] text-sm font-medium hover:bg-[#14B8A6]/90 hover:text-white transition-colors duration-200 shadow-sm">
                    {{ $category['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
