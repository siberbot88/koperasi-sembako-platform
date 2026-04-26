<div class="space-y-6" x-data="{ activeTab: 'basic' }">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-koperasi-black">Pengaturan Toko</h1>
            <p class="text-sm text-koperasi-dark/60 mt-1">Kelola informasi dan tampilan toko Anda</p>
        </div>
        <button wire:click="save" class="btn-primary">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
            </svg>
            Simpan Perubahan
        </button>
    </div>

    {{-- Tabs Navigation --}}
    <div class="card-bordered p-1 flex gap-1 overflow-x-auto">
        <button 
            @click="activeTab = 'basic'"
            :class="activeTab === 'basic' ? 'bg-koperasi-primary text-koperasi-dark' : 'text-koperasi-dark/60 hover:text-koperasi-dark hover:bg-koperasi-dark/5'"
            class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap flex items-center gap-2"
        >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
            </svg>
            Informasi Dasar
        </button>
        <button 
            @click="activeTab = 'visual'"
            :class="activeTab === 'visual' ? 'bg-koperasi-primary text-koperasi-dark' : 'text-koperasi-dark/60 hover:text-koperasi-dark hover:bg-koperasi-dark/5'"
            class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap flex items-center gap-2"
        >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
            </svg>
            Profil Visual
        </button>
        <button 
            @click="activeTab = 'operational'"
            :class="activeTab === 'operational' ? 'bg-koperasi-primary text-koperasi-dark' : 'text-koperasi-dark/60 hover:text-koperasi-dark hover:bg-koperasi-dark/5'"
            class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap flex items-center gap-2"
        >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
            </svg>
            Operasional
        </button>
        <button 
            @click="activeTab = 'social'"
            :class="activeTab === 'social' ? 'bg-koperasi-primary text-koperasi-dark' : 'text-koperasi-dark/60 hover:text-koperasi-dark hover:bg-koperasi-dark/5'"
            class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap flex items-center gap-2"
        >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
                <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
            </svg>
            Media Sosial
        </button>
        <button 
            @click="activeTab = 'policies'"
            :class="activeTab === 'policies' ? 'bg-koperasi-primary text-koperasi-dark' : 'text-koperasi-dark/60 hover:text-koperasi-dark hover:bg-koperasi-dark/5'"
            class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap flex items-center gap-2"
        >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
            </svg>
            Kebijakan
        </button>
    </div>

    {{-- Tab Content --}}
    <form wire:submit="save">
        {{-- Basic Info Tab --}}
        <div x-show="activeTab === 'basic'" x-cloak>
            @include('livewire.seller.settings.basic-info')
        </div>

        {{-- Visual Tab --}}
        <div x-show="activeTab === 'visual'" x-cloak>
            @include('livewire.seller.settings.visual')
        </div>

        {{-- Operational Tab --}}
        <div x-show="activeTab === 'operational'" x-cloak>
            @include('livewire.seller.settings.operational')
        </div>

        {{-- Social Media Tab --}}
        <div x-show="activeTab === 'social'" x-cloak>
            @include('livewire.seller.settings.social-media')
        </div>

        {{-- Policies Tab --}}
        <div x-show="activeTab === 'policies'" x-cloak>
            @include('livewire.seller.settings.policies')
        </div>
    </form>
</div>
