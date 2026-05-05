<main class="relative">
    <!-- Glow blob – left -->
    <div class="glow-yellow absolute top-[250px] -left-10 w-[490px] h-[592px] -z-10"></div>

    <!-- ── HERO SECTION ── -->
    <section aria-label="Hero" class="relative px-6 md:px-[122px] pt-[197px] pb-20 overflow-hidden">
        <div class="flex flex-col lg:flex-row items-start gap-4">
            <!-- Left: Copy -->
            <div class="flex-1 max-w-[600px]">
                <!-- Heading -->
                <h1 class="font-montserrat leading-tight relative">

                    <!-- Baris 1: "Where Quality" sejajar, bintang di atas kanan "Quality" -->
                    <span class="flex items-center gap-4 text-[42px] md:text-[84px] font-semibold text-black tracking-tight">
                    Where
                    <span class="relative">
                        <span class="font-extrabold text-primary">Quality</span>
                        <!-- Bintang: pojok kanan atas tulisan "Quality" -->
                        <img src="/assets/images/stars.png" alt="" aria-hidden="true" class="absolute -top-8 -right-16 w-[74px]">
                    </span>
                    </span>

                    <!-- Baris 2: "Meets Flavor." -->
                    <span class="block text-4xl md:text-[64px] font-semibold text-black tracking-tight">
                    Meets <span class="font-extrabold">Flavor.</span>
                    </span>

                </h1>
                <!-- CTA Button -->
                <a wire:navigate  href="/recipes" wire:navigate class="mt-10 inline-flex items-center justify-center px-8 py-5 bg-dark text-white font-inter font-bold text-base rounded-lg hover:bg-gray-800 transition-colors">
                    Eksplor Sekarang
                </a>

                <!-- Social Proof -->
                <div class="mt-8 flex items-center gap-3">
                    <div class="flex -space-x-3">
                        <img src="/assets/images/avatar/people1.png" alt="Pengguna 1" class="w-[62px] h-[62px] rounded-full border-2">
                        <img src="/assets/images/avatar/people2.png" alt="Pengguna 2" class="w-[62px] h-[62px] rounded-full border-2">
                        <img src="/assets/images/avatar/people3.png" alt="Pengguna 3" class="w-[62px] h-[62px] rounded-full border-2">
                    </div>
                    <p class="font-inter font-medium text-black text-xl tracking-wide">1.000+ Pengguna</p>
                </div>
            </div>

            <!-- Right: Hero Image — overflow ke kanan layar -->
            <div class="w-full lg:flex-1 lg:overflow-visible lg:-translate-x-20">
                <img src="/assets/images/hero-image.png" alt="Hidangan lezat berkualitas" 
                    class="w-full h-auto lg:w-[916px] lg:h-[533px] lg:max-w-none object-cover rounded-2xl">
            </div>

        </div>
    </section>


    <!-- ── CATEGORY SECTION ── -->
    <section aria-label="Kategori Resep" class="px-6 md:px-[122px] py-20 relative bg-transparent">

        <!-- Glow amber – desktop kanan, mobile tetap ada tapi lebih kecil -->
        <div class="glow-amber absolute md:top-[180px] top-[270px] right-0 w-[250px] h-[250px] lg:w-[495px] lg:h-[288px] -z-10"></div>

        <!-- Section heading -->
        <div class="relative text-center mb-24">
            <h2 class="font-montserrat font-bold text-4xl md:text-[44px]">
                <span class="text-black">Eksplor berdasarkan </span>
                <span class="relative inline-block text-primary">
                    <span class="relative z-10">Kategori</span>
                    <img
                        src="/assets/images/line-doodle.png"
                        alt="" aria-hidden="true"
                        class="absolute -bottom-6 top-[32px] left-[86px] md:left-[104px] -translate-x-1/2 w-[188px] md:w-[244px] opacity-70 z-0"
                    />
                </span>
            </h2>
        </div>

        <!-- Category grid -->
        <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8 list-none">

            @if ($loading)
                {{-- Skeleton: 5 item --}}
                @for ($i = 0; $i < 5; $i++)
                    <li class="flex flex-col items-center gap-4 {{ $i === 4 ? 'col-span-2 sm:col-span-1' : '' }}">
                        <div class="w-[120px] h-[120px] md:w-[148px] md:h-[148px] rounded-full bg-gray-200 animate-pulse"></div>
                        <div class="h-5 w-24 bg-gray-200 rounded-full animate-pulse"></div>
                    </li>
                @endfor

            @else
                @forelse ($categories as $category)
                    <li class="flex flex-col items-center gap-4 cursor-pointer group {{ $loop->last && count($categories) % 2 !== 0 ? 'col-span-2 sm:col-span-1' : '' }}">
                        <a wire:navigate href="/recipes?category={{ $category['slug'] }}" class="text-center">
                            <div class="w-[120px] h-[120px] md:w-[148px] md:h-[148px] rounded-full overflow-hidden transition-transform group-hover:scale-105">
                                <img
                                    src="https://drive.google.com/thumbnail?id={{ $category['file_id'] }}&sz=w300"
                                    alt="{{ $category['name'] }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <span class="font-inter font-semibold text-lg md:text-2xl text-black text-center">
                                {{ $category['name'] }}
                            </span>
                        </a>
                    </li>
                @empty
                    <span class="col-span-5 text-center py-20 text-gray-400 text-lg">
                        Tidak ada kategori ditemukan.
                    </span>
                @endforelse
            @endif

        </ul>
    </section>


    <!-- ── NEWSLETTER / FEATURE SECTION ── -->
    <section aria-label="Langganan Menu Harian" class="px-6 md:px-[120px] pt-20 pb-44">
        <div class="flex flex-col xl:grid xl:grid-cols-12 items-center gap-10 xl:gap-12">

            <!-- Left: Text & Form — di xl jadi kolom kiri -->
            <div class="w-full max-w-[600px] text-center xl:text-left xl:col-span-7 xl:max-w-none order-2 xl:order-1">
                <h2 class="font-montserrat font-semibold text-2xl md:text-[32px] text-black leading-10 mb-4">
                    Dapatan menu menarik setiap hari
                </h2>
                <p class="font-montserrat text-black text-base md:text-xl leading-[30px] mb-8">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                </p>

                <!-- Email form -->
                <div class="flex flex-col sm:flex-row gap-3 w-full xl:max-w-[570px]">
                    <label for="email-input" class="sr-only">Alamat email kamu</label>

                    <div class="flex items-center flex-1 bg-white border border-gray-200 rounded-lg overflow-hidden h-[52px] p-4">
                        <div class="px-3 flex-shrink-0 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input
                            id="email-input"
                            type="email"
                            placeholder="you@email.com"
                            class="flex-1 h-full px-2 font-inter font-medium text-sm text-gray-500 bg-transparent outline-none border-none"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full sm:w-auto h-[52px] px-6 bg-dark text-white font-inter font-medium text-sm rounded-lg hover:bg-gray-800 transition-colors whitespace-nowrap"
                    >
                        Langganan
                    </button>
                </div>
            </div>

            <!-- Right: Chef illustration — di xl jadi kolom kanan -->
            <div class="flex justify-center xl:col-span-5 xl:justify-end order-1 xl:order-2">
                <div class="relative w-[260px] h-[420px] md:w-[320px] md:h-[500px] xl:w-[404px] xl:h-[605px] flex-shrink-0">
                    <div class="absolute inset-0 bg-primary rounded-full overflow-hidden">
                        <div class="absolute -bottom-[130px] left-1/2 -translate-x-1/2 w-[80%] h-[80%] bg-white opacity-50 rounded-full blur-xl"></div>
                        <img src="/assets/images/people-chef-subscribe.png" alt="Chef BeeCook" class="px-5 pb-0 pt-10 absolute bottom-0 left-1/2 -translate-x-1/2 w-[90%] h-[100%] object-cover object-top">
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>