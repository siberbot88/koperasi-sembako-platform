<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Koperasi Sembako') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-koperasi-dark antialiased bg-koperasi-bg overflow-x-hidden min-h-screen relative selection:bg-koperasi-primary selection:text-koperasi-dark">
        {{-- Decorative Elements --}}
        <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-koperasi-primary rounded-full mix-blend-multiply filter blur-3xl opacity-30 pointer-events-none"></div>
        <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-koperasi-accent rounded-full mix-blend-multiply filter blur-3xl opacity-30 pointer-events-none"></div>
        <div class="fixed inset-0 pattern-grid pointer-events-none z-0"></div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 p-4">
            <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <a href="/" wire:navigate class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-koperasi-primary rounded-xl flex items-center justify-center border-4 border-koperasi-dark shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <svg class="w-8 h-8 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </div>
                    <span class="font-heading font-black text-3xl tracking-tight text-koperasi-dark">Koperasi<span class="text-koperasi-primary" style="text-shadow: 2px 2px 0px #2F2F2F;">Sembako</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white border-4 border-koperasi-dark shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-2xl relative overflow-hidden">
                {{-- Form Content --}}
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
            
            <p class="mt-8 text-sm font-bold text-koperasi-dark/60">&copy; {{ date('Y') }} Koperasi Sembako. All rights reserved.</p>
        </div>
    </body>
</html>
