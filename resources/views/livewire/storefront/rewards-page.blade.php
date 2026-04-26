<div>
    <div class="container-app py-8 lg:py-12">
        {{-- Premium Header Banner --}}
        <div
            class="relative bg-koperasi-dark text-white rounded-3xl p-8 lg:p-10 shadow-[8px_8px_0px_0px_rgba(210,248,152,1)] mb-12 overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 border-4 border-koperasi-dark">
            {{-- Decorative bg --}}
            <div
                class="absolute -right-20 -top-20 w-64 h-64 bg-koperasi-primary rounded-full opacity-30 blur-3xl mix-blend-screen">
            </div>
            <div
                class="absolute -left-20 -bottom-20 w-64 h-64 bg-koperasi-accent rounded-full opacity-20 blur-3xl mix-blend-screen">
            </div>

            <div class="relative z-10 text-center md:text-left max-w-xl">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 bg-koperasi-primary/20 text-koperasi-primary border border-koperasi-primary/30 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>
                    Program Loyalitas
                </div>
                <h1 class="text-4xl lg:text-5xl font-heading font-black text-white mb-4 leading-tight">Tukar Poin <span
                        class="text-koperasi-primary">Koperasi</span></h1>
                <p class="text-sm lg:text-base text-white/80 leading-relaxed">Kumpulkan poin dari setiap pembelanjaan
                    (Rp 10.000 = 10 Poin) dan tukarkan dengan voucher belanja eksklusif. Makin sering belanja, makin
                    hemat!</p>
            </div>

            <div class="relative z-10 shrink-0">
                <div
                    class="bg-gradient-to-br from-koperasi-primary to-[#E3FFB0] rounded-2xl p-1 shadow-lg transform rotate-2 hover:rotate-0 transition-transform duration-300">
                    <div
                        class="bg-koperasi-dark rounded-xl px-8 py-6 text-center border-2 border-koperasi-primary/50 relative overflow-hidden">
                        <div class="absolute inset-0 bg-koperasi-primary/5 pattern-dots"></div>
                        <p class="relative text-xs uppercase tracking-wider font-bold text-koperasi-primary mb-2">Saldo
                            Poin Anda</p>
                        <div class="relative flex items-baseline justify-center gap-2">
                            <span
                                class="text-6xl font-black font-heading text-white leading-none tracking-tighter">{{ number_format($points) }}</span>
                            <span class="text-xl font-bold text-koperasi-primary">Pts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            {{-- Left: Katalog --}}
            <div class="lg:col-span-8">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-black font-heading text-koperasi-dark uppercase tracking-tight">Katalog
                        Reward</h2>
                    <div class="h-1 flex-1 bg-koperasi-dark/5 rounded-full"></div>
                </div>

                @if($templates->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach($templates as $template)
                            <div
                                class="bg-white rounded-2xl border-[3px] border-koperasi-dark p-6 relative overflow-hidden group shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-4px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all flex flex-col justify-between h-full">
                                {{-- Decorative Ticket Cutouts --}}
                                <div
                                    class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-koperasi-bg rounded-full border-[3px] border-koperasi-dark border-r-transparent border-t-transparent rotate-45 z-10">
                                </div>
                                <div
                                    class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-koperasi-bg rounded-full border-[3px] border-koperasi-dark border-l-transparent border-b-transparent rotate-45 z-10">
                                </div>

                                <div
                                    class="absolute top-0 right-0 w-32 h-32 bg-koperasi-primary/10 rounded-bl-full -z-0 transition-transform duration-500 group-hover:scale-150">
                                </div>

                                <div class="relative z-10 flex-1">
                                    <div
                                        class="w-14 h-14 bg-koperasi-primary border-2 border-koperasi-dark rounded-xl flex items-center justify-center mb-5 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transform -rotate-3 group-hover:rotate-0 transition-transform">
                                        <svg class="w-7 h-7 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                    </div>

                                    {{-- Store name badge --}}
                                    @if($template->store)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-koperasi-dark/60 bg-koperasi-dark/5 border border-koperasi-dark/10 rounded-md px-2 py-0.5 mb-3">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                                        </svg>
                                        {{ $template->store->name }}
                                    </span>
                                    @endif

                                    <h3 class="font-black font-heading text-2xl text-koperasi-dark mb-1 leading-tight">
                                        Diskon
                                        {{ $template->type === 'percentage' ? $template->value . '%' : 'Rp ' . number_format($template->value, 0, ',', '.') }}
                                        @if($template->type === 'percentage' && $template->max_discount)
                                        <span class="text-sm font-medium text-koperasi-dark/50">(maks. Rp {{ number_format($template->max_discount, 0, ',', '.') }})</span>
                                        @endif
                                    </h3>
                                    <p class="text-sm font-medium text-koperasi-dark/60 mb-1">
                                        Min. belanja Rp {{ number_format($template->min_order_amount, 0, ',', '.') }}
                                    </p>
                                    @if($template->valid_until)
                                    <p class="text-xs font-medium text-koperasi-dark/40 mb-4">
                                        Berlaku s/d {{ $template->valid_until->format('d M Y') }}
                                    </p>
                                    @else
                                    <p class="text-xs font-medium text-koperasi-dark/40 mb-4">Berlaku selamanya</p>
                                    @endif
                                </div>

                                <div
                                    class="relative z-10 mt-auto pt-5 border-t-2 border-dashed border-koperasi-dark/20 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 text-koperasi-dark font-black">
                                        <span
                                            class="bg-koperasi-accent px-2 py-1 rounded text-sm shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] border border-koperasi-dark flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                            </svg>
                                            {{ $template->points_cost }} Pts
                                        </span>
                                    </div>

                                    @if($points >= $template->points_cost)
                                        <button 
                                            @click="$dispatch('confirm', {
                                                title: 'Tukar Poin?',
                                                message: 'Tukar {{ $template->points_cost }} poin dengan voucher {{ $template->code }}?',
                                                confirmText: 'Ya, Tukar',
                                                cancelText: 'Batal',
                                                type: 'info',
                                                onConfirm: '$wire.redeem(\'{{ $template->_id }}\')'
                                            })"
                                            class="btn-primary py-2 px-5 text-sm uppercase tracking-wider">Tukar</button>
                                    @else
                                        <button disabled
                                            class="py-2 px-5 bg-gray-100 text-gray-400 border-2 border-gray-200 cursor-not-allowed rounded-xl font-bold text-sm uppercase tracking-wider">Poin
                                            Kurang</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <h3>Katalog Sedang Kosong</h3>
                        <p>Nantikan promo voucher tukar poin selanjutnya!</p>
                    </div>
                @endif
            </div>

            {{-- Right: Voucher Saya --}}
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-black font-heading text-koperasi-dark uppercase tracking-tight">Kupon Saya
                    </h2>
                    <div class="h-1 flex-1 bg-koperasi-dark/5 rounded-full lg:hidden"></div>
                </div>

                <div
                    class="bg-white rounded-2xl border-[3px] border-koperasi-dark p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] sticky top-24">
                    @if($myCoupons->count())
                        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($myCoupons as $coupon)
                                <div
                                    class="bg-koperasi-bg border-2 border-koperasi-dark rounded-xl p-4 relative overflow-hidden group">
                                    @if($coupon->used_count >= $coupon->usage_limit)
                                        <div
                                            class="absolute inset-0 bg-white/80 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                            <span
                                                class="bg-koperasi-dark text-white text-[10px] font-black px-4 py-1.5 rounded-sm uppercase tracking-[0.2em] shadow-[2px_2px_0px_0px_rgba(210,248,152,1)] border border-koperasi-primary transform -rotate-6">Terpakai</span>
                                        </div>
                                    @elseif(now()->gt($coupon->valid_until))
                                        <div
                                            class="absolute inset-0 bg-white/80 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                            <span
                                                class="bg-red-500 text-white text-[10px] font-black px-4 py-1.5 rounded-sm uppercase tracking-[0.2em] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] border border-koperasi-dark transform -rotate-6">Kedaluwarsa</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-koperasi-primary border border-koperasi-dark flex items-center justify-center shadow-[1px_1px_0px_0px_rgba(0,0,0,1)]">
                                                <svg class="w-4 h-4 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m9 14.25 6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185ZM9.75 9h.008v.008H9.75V9Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008V13.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                </svg>
                                            </div>
                                            <p class="font-black text-sm text-koperasi-dark uppercase">Diskon
                                                {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'Rp ' . number_format($coupon->value, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-white rounded border-2 border-dashed border-koperasi-dark p-2 flex items-center justify-between mb-2">
                                        <span
                                            class="font-mono font-bold tracking-widest text-sm px-1 text-koperasi-dark">{{ $coupon->code }}</span>
                                        <button
                                            onclick="navigator.clipboard.writeText('{{ $coupon->code }}'); alert('Kode disalin!')"
                                            class="text-[10px] bg-koperasi-dark text-white hover:bg-koperasi-primary hover:text-koperasi-dark font-bold uppercase tracking-wider px-2 py-1 rounded transition-colors shadow-[1px_1px_0px_0px_rgba(210,248,152,1)]">
                                            Salin
                                        </button>
                                    </div>
                                    <p class="text-[10px] font-bold text-koperasi-dark/50 text-center uppercase tracking-wider">
                                        S/D {{ $coupon->valid_until->format('d M Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="text-center py-8 px-4 border-2 border-dashed border-koperasi-dark/20 rounded-xl bg-koperasi-bg/50">
                            <div
                                class="w-12 h-12 bg-koperasi-dark/5 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-koperasi-dark/30" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-koperasi-dark/50 mb-1">Kupon Masih Kosong</p>
                            <p class="text-xs text-koperasi-dark/40">Tukarkan poin Anda dengan voucher di katalog.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>