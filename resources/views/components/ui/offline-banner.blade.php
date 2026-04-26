<div
    x-data="offlineBanner()"
    x-init="init()"
    x-show="offline"
    x-cloak
    class="fixed top-0 inset-x-0 z-[9998]"
>
    <div class="bg-koperasi-dark text-koperasi-bg border-b-2 border-koperasi-primary px-4 py-2.5 flex items-center justify-center gap-3 text-sm font-semibold shadow-brutal">
        <span class="flex-shrink-0 relative">
            <svg class="w-4 h-4 text-koperasi-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M1.606 6.08a10.5 10.5 0 0 1 10.88-2.795 1 1 0 0 1-.483 1.94 8.5 8.5 0 0 0-8.8 2.26 1 1 0 0 1-1.597-1.205Zm14.347.67a1 1 0 0 1 1.377-.315 8.5 8.5 0 0 1 3.168 3.337 1 1 0 0 1-1.748.974 6.5 6.5 0 0 0-2.42-2.55 1 1 0 0 1-.377-1.446ZM5.84 10.2a1 1 0 0 1 1.377-.316 6.5 6.5 0 0 1 3.09 4.11 1 1 0 0 1-1.94.484 4.5 4.5 0 0 0-2.14-2.84 1 1 0 0 1-.387-1.438ZM12 15.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" clip-rule="evenodd"/>
                <path d="M3.22 3.22a.75.75 0 0 1 1.06 0l16.5 16.5a.75.75 0 1 1-1.06 1.06L3.22 4.28a.75.75 0 0 1 0-1.06Z"/>
            </svg>
            <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
        </span>

        <span>Koneksi internet terputus. Beberapa fitur mungkin tidak tersedia.</span>

        <button
            @click="tryReconnect()"
            :disabled="reconnecting"
            class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1 bg-koperasi-primary text-koperasi-black text-xs font-bold rounded-lg border border-koperasi-black hover:bg-yellow-300 transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
        >
            <svg :class="reconnecting ? 'animate-spin' : ''" class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd"/>
            </svg>
            <span x-text="reconnecting ? 'Mencoba...' : 'Coba Lagi'"></span>
        </button>
    </div>
</div>
