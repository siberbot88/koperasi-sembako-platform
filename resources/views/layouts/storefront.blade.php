<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Koperasi Sembako - Belanja kebutuhan pokok harian dengan harga koperasi yang terjangkau.">

        <title>{{ $title ?? 'Koperasi Sembako' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-koperasi-bg text-koperasi-dark">

        {{-- ======== NAVBAR ======== --}}
        <nav class="sticky top-0 z-50 bg-koperasi-bg/95 backdrop-blur-md border-b-2 border-koperasi-black/10"
             x-data="{ mobileMenu: false, cartOpen: false, searchFocused: false }">
            <div class="container-app">
                <div class="flex items-center justify-between h-14">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0" wire:navigate>
                        <div class="w-8 h-8 bg-koperasi-primary border-2 border-koperasi-black rounded-xl flex items-center justify-center shadow-brutal-sm">
                            <svg class="w-4 h-4 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </div>
                        <span class="font-bold text-lg text-koperasi-black hidden sm:block">Koperasi Sembako</span>
                    </a>

                    {{-- Search Bar --}}
                    <div class="hidden md:flex flex-1 max-w-md mx-6">
                        <div class="relative w-full">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-koperasi-dark/40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input type="text"
                                   placeholder="Cari beras, minyak, gula..."
                                   class="input pl-10 py-1.5 text-sm rounded-xl"
                                   @focus="searchFocused = true"
                                   @blur="searchFocused = false">
                        </div>
                    </div>

                    {{-- Right Actions --}}
                    <div class="flex items-center gap-2">
                        {{-- Search Mobile --}}
                        <button class="md:hidden p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>

                        {{-- Rewards / Points (Gamification) --}}
                        @auth
                        <a href="{{ route('rewards') }}" class="flex items-center gap-1.5 p-1.5 px-2.5 rounded-xl bg-koperasi-accent/20 border-2 border-koperasi-primary hover:bg-koperasi-accent/40 transition-colors shadow-brutal-sm" wire:navigate>
                            <svg class="w-4 h-4 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-black font-heading text-koperasi-black tracking-wide">{{ auth()->user()->points_balance ?? 0 }}</span>
                        </a>

                        {{-- Wishlist --}}
                        <a href="{{ route('wishlist') }}" class="p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors relative" wire:navigate>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </a>

                        {{-- Notifications --}}
                        <livewire:notification-bell />
                        @endauth

                        {{-- Cart --}}
                        <a href="{{ route('cart') }}" class="p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors relative" wire:navigate>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            <livewire:storefront.partials.cart-badge />
                        </a>

                        {{-- User Menu --}}
                        @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-1.5 p-1.5 rounded-xl hover:bg-koperasi-dark/5 transition-colors">
                                <div class="w-7 h-7 bg-koperasi-accent border-2 border-koperasi-black rounded-lg flex items-center justify-center text-xs font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <svg class="w-3 h-3 transition-transform" :class="open && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white border-2 border-koperasi-black rounded-xl shadow-brutal overflow-hidden z-50">
                                <a href="{{ route('profile') }}" class="block px-4 py-2.5 text-sm hover:bg-koperasi-accent/30 transition-colors" wire:navigate>Profil Saya</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm hover:bg-koperasi-accent/30 transition-colors" wire:navigate>Pesanan Saya</a>
                                <a href="{{ route('rewards') }}" class="block px-4 py-2.5 text-sm hover:bg-koperasi-accent/30 transition-colors font-bold text-koperasi-primary">Katalog Tukar Poin</a>
                                <hr class="border-koperasi-dark/10">

                                @if(auth()->user()->isSeller() || auth()->user()->isAdmin())
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-sm hover:bg-koperasi-accent/30 transition-colors font-bold text-koperasi-dark">Dashboard Seller</a>
                                    <hr class="border-koperasi-dark/10">
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm hover:bg-red-50 text-red-600 transition-colors">Keluar</button>
                                </form>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="btn-primary btn-sm">Masuk</a>
                        @endauth

                        {{-- Mobile Menu Toggle --}}
                        <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors">
                            <svg x-show="!mobileMenu" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg x-show="mobileMenu" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileMenu" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="md:hidden border-t-2 border-koperasi-dark/10 bg-koperasi-bg pb-4">
                <div class="container-app pt-3 space-y-2">
                    <input type="text" placeholder="Cari produk..." class="input py-2 text-sm">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-medium hover:bg-koperasi-accent/30 transition-colors" wire:navigate>Beranda</a>
                    <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-xl text-sm font-medium hover:bg-koperasi-accent/30 transition-colors" wire:navigate>Semua Produk</a>
                </div>
            </div>
        </nav>

        {{-- ======== MAIN CONTENT ======== --}}
        <main class="min-h-screen">
            {{ $slot }}
        </main>

        {{-- ======== FOOTER ======== --}}
        <footer class="bg-koperasi-dark text-koperasi-bg mt-16">
            <div class="container-app py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    {{-- Brand --}}
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-koperasi-primary border-2 border-koperasi-bg rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg">Koperasi Sembako</span>
                        </div>
                        <p class="text-sm text-koperasi-bg/60 max-w-sm leading-relaxed">Belanja kebutuhan pokok harian dengan harga koperasi yang terjangkau. Kepastian stok, harga jujur, dan pelayanan amanah.</p>
                    </div>

                    {{-- Links --}}
                    <div>
                        <h5 class="font-semibold text-sm mb-3 text-koperasi-bg">Navigasi</h5>
                        <ul class="space-y-2 text-sm text-koperasi-bg/60">
                            <li><a href="{{ route('home') }}" class="hover:text-koperasi-primary transition-colors" wire:navigate>Beranda</a></li>
                            <li><a href="{{ route('products.index') }}" class="hover:text-koperasi-primary transition-colors" wire:navigate>Semua Produk</a></li>
                        </ul>
                    </div>

                    {{-- Contact --}}
                    <div>
                        <h5 class="font-semibold text-sm mb-3 text-koperasi-bg">Hubungi Kami</h5>
                        <ul class="space-y-2 text-sm text-koperasi-bg/60">
                            <li>Jl. Koperasi No. 17, Surabaya</li>
                            <li>081234567890</li>
                            <li>Buka: 07.00 - 21.00 WIB</li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-koperasi-bg/10 mt-8 pt-6 text-center text-xs text-koperasi-bg/40">
                    {{ date('Y') }} Koperasi Sembako Makmur Jaya. Semua hak dilindungi.
                </div>
            </div>
        </footer>

        {{-- ======== TOAST NOTIFICATION ======== --}}
        <x-ui.toast-container />

        {{-- ======== OFFLINE BANNER ======== --}}
        <x-ui.offline-banner />

        {{-- ======== LIVEWIRE PROGRESS BAR ======== --}}
        <x-ui.livewire-progress-simple />

        {{-- ======== LIVEWIRE ERROR OVERLAY ======== --}}
        <x-ui.livewire-error />

        {{-- ======== CONFIRM DIALOG ======== --}}
        <x-ui.confirm-dialog />

        {{-- ======== AI CUSTOMER SUPPORT WIDGET ======== --}}
        <livewire:ai-support-widget />

    </body>
</html>
