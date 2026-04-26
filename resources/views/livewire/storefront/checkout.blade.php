<div>
    <div class="container-app py-6">
        <h1 class="text-2xl font-bold text-koperasi-black mb-6">Checkout</h1>

        @if($cartItems->count())
        <form wire:submit="placeOrder">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left: Form --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Fulfillment Type --}}
                    <div class="card-bordered p-5">
                        <h3 class="font-bold text-sm text-koperasi-black mb-3">Metode Pengambilan</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="card p-3 cursor-pointer transition-all {{ $fulfillmentType === 'pickup' ? 'border-2 border-koperasi-primary bg-koperasi-primary/10' : '' }}">
                                <input type="radio" wire:model.live="fulfillmentType" value="pickup" class="sr-only">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 {{ $fulfillmentType === 'pickup' ? 'bg-koperasi-primary' : 'bg-koperasi-dark/10' }} rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3 3 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold">Ambil di Toko</p>
                                        <p class="text-[10px] text-koperasi-dark/50">Gratis</p>
                                    </div>
                                </div>
                            </label>
                            <label class="card p-3 cursor-pointer transition-all {{ $fulfillmentType === 'delivery' ? 'border-2 border-koperasi-primary bg-koperasi-primary/10' : '' }}">
                                <input type="radio" wire:model.live="fulfillmentType" value="delivery" class="sr-only">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 {{ $fulfillmentType === 'delivery' ? 'bg-koperasi-primary' : 'bg-koperasi-dark/10' }} rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.139-.487 1.166-1.108l.397-7.5A1.125 1.125 0 0 0 19.875 9H4.5M8.25 18.75H17.25M12 2.25l5.25 3.75H6.75L12 2.25Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold">Diantar</p>
                                        <p class="text-[10px] text-koperasi-dark/50">Biaya pengiriman</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    @if($fulfillmentType === 'delivery')
                    <div class="card-bordered p-5 space-y-6">
                        <div>
                            <h3 class="font-bold text-sm text-koperasi-black mb-3">Alamat Pengiriman</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="input-label">Nama Penerima</label>
                                    <input type="text" wire:model="recipient" class="input" placeholder="Nama lengkap">
                                    @error('recipient') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="input-label">No. Telepon</label>
                                    <input type="text" wire:model="phone" class="input" placeholder="08xxxxxxxx">
                                    @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="input-label">Alamat Lengkap</label>
                                    <textarea wire:model="address" class="input" rows="2" placeholder="Jl. ..., RT/RW, Kelurahan"></textarea>
                                    @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="input-label">Kota</label>
                                    <input type="text" wire:model="city" class="input" placeholder="Kota / Kabupaten">
                                    @error('city') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="input-label">Kode Pos</label>
                                    <input type="text" wire:model="postalCode" class="input" placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <hr class="border-koperasi-dark/10">

                        {{-- Courier Selection --}}
                        <div>
                            <h3 class="font-bold text-sm text-koperasi-black mb-3">Pilih Kurir Pengiriman</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach(\App\Models\Order::COURIERS as $name => $config)
                                <label class="relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all hover:bg-koperasi-bg
                                             {{ $selectedCourier === $name ? 'border-koperasi-dark bg-koperasi-primary/5 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]' : 'border-koperasi-dark/10' }}">
                                    <input type="radio" wire:model.live="selectedCourier" value="{{ $name }}" class="sr-only">
                                    <div class="h-8 flex items-center justify-center">
                                        <img src="{{ $config['logo'] }}" alt="{{ $name }}" class="max-h-full max-w-[60px] object-contain filter {{ $selectedCourier === $name ? '' : 'grayscale opacity-60' }} transition-all">
                                    </div>
                                    <div class="text-center">
                                        <p class="text-[11px] font-bold text-koperasi-black leading-tight">{{ $name }}</p>
                                        <p class="text-[10px] text-koperasi-dark/50">Rp {{ number_format($config['base_rate'], 0, ',', '.') }}</p>
                                    </div>
                                    @if($selectedCourier === $name)
                                    <div class="absolute -top-1 -right-1 bg-koperasi-dark text-koperasi-primary rounded-full p-0.5 shadow-sm">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @endif
                                </label>
                                @endforeach
                            </div>
                            @error('selectedCourier') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    @else
                    <div class="card-bordered p-5">
                        <h3 class="font-bold text-sm text-koperasi-black mb-2">Lokasi Pengambilan</h3>
                        <p class="text-sm text-koperasi-dark/70">Koperasi Sembako Makmur Jaya</p>
                        <p class="text-xs text-koperasi-dark/50">Jl. Koperasi No. 17, Kelurahan Makmur, Surabaya</p>
                        <p class="text-xs text-koperasi-dark/50">Buka: 07.00 - 21.00 WIB</p>
                    </div>
                    @endif

                    {{-- Notes --}}
                    <div class="card-bordered p-5">
                        <h3 class="font-bold text-sm text-koperasi-black mb-3">Catatan Pesanan</h3>
                        <textarea wire:model="notes" class="input" rows="2" placeholder="Catatan untuk penjual (opsional)"></textarea>
                    </div>

                    {{-- Coupon --}}
                    <div class="card-bordered p-5">
                        <h3 class="font-bold text-sm text-koperasi-black mb-3">Kode Kupon</h3>
                        @if($appliedCoupon)
                            <div class="flex items-center justify-between bg-koperasi-accent/30 rounded-xl p-3">
                                <div>
                                    <span class="badge-primary">{{ $appliedCoupon['code'] }}</span>
                                    <span class="text-xs text-koperasi-dark/70 ml-2">Hemat Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                                </div>
                                <button type="button" wire:click="removeCoupon" class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </div>
                        @else
                            <div class="flex gap-2">
                                <input type="text" wire:model="couponCode" class="input flex-1" placeholder="Masukkan kode kupon" style="text-transform: uppercase;">
                                <button type="button" wire:click="applyCoupon" class="btn-secondary btn-sm">Terapkan</button>
                            </div>
                            @if($couponError)
                                <p class="text-xs text-red-500 mt-1">{{ $couponError }}</p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Right: Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="card-bordered p-5 sticky top-20">
                        <h3 class="font-bold text-sm text-koperasi-black mb-4">Ringkasan Pesanan</h3>

                        {{-- Items --}}
                        <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-koperasi-dark/70 line-clamp-1 flex-1 mr-2">{{ $item['product']->name }} x{{ $item['qty'] }}</span>
                                <span class="font-medium flex-shrink-0">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <hr class="border-koperasi-dark/10 my-3">

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-koperasi-dark/60">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($discountAmount > 0)
                            <div class="flex justify-between text-green-700">
                                <span>Diskon Kupon</span>
                                <span class="font-medium">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-koperasi-dark/60">Ongkos Kirim</span>
                                @if($fulfillmentType === 'delivery')
                                    <span class="font-medium {{ $shippingCost > 0 ? 'text-koperasi-black' : 'text-green-700' }}">
                                        {{ $shippingCost > 0 ? 'Rp ' . number_format($shippingCost, 0, ',', '.') : 'Pilih Kurir' }}
                                    </span>
                                @else
                                    <span class="font-medium text-green-700">Gratis (Ambil)</span>
                                @endif
                            </div>
                        </div>

                        <hr class="border-koperasi-dark/10 my-3">

                        <div class="flex justify-between text-lg font-bold text-koperasi-black">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn-primary w-full mt-4 justify-center btn-lg" wire:loading.attr="disabled">
                            <span wire:loading.remove>Buat Pesanan</span>
                            <span wire:loading>Memproses...</span>
                        </button>

                        <p class="text-[10px] text-koperasi-dark/40 text-center mt-2">Pembayaran saat pengambilan (COD)</p>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <h3>Keranjang Kosong</h3>
            <p>Tambahkan produk ke keranjang terlebih dahulu</p>
            <a href="{{ route('products.index') }}" class="btn-primary btn-sm mt-4" wire:navigate>Belanja Sekarang</a>
        </div>
        @endif
    </div>
</div>
