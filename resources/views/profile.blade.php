<x-storefront-layout>
    <div class="container-app py-8 lg:py-12">
        <div class="flex items-center gap-3 mb-8">
            <h1 class="text-3xl font-black font-heading text-koperasi-dark uppercase tracking-tight">Profil Saya</h1>
            <div class="h-1 flex-1 bg-koperasi-dark/5 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Sidebar --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="card-bordered p-6 text-center">
                    <div class="w-24 h-24 bg-koperasi-accent border-[3px] border-koperasi-dark rounded-full mx-auto mb-4 flex items-center justify-center text-3xl font-black font-heading text-koperasi-dark shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-koperasi-dark mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-sm font-medium text-koperasi-dark/60 mb-4">{{ auth()->user()->email }}</p>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-koperasi-primary/20 border-2 border-koperasi-dark rounded-lg">
                        <svg class="w-4 h-4 text-koperasi-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-black font-heading">{{ auth()->user()->points_balance ?? 0 }} Pts</span>
                    </div>
                </div>

                <div class="card-bordered p-4">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-koperasi-dark/5 transition-colors font-bold text-koperasi-dark" wire:navigate>
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                                Riwayat Pesanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rewards') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-koperasi-dark/5 transition-colors font-bold text-koperasi-dark" wire:navigate>
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.375c0 .621-.504 1.125-1.125 1.125H2.25m17.25-3l-3-3m0 0l-3 3m3-3v10.5m-1.5-10.5h1.5" /></svg>
                                Voucher & Reward
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Main Form Content --}}
            <div class="lg:col-span-8 space-y-8">
                <div class="card-bordered p-6 lg:p-8">
                    <livewire:profile.update-profile-information-form />
                </div>

                <div class="card-bordered p-6 lg:p-8">
                    <livewire:profile.update-password-form />
                </div>

                <div class="border-[3px] border-red-200 bg-red-50 rounded-2xl p-6 lg:p-8 shadow-[4px_4px_0px_0px_rgba(254,202,202,1)]">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-storefront-layout>
