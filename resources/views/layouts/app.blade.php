<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>BeeCook - Where Quality Meets Flavor</title>
        <link rel="shortcut icon" type="image/x-icon" href="/assets/images/logo/logo-beecook-color.png">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- toastify --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- Custom Styles -->
        <link rel="stylesheet" href="/assets/css/style.css" />

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                    colors: {
                        primary: '#E8B431',
                        dark: '#111827',
                    },
                    fontFamily: {
                        montserrat: ['Montserrat', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    },
                },
            }
        </script>

        @livewireStyles
    </head>
    <body class="bg-white font-inter overflow-x-hidden">

        <!-- ══════════════════════════════════════
            HEADER / NAVBAR
        ══════════════════════════════════════ -->
        <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
            <!-- Bar utama -->
            <div class="px-6 md:px-[123px] py-8 flex items-center justify-between">
                <!-- Logo -->
                <a wire:navigate href="/" aria-label="BeeCook Home">
                    <img src="/assets/images/logo/logo-beecook-color.png" alt="BeeCook" class="w-[140px] md:w-[186px]" />
                </a>

                <!-- Desktop Nav -->
                <nav aria-label="Navigasi utama" class="hidden lg:flex items-center gap-[52px]">
                    <a wire:navigate href="/" class="font-inter font-semibold text-2xl {{ request()->is('/') ? 'text-primary hover:opacity-80 transition-opacity' : 'text-gray-700 hover:text-primary transition-colors' }}"">Beranda</a>
                    <a wire:navigate href="/recipes" class="font-inter font-semibold text-2xl {{ request()->is('recipes') || request()->is('recipes/*') ? 'text-primary hover:opacity-80 transition-opacity' : 'text-gray-700 hover:text-primary transition-colors' }}">Resep</a>
                    <a wire:navigate href="/manage" class="font-inter font-semibold text-2xl {{ request()->is('manage') || request()->is('/add-recipes') || request()->is('/edit-recipes') ? 'text-primary hover:opacity-80 transition-opacity' : 'text-gray-700 hover:text-primary transition-colors' }}">Kelola</a>
                </nav>

                <!-- Hamburger -->
                <button
                    id="hamburger"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    class="lg:hidden flex flex-col gap-[6px] cursor-pointer p-1"
                >
                    <span class="bar bar-top block w-6 h-0.5 bg-gray-800 rounded"></span>
                    <span class="bar bar-mid block w-6 h-0.5 bg-gray-800 rounded"></span>
                    <span class="bar bar-bottom block w-6 h-0.5 bg-gray-800 rounded"></span>
                </button>
            </div>

            <!-- Mobile menu — di dalam header agar ikut fixed -->
            <nav id="mobile-menu" aria-label="Navigasi mobile" class="lg:hidden bg-white border-t border-gray-100 px-6">
                <ul class="flex flex-col py-4 gap-4">
                    <li><a wire:navigate href="/" class="block font-semibold text-lg {{ request()->is('/') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} py-1">Beranda</a></li>
                    <li><a wire:navigate href="/recipes" class="block font-semibold text-lg {{ request()->is('recipes') || request()->is('recipes/*') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} py-1">Resep</a></li>
                    <li><a wire:navigate href="/manage" class="block font-semibold text-lg {{ request()->is('manage') || request()->is('/add-recipes') || request()->is('/edit-recipes') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} py-1">Kelola</a></li>
                </ul>
            </nav>
        </header>

        <!-- ══════════════════════════════════════
            MAIN CONTENT
        ══════════════════════════════════════ -->
        {{ $slot }}

        <!-- ══════════════════════════════════════
            FOOTER
        ══════════════════════════════════════ -->
        <footer class="bg-dark text-white px-6 md:px-[123px] pt-16 pb-10">
            {{-- <div class="grid grid-cols-2 xl:flex xl:flex-row gap-8 xl:gap-44 mb-16"> --}}
            <div class="grid grid-cols-2 xl:flex xl:flex-row gap-8 xl:gap-28 mb-16">

                <!-- Brand: full width di mobile -->
                <div class="col-span-2 flex-shrink-0">
                    <img src="/assets/images/logo/logo-beecook-white.png" alt="BeeCook" class="w-[150px] md:w-[186px] mb-6">
                </div>

                <!-- Partnership links -->
                <nav aria-label="Partnership">
                    <h3 class="font-inter font-bold text-lg md:text-2xl text-slate-50 mb-4 md:mb-5">Partnership</h3>
                    <ul class="flex flex-col gap-3 md:gap-4 list-none">
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">Layanan</a></li>
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">Kontributor</a></li>
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">Iklan</a></li>
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">Karir</a></li>
                    </ul>
                </nav>

                <!-- Help links -->
                <nav aria-label="Bantuan">
                    <h3 class="font-inter font-bold text-lg md:text-2xl text-slate-50 mb-4 md:mb-5">Bantuan</h3>
                    <ul class="flex flex-col gap-3 md:gap-4 list-none">
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">FAQ</a></li>
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">Kontak Kami</a></li>
                        <li><a href="#" class="font-inter font-medium text-base md:text-xl text-slate-50 hover:text-primary transition-colors">Aksesibilitas</a></li>
                    </ul>
                </nav>

                <!-- Social: full width di mobile, ml-auto di desktop -->
                <div class="col-span-2 xl:ml-auto">
                    <h3 class="font-inter font-bold text-lg md:text-2xl text-slate-50 mb-4 md:mb-5">Ikuti Kami</h3>
                    <div class="flex items-center gap-5">
                        <a href="#" aria-label="TikTok BeeCook">
                            <img src="/assets/images/sosmed/socmed-tiktok.png" alt="TikTok" class="w-8 h-8 md:w-10 md:h-10 hover:opacity-80 transition-opacity">
                        </a>
                        <a href="#" aria-label="Facebook BeeCook">
                            <img src="/assets/images/sosmed/socmed-facebook.png" alt="Facebook" class="w-8 h-8 md:w-10 md:h-10 hover:opacity-80 transition-opacity">
                        </a>
                        <a href="#" aria-label="Instagram BeeCook">
                            <img src="/assets/images/sosmed/socmed-instagram.png" alt="Instagram" class="w-8 h-8 md:w-10 md:h-10 hover:opacity-80 transition-opacity">
                        </a>
                        <a href="#" aria-label="X (Twitter) BeeCook">
                            <img src="/assets/images/sosmed/socmed-x.png" alt="X" class="w-8 h-8 md:w-10 md:h-10 hover:opacity-80 transition-opacity">
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom bar -->
            <div class=" pt-6">
                <p class="font-inter font-light text-sm md:text-base text-white text-center md:text-left">
                    BECOOK MEDIA | ALL RIGHTS RESERVED
                </p>
            </div>
        </footer>

        <script src="/assets/js/script.js"></script>
        @livewireScripts

        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            document.addEventListener('livewire:init', () => {

                Livewire.on('success-message', (event) => {
                    Toastify({
                        text: event,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "#1a1a1a",
                            borderLeft: "4px solid #F5C842",
                            color: "#ffffff",
                            borderRadius: "8px",
                            fontFamily: "Inter, sans-serif",
                            fontSize: "14px",
                        }
                    }).showToast();
                });

                Livewire.on('failed-message', (event) => {
                    Toastify({
                        text: event,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "#1a1a1a",
                            borderLeft: "4px solid #DA4453",
                            color: "#ffffff",
                            borderRadius: "8px",
                            fontFamily: "Inter, sans-serif",
                            fontSize: "14px",
                        }
                    }).showToast();
                });

            });
        </script>

        @if (session('success-message'))
        <script>
            Toastify({
                text: '{{ session('success-message') }}',
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "#1a1a1a",
                    borderLeft: "4px solid #F5C842",
                    color: "#ffffff",
                    borderRadius: "8px",
                    fontFamily: "Inter, sans-serif",
                    fontSize: "14px",
                }
            }).showToast();
        </script>
        @endif

        @if (session('failed-message'))
        <script>
            Toastify({
                text: '{{ session('failed-message') }}',
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "#1a1a1a",
                    borderLeft: "4px solid #DA4453",
                    color: "#ffffff",
                    borderRadius: "8px",
                    fontFamily: "Inter, sans-serif",
                    fontSize: "14px",
                }
            }).showToast();
        </script>
        @endif
    </body>
</html>
