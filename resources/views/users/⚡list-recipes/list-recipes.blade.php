<main class="relative pt-[126px]">

    <!-- Glow dekoratif -->
    <div class="glow-amber absolute top-[200px] right-0 w-[490px] h-[492px] -z-10 pointer-events-none"></div>

    <!-- HERO BANNER -->
    <section aria-label="Banner Resep" class="px-6 md:px-[123px] pt-8 pb-6">
        <div class="relative w-full rounded-2xl overflow-hidden max-h-[323px]">
            <img src="/assets/images/pexels-undo-kim-2153633398-346833171.png" alt="Banner halaman resep"
                class="w-full h-[323px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>
            <div class="absolute inset-0 flex flex-col justify-center px-10 md:px-16">
                <p class="font-montserrat font-medium text-primary text-lg md:text-[20px] mb-0">Sedang Trending</p>
                <h1 class="font-montserrat font-semibold text-white text-2xl md:text-[40px] leading-tight max-w-[600px]">
                    Nasi Goreng Udang Mentega
                </h1>
            </div>
        </div>
    </section>

    <!-- FILTER KATEGORI -->
    <section aria-label="Filter Kategori" class="px-6 md:px-[123px] pb-6 pt-2">
        <div class="overflow-x-auto scrollbar-hide">
            <div class="inline-flex gap-3 md:gap-6 whitespace-nowrap pb-1" role="group" aria-label="Filter kategori resep">

                {{-- Tombol Semua --}}
                <button
                    wire:click="filterCategory('')"
                    class="px-10 md:px-16 py-4 font-inter font-bold text-base rounded-xl transition-all
                           {{ $activeCategory === '' ? 'bg-primary text-white' : 'bg-dark text-white hover:bg-gray-700' }}">
                    Semua
                </button>

                {{-- Tombol per kategori dari API --}}
                @foreach ($categories as $cat)
                    <button
                        wire:click="filterCategory('{{ $cat['id'] }}')"
                        class="px-10 md:px-16 py-4 font-inter font-bold text-base rounded-xl transition-all
                               {{ (string) $activeCategory === (string) $cat['id'] ? 'bg-primary text-white' : 'bg-dark text-white hover:bg-gray-700' }}">
                        {{ $cat['name'] }}
                    </button>
                @endforeach

            </div>
        </div>
    </section>

    <!-- DAFTAR RESEP -->
    <section aria-label="Daftar Resep" class="px-6 md:px-[123px] pt-8 pb-20">

        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-[45px] list-none">

            @if ($loading)
                {{-- Skeleton: 6 kartu --}}
                @for ($i = 0; $i < 6; $i++)
                    <li>
                        <div class="bg-white rounded-[28px] shadow-[0px_17px_24.8px_-1px_rgba(0,0,0,0.13)] overflow-hidden">
                            <div class="w-full h-[272px] bg-gray-200 animate-pulse"></div>
                            <div class="p-8 pt-6 space-y-3">
                                <div class="flex justify-between">
                                    <div class="h-6 w-24 bg-gray-200 rounded-md animate-pulse"></div>
                                    <div class="h-6 w-16 bg-gray-200 rounded-md animate-pulse"></div>
                                </div>
                                <div class="h-5 w-full bg-gray-200 rounded animate-pulse"></div>
                                <div class="h-5 w-3/4 bg-gray-200 rounded animate-pulse"></div>
                            </div>
                        </div>
                    </li>
                @endfor

            @elseif (empty($menus))
                <li class="col-span-3 text-center py-20 text-gray-400 text-lg">
                    Tidak ada resep ditemukan.
                </li>

            @else
                @foreach ($menus as $menu)
                    <li>
                        <a wire:navigate href="/recipes/{{ $menu['slug'] }}">
                            <article class="bg-white rounded-[28px] shadow-[0px_17px_24.8px_-1px_rgba(0,0,0,0.13)] overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                                <div class="relative">
                                    <img
                                        src="https://drive.google.com/thumbnail?id={{ $menu['file_id'] }}&sz=w600"
                                        alt="{{ $menu['name'] }}"
                                        class="w-full h-[272px] object-cover rounded-[28px]"
                                    >
                                </div>
                                <div class="p-8 pt-6">
                                    <div class="flex items-start justify-between gap-2 mb-3">
                                        <span class="inline-flex items-center px-2 py-1.5 bg-blue-600 text-white font-inter font-medium text-xs rounded-md">
                                            {{ $menu['category']['name'] }}
                                        </span>
                                        <div class="flex items-center gap-1.5 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="font-inter font-semibold text-base">{{ $menu['cooking_duration'] }} m</span>
                                        </div>
                                    </div>
                                    <h3 class="font-inter font-semibold text-black text-xl leading-[30px] tracking-tight">
                                        {{ $menu['name'] }}
                                    </h3>
                                    <p class="font-inter text-gray-500 text-sm mt-1 line-clamp-2">
                                        {{ $menu['description'] }}
                                    </p>
                                </div>
                            </article>
                        </a>
                    </li>
                @endforeach
            @endif

        </ul>

        <!-- PAGINATION -->
        @if (!$loading && $totalPages > 1)
            <nav aria-label="Navigasi halaman" class="my-16 flex justify-center">
                <div class="inline-flex items-center gap-1">

                {{-- Previous --}}
                <button
                    wire:click="goToPage({{ $currentPage - 1 }})"
                    @disabled($currentPage === 1)
                    class="flex items-center gap-1 px-2 md:px-3 h-[38px] rounded-lg font-inter font-medium text-base transition-colors
                        {{ $currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-800 hover:bg-gray-100' }}">
                    <span>«</span>
                    <span class="hidden md:inline">Previous</span>
                </button>

                {{-- Nomor halaman --}}
                @foreach ($this->getPageNumbers() as $page)
                    @if ($page === '...')
                        <span class="w-[32px] md:w-[38px] h-[38px] flex items-center justify-center font-inter text-xs text-gray-400">•••</span>
                    @else
                        <button
                            wire:click="goToPage({{ $page }})"
                            class="w-[32px] md:w-[38px] h-[32px] md:h-[38px] flex items-center justify-center rounded-full font-inter font-medium text-sm md:text-base transition-colors
                                {{ $currentPage === $page
                                    ? 'bg-primary text-white'
                                    : 'text-gray-800 hover:bg-gray-200' }}">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach

                {{-- Next --}}
                <button
                    wire:click="goToPage({{ $currentPage + 1 }})"
                    @disabled($currentPage === $totalPages)
                    class="flex items-center gap-1 px-2 md:px-3 h-[38px] rounded-lg font-inter font-medium text-base transition-colors
                        {{ $currentPage === $totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-800 hover:bg-gray-100' }}">
                    <span class="hidden md:inline">Next</span>
                    <span>»</span>
                </button>

                </div>
            </nav>
        @endif

    </section>

    {{-- Trigger load setelah render --}}
    @script
    <script>
        // Load pertama kali
        $wire.loadMenus();

        // Listen event dari filterCategory & goToPage
        $wire.on('fetch-menus', () => {
            $wire.loadMenus();
        });
    </script>
    @endscript

</main>