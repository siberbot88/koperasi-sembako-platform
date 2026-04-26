<div>
    <div class="container-app py-6">
        <h1 class="text-2xl font-bold text-koperasi-black mb-6">Keranjang Belanja</h1>

        @if($cartItems->count())
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-3">
                @foreach($cartItems as $item)
                <div class="card-bordered p-4">
                    <div class="flex gap-4">
                        {{-- Thumbnail --}}
                        <div class="w-20 h-20 bg-koperasi-dark/5 rounded-xl overflow-hidden flex-shrink-0">
                            @if($item['product']->thumbnail)
                                <img src="{{ asset('storage/' . $item['product']->thumbnail) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-koperasi-dark/15" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a2.25 2.25 0 0 0 2.25-2.25V5.25a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item['product']->slug) }}" class="text-sm font-semibold text-koperasi-dark hover:text-koperasi-black transition-colors line-clamp-2" wire:navigate>
                                {{ $item['product']->name }}
                            </a>
                            <p class="text-xs text-koperasi-dark/50 mt-0.5">per {{ $item['product']->unit }}</p>
                            <p class="text-sm font-bold text-koperasi-black mt-1">Rp {{ number_format($item['product']->effective_price, 0, ',', '.') }}</p>
                        </div>

                        {{-- Qty & Actions --}}
                        <div class="flex flex-col items-end justify-between">
                            <button wire:click="removeItem('{{ $item['product']->_id }}')" class="p-1 rounded-lg hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>

                            <div class="flex items-center border-2 border-koperasi-black rounded-lg overflow-hidden">
                                <button wire:click="updateQty('{{ $item['product']->_id }}', {{ max(1, $item['qty'] - 1) }})" class="px-2 py-1 text-xs font-bold hover:bg-koperasi-dark/5">-</button>
                                <span class="px-3 py-1 text-xs font-bold border-x-2 border-koperasi-black min-w-[2rem] text-center">{{ $item['qty'] }}</span>
                                <button wire:click="updateQty('{{ $item['product']->_id }}', {{ $item['qty'] + 1 }})" class="px-2 py-1 text-xs font-bold hover:bg-koperasi-dark/5">+</button>
                            </div>

                            <p class="text-sm font-bold text-koperasi-black mt-1">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <button 
                    @click="$dispatch('confirm', {
                        title: 'Kosongkan Keranjang?',
                        message: 'Semua produk di keranjang akan dihapus.',
                        confirmText: 'Ya, Kosongkan',
                        cancelText: 'Batal',
                        type: 'warning',
                        onConfirm: '$wire.clearCart()'
                    })"
                    class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors">
                    Kosongkan Keranjang
                </button>
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="card-bordered p-5 sticky top-20">
                    <h3 class="font-bold text-sm text-koperasi-black mb-4">Ringkasan Belanja</h3>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-koperasi-dark/60">Total ({{ $cartItems->count() }} produk)</span>
                            <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <hr class="my-4 border-koperasi-dark/10">

                    <div class="flex justify-between text-base font-bold text-koperasi-black">
                        <span>Total</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn-primary w-full mt-4 justify-center" wire:navigate>
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        Lanjut Checkout
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <h3>Keranjang Kosong</h3>
            <p>Yuk mulai belanja kebutuhan pokok harian Anda</p>
            <a href="{{ route('products.index') }}" class="btn-primary btn-sm mt-4" wire:navigate>Belanja Sekarang</a>
        </div>
        @endif
    </div>
</div>
