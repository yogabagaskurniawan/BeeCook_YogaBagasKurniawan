<main class="relative pt-[126px]">

    @if ($loading)
        {{-- Loading State --}}
        <div class="flex items-center justify-center min-h-[60vh]">
            <div class="flex flex-col items-center gap-4">
                <svg class="animate-spin w-10 h-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <p class="font-inter text-gray-500 text-base">Memuat resep...</p>
            </div>
        </div>

    @elseif ($error)
        {{-- Error State --}}
        <div class="flex items-center justify-center min-h-[60vh] px-6">
            <div class="text-center">
                <p class="font-inter font-semibold text-xl text-gray-700 mb-2">Oops!</p>
                <p class="font-inter text-gray-500 text-base">{{ $error }}</p>
                <a href="/recipes" class="mt-6 inline-block px-6 py-2 bg-primary text-black font-inter font-semibold rounded-full hover:opacity-80 transition">
                    Kembali ke Daftar Resep
                </a>
            </div>
        </div>

    @elseif ($menu)
        <!-- ════════════════════════════════════════
             HERO IMAGE
        ════════════════════════════════════════ -->
        <section aria-label="Foto Resep" class="px-6 md:px-[123px] pt-4 pb-0">
            <div class="relative w-full h-[220px] sm:h-[320px] md:h-[390px] rounded-2xl overflow-hidden">

                {{-- Foto resep dari Google Drive --}}
                <img
                    src="https://drive.google.com/thumbnail?id={{ $menu['file_id'] }}&sz=w1200"
                    alt="Foto hidangan {{ $menu['name'] }}"
                    class="w-full h-full object-cover"
                >

                {{-- Gradient overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                {{-- Judul resep --}}
                <div class="absolute inset-0 flex items-end px-6 md:px-16">
                    <h1 class="font-montserrat font-extrabold text-white text-2xl sm:text-4xl md:text-[60px] mb-20" style="line-height: 1.1;">
                        {{ $menu['name'] }}
                    </h1>
                </div>
            </div>
        </section>
        <!-- ════════════════════════════════════════
             META RESEP  (Kategori & Durasi)
        ════════════════════════════════════════ -->
        <section aria-label="Informasi Singkat Resep" class="px-6 md:px-[123px] pt-8 pb-0">
            <div class="flex flex-wrap items-center gap-6 md:gap-[120px]">

                {{-- Kategori --}}
                <div class="flex items-center gap-4">
                    <img src="/assets/images/category.svg" alt="" aria-hidden="true" class="w-[52px] h-[52px] md:w-[61px] md:h-[61px]" />
                    <div>
                        <p class="font-inter font-semibold text-lg text-gray-400 leading-tight">Kategori</p>
                        <p class="font-inter font-semibold text-xl text-dark leading-tight">{{ $menu['category']['name'] }}</p>
                    </div>
                </div>
 
                {{-- Durasi --}}
                <div class="flex items-center gap-4">
                    <img src="/assets/images/duration.svg" alt="" aria-hidden="true" class="w-9 h-9 md:w-[38px] md:h-[38px]" />
                    <div>
                        <p class="font-inter font-semibold text-lg text-gray-400 leading-tight">Durasi</p>
                        <p class="font-inter font-semibold text-xl text-dark leading-tight">{{ $menu['cooking_duration'] }} menit</p>
                    </div>
                </div>

            </div>
        </section>
        <!-- ════════════════════════════════════════
            DESKRIPSI RESEP
        ════════════════════════════════════════ -->
        <section aria-label="Deskripsi Resep" class="relative px-6 md:px-[123px] py-8">

            {{-- Glow blob kanan (dekoratif) --}}
            <div class="glow-yellow absolute top-[1px] -right-10 w-[490px] h-[592px] -z-10"></div>

            <p class="relative z-10 font-inter font-normal text-gray-600 text-base md:text-lg leading-[30px] text-justify max-w-[1194px]">
                {{ $menu['description'] }}
            </p>
        </section>


        <!-- ════════════════════════════════════════
             INFORMASI NUTRISI
        ════════════════════════════════════════ -->
        @if (!empty($menu['nutrition']))
        <section aria-labelledby="nutrisi-heading" class="px-6 md:px-[123px] py-8">
 
            <h2 id="nutrisi-heading" class="font-inter font-semibold text-2xl md:text-[30px] text-black mb-6">
                Informasi Nutrisi
            </h2>
 
            {{-- Grid kartu nutrisi --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
 
                <div class="flex flex-col items-center justify-center py-6 px-4 bg-slate-50 rounded-2xl border-2 border-primary">
                    <span class="font-inter font-semibold text-xl md:text-2xl text-gray-800">{{ $menu['nutrition']['calory'] }} kcal</span>
                    <span class="font-inter font-medium text-base text-gray-800 mt-1">Kalori</span>
                </div>
 
                <div class="flex flex-col items-center justify-center py-6 px-4 bg-slate-50 rounded-2xl border-2 border-primary">
                    <span class="font-inter font-semibold text-xl md:text-2xl text-gray-800">{{ $menu['nutrition']['protein'] }}g</span>
                    <span class="font-inter font-medium text-base text-gray-800 mt-1">Protein</span>
                </div>
 
                <div class="flex flex-col items-center justify-center py-6 px-4 bg-slate-50 rounded-2xl border-2 border-primary">
                    <span class="font-inter font-semibold text-xl md:text-2xl text-gray-800">{{ $menu['nutrition']['fat'] }}g</span>
                    <span class="font-inter font-medium text-base text-gray-800 mt-1">Lemak</span>
                </div>
 
                <div class="flex flex-col items-center justify-center py-6 px-4 bg-slate-50 rounded-2xl border-2 border-primary">
                    <span class="font-inter font-semibold text-xl md:text-2xl text-gray-800">{{ $menu['nutrition']['carbohydrate'] }}g</span>
                    <span class="font-inter font-medium text-base text-gray-800 mt-1">Karbohidrat</span>
                </div>
 
            </div>
        </section>
        @endif
        <!-- ════════════════════════════════════════
             BAHAN-BAHAN & CARA MASAK
        ════════════════════════════════════════ -->
        <section aria-label="Bahan dan Cara Memasak" class="px-6 md:px-[123px] py-8 pb-20">
 
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-16">
 
                <!-- ── Bahan-bahan ── -->
                @if (!empty($menu['ingredients']))
                <div class="flex-1">
                    <h2 class="font-inter font-semibold text-2xl md:text-[30px] text-black mb-6">Bahan-bahan</h2>

                    <ul class="flex flex-col gap-2 list-none">
                        @foreach ($menu['ingredients'] as $ingredient)
                            <li class="font-inter font-normal text-black text-base md:text-lg leading-8">
                                {{ $ingredient['description'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
 
                <!-- ── Cara Masak ── -->
                @if (!empty($menu['recipes']))
                <div class="flex-1">
                    <h2 class="font-inter font-semibold text-2xl md:text-[30px] text-black mb-6">Cara Masak</h2>

                    <ol class="flex flex-col gap-6 list-none">
                        @foreach ($menu['recipes'] as $index => $step)
                            <li class="flex items-start gap-6 md:gap-8">
                                {{-- Nomor langkah --}}
                                <span class="flex-shrink-0 w-[45px] h-[45px] rounded-full bg-primary flex items-center justify-center font-inter font-semibold text-base text-black">
                                    {{ $step['sort_number'] ?? $loop->iteration }}
                                </span>
                                <p class="font-inter font-normal text-black text-base md:text-lg leading-relaxed pt-2">
                                    {{ $step['description'] }}
                                </p>
                            </li>
                        @endforeach
                    </ol>
                </div>
                @endif
            </div>
        </section>
    @endif
</main>