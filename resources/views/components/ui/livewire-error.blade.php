<div
    x-data="livewireError()"
    x-init="init()"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[9995] flex items-end sm:items-center justify-center p-4 sm:p-6"
    @keydown.escape.window="dismiss()"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-koperasi-dark/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Card --}}
    <div
        class="relative w-full max-w-md bg-white rounded-2xl border-2 border-koperasi-dark shadow-brutal overflow-hidden"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        @click.stop
    >
        {{-- Top accent bar --}}
        <div :class="type === 'server' ? 'bg-red-500' : 'bg-orange-400'" class="h-1.5 w-full"></div>

        <div class="p-6">
            <div class="flex items-start gap-4">
                {{-- Icon --}}
                <div :class="type === 'server' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <template x-if="type === 'connection'">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M1.606 6.08a10.5 10.5 0 0 1 10.88-2.795 1 1 0 0 1-.483 1.94 8.5 8.5 0 0 0-8.8 2.26 1 1 0 0 1-1.597-1.205Zm14.347.67a1 1 0 0 1 1.377-.315 8.5 8.5 0 0 1 3.168 3.337 1 1 0 0 1-1.748.974 6.5 6.5 0 0 0-2.42-2.55 1 1 0 0 1-.377-1.446ZM5.84 10.2a1 1 0 0 1 1.377-.316 6.5 6.5 0 0 1 3.09 4.11 1 1 0 0 1-1.94.484 4.5 4.5 0 0 0-2.14-2.84 1 1 0 0 1-.387-1.438ZM12 15.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" clip-rule="evenodd"/>
                            <path d="M3.22 3.22a.75.75 0 0 1 1.06 0l16.5 16.5a.75.75 0 1 1-1.06 1.06L3.22 4.28a.75.75 0 0 1 0-1.06Z"/>
                        </svg>
                    </template>
                    <template x-if="type === 'server'">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.25 6a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V6Zm3.97.97a.75.75 0 0 1 1.06 0l2 2 2-2a.75.75 0 1 1 1.06 1.06l-2 2 2 2a.75.75 0 1 1-1.06 1.06l-2-2-2 2a.75.75 0 0 1-1.06-1.06l2-2-2-2a.75.75 0 0 1 0-1.06Zm7.5 0a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5a.75.75 0 0 1 .75-.75Zm0 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Z" clip-rule="evenodd"/>
                        </svg>
                    </template>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-koperasi-dark text-base" x-text="type === 'server' ? 'Terjadi Kesalahan Server' : 'Koneksi Terputus'"></h3>
                    <p class="text-sm text-koperasi-dark/60 mt-1 leading-relaxed"
                       x-text="type === 'server'
                           ? 'Server mengalami gangguan. Tim kami sedang menangani masalah ini.'
                           : 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.'">
                    </p>
                    <p x-show="type === 'connection' && countdown > 0" class="text-xs text-koperasi-dark/40 mt-2">
                        Mencoba ulang dalam <span class="font-bold text-orange-500" x-text="countdown"></span> detik...
                    </p>
                </div>
            </div>

            <div class="flex gap-3 mt-5">
                <button @click="dismiss()" class="flex-1 btn btn-outline text-sm">Tutup</button>
                <button
                    @click="retry()"
                    :disabled="retrying"
                    class="flex-1 btn btn-primary text-sm disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <svg :class="retrying ? 'animate-spin' : ''" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd"/>
                    </svg>
                    <span x-text="retrying ? 'Memuat...' : 'Muat Ulang'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
