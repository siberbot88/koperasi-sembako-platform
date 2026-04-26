<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Dashboard' }} - Koperasi Sembako</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-koperasi-bg text-koperasi-dark" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">

            {{-- ======== SIDEBAR ======== --}}
            {{-- Overlay --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 bg-koperasi-black/40 z-40 lg:hidden"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 x-cloak></div>

            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed lg:sticky top-0 left-0 z-50 w-60 h-screen bg-koperasi-dark text-koperasi-bg flex flex-col
                          transition-transform duration-200 ease-out lg:translate-x-0">

                {{-- Logo --}}
                <div class="flex items-center gap-2.5 px-5 h-14 border-b border-koperasi-bg/10 flex-shrink-0">
                    <div class="w-7 h-7 bg-koperasi-primary rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </div>
                    <span class="font-bold text-sm">Seller Dashboard</span>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    @php
                        $navItems = [
                            ['route' => 'seller.dashboard', 'label' => 'Dashboard', 'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z'],
                            ['route' => 'seller.products', 'label' => 'Produk', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
                            ['route' => 'seller.orders', 'label' => 'Pesanan', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z'],
                            ['route' => 'seller.promotions', 'label' => 'Promosi', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z M6 6h.008v.008H6V6Z'],
                            ['route' => 'seller.reviews', 'label' => 'Ulasan', 'icon' => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z'],
                            ['route' => 'seller.settings', 'label' => 'Pengaturan', 'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z'],
                        ];
                    @endphp

                     @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                                  {{ request()->routeIs($item['route']) ? 'bg-koperasi-primary text-koperasi-black' : 'text-koperasi-bg/70 hover:text-koperasi-bg hover:bg-koperasi-bg/10' }}"
                          >
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                {{-- Sidebar Footer --}}
                <div class="px-3 pb-4 border-t border-koperasi-bg/10 pt-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs text-koperasi-bg/50 hover:text-koperasi-bg hover:bg-koperasi-bg/10 transition-colors" target="_blank">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Lihat Toko
                    </a>
                </div>
            </aside>

            {{-- ======== MAIN AREA ======== --}}
            <div class="flex-1 flex flex-col min-h-screen">

                {{-- Top Bar --}}
                <header class="sticky top-0 z-30 bg-koperasi-bg/95 backdrop-blur-md border-b border-koperasi-dark/10 h-14 flex items-center px-4 lg:px-6">
                    {{-- Mobile sidebar toggle --}}
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors mr-3">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    {{-- Page Title --}}
                    <div class="flex-1">
                        @if(isset($header))
                            <h1 class="text-lg font-bold text-koperasi-black">{{ $header }}</h1>
                        @endif
                    </div>

                    {{-- Right --}}
                    <div class="flex items-center gap-3">
                        {{-- Notifications --}}
                        <button class="p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors relative">
                            <svg class="w-5 h-5 text-koperasi-dark/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </button>

                        {{-- User --}}
                        @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-koperasi-accent border-2 border-koperasi-dark rounded-lg flex items-center justify-center text-xs font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium hidden sm:block">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-44 bg-white border-2 border-koperasi-dark rounded-xl shadow-brutal overflow-hidden z-50" x-cloak>
                                <a href="{{ route('seller.settings') }}" class="block px-4 py-2.5 text-sm hover:bg-koperasi-accent/30 transition-colors" wire:navigate>Pengaturan</a>
                                <hr class="border-koperasi-dark/10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm hover:bg-red-50 text-red-600 transition-colors">Keluar</button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="flex-1 p-4 lg:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        {{-- Toast --}}
        <div x-data="{ toasts: [] }"
             @toast.window="toasts.push({ id: Date.now(), message: $event.detail.message, type: $event.detail.type || 'success' }); setTimeout(() => toasts.shift(), 3000)"
             class="fixed bottom-6 right-6 z-[60] space-y-2">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-transition :class="toast.type === 'error' ? 'toast-error' : 'toast-success'" x-text="toast.message"></div>
            </template>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @stack('scripts')
    </body>
</html>
