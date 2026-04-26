<div>
    <div class="container-app py-6">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs text-koperasi-dark/50 mb-4">
            <a href="{{ route('home') }}" class="hover:text-koperasi-dark" wire:navigate>Beranda</a>
            <span>/</span>
            <a href="{{ route('orders.index') }}" class="hover:text-koperasi-dark" wire:navigate>Pesanan Saya</a>
            <span>/</span>
            <span class="text-koperasi-dark">{{ $order->order_number }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Order Detail --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Order Header --}}
                <div class="card-bordered p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <div>
                            <h1 class="text-xl font-bold text-koperasi-black">Pesanan {{ $order->order_number }}</h1>
                            <p class="text-xs text-koperasi-dark/50 mt-0.5">{{ $order->created_at?->format('d M Y, H:i') }}</p>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'ready' => 'bg-green-100 text-green-800 border-green-300',
                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                                'completed' => 'bg-koperasi-accent text-koperasi-dark border-koperasi-dark/20',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-300',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu Konfirmasi',
                                'processing' => 'Sedang Diproses',
                                'ready' => 'Siap Diambil',
                                'shipped' => 'Sedang Dikirim',
                                'completed' => 'Pesanan Selesai',
                                'cancelled' => 'Pesanan Dibatalkan',
                            ];
                        @endphp
                        <span class="badge {{ $statusColors[$order->status] ?? '' }} text-sm px-3 py-1">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                    </div>

                    {{-- Status Timeline --}}
                    @if($order->status_history && count($order->status_history) > 0)
                    <div class="border-t border-koperasi-dark/10 pt-4">
                        <h4 class="text-xs font-semibold text-koperasi-dark/50 uppercase tracking-wider mb-3">Riwayat Status</h4>
                        <div class="space-y-2">
                            @foreach(array_reverse($order->status_history) as $history)
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-koperasi-primary mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-medium">{{ ucfirst($history['status']) }}</p>
                                    <p class="text-[10px] text-koperasi-dark/50">{{ \Carbon\Carbon::parse($history['changed_at'])->format('d M Y, H:i') }}</p>
                                    @if($history['note'] ?? null)
                                    <p class="text-xs text-koperasi-dark/60 mt-0.5">{{ $history['note'] }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Shipment Tracking Info --}}
                @if($order->shipment)
                <div class="card-bordered p-5 border-l-4 border-l-koperasi-primary bg-koperasi-bg/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-sm text-koperasi-black mb-1">Informasi Pengiriman</h3>
                            <p class="text-xs text-koperasi-dark/60 mb-3">Pesanan Anda dikirim menggunakan layanan kurir</p>
                            
                            <div class="flex flex-wrap items-center gap-6">
                                <div>
                                    <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-bold mb-0.5">Kurir</p>
                                    <p class="text-sm font-bold text-koperasi-black">{{ $order->shipment['courier'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-bold mb-0.5">Nomor Resi</p>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold font-mono text-koperasi-primary">{{ $order->shipment['tracking_number'] ?? '-' }}</p>
                                        <button class="text-xs text-koperasi-dark/40 hover:text-koperasi-dark transition-colors" title="Salin Resi">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <div class="w-12 h-12 bg-koperasi-primary/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Items --}}
                <div class="card-bordered p-5">
                    <h3 class="font-bold text-sm text-koperasi-black mb-3">Item Pesanan</h3>
                    <div class="space-y-3">
                        @foreach($order->items ?? [] as $item)
                        <div class="flex items-center gap-3 pb-3 border-b border-koperasi-dark/5 last:border-0 last:pb-0">
                            <div class="w-12 h-12 bg-koperasi-dark/5 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($item['snapshot_image'] ?? null)
                                    <img src="{{ asset('storage/' . $item['snapshot_image']) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-koperasi-dark/15" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-koperasi-dark">{{ $item['snapshot_name'] ?? '-' }}</p>
                                <p class="text-[10px] text-koperasi-dark/50">{{ $item['qty'] }} x Rp {{ number_format($item['snapshot_price'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-bold text-koperasi-black">Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Review Section (only for completed orders) --}}
                @if($order->status === 'completed')
                <div class="card-bordered p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-koperasi-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-bold text-sm text-koperasi-black">Beri Ulasan Produk</h3>
                    </div>

                    <div class="space-y-6">
                        @foreach($order->items ?? [] as $item)
                        <div class="pb-6 border-b border-koperasi-dark/10 last:pb-0 last:border-0">
                            {{-- Item info mini header --}}
                            <div class="flex items-center gap-2 mb-3">
                                @if($item['snapshot_image'] ?? null)
                                <img src="{{ asset('storage/' . $item['snapshot_image']) }}" class="w-8 h-8 rounded-lg object-cover border border-koperasi-dark/10">
                                @endif
                                <p class="text-sm font-semibold text-koperasi-dark line-clamp-1">{{ $item['snapshot_name'] ?? '-' }}</p>
                            </div>
                            {{-- Embedded review form per product --}}
                            <livewire:storefront.review-form
                                :orderId="(string) $order->_id"
                                :productId="$item['product_id']"
                                :productName="$item['snapshot_name'] ?? ''"
                                :orderItemImage="$item['snapshot_image'] ?? ''"
                                :key="'review-' . $order->_id . '-' . $item['product_id']"
                            />
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Right: Summary --}}
            <div class="lg:col-span-1 space-y-4">
                {{-- Payment Summary --}}
                <div class="card-bordered p-5">
                    <h3 class="font-bold text-sm text-koperasi-black mb-3">Rincian Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-koperasi-dark/60">Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-700">
                            <span>Diskon</span>
                            <span>-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-koperasi-dark/60">Ongkos Kirim</span>
                            @if($order->shipping_cost > 0)
                                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            @else
                                <span class="text-green-700">Gratis</span>
                            @endif
                        </div>
                        <hr class="border-koperasi-dark/10">
                        <div class="flex justify-between text-base font-bold text-koperasi-black">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($order->coupon_snapshot)
                    <div class="mt-3 p-2 bg-koperasi-accent/30 rounded-lg">
                        <p class="text-xs font-medium">Kupon: <span class="badge-primary">{{ $order->coupon_snapshot['code'] ?? '-' }}</span></p>
                    </div>
                    @endif

                    @if($order->points_awarded)
                    <div class="mt-3 p-3 bg-koperasi-primary/10 rounded-xl border border-koperasi-primary/20 flex items-center gap-3">
                        <div class="w-8 h-8 bg-koperasi-primary rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-bold">Poin Didapat</p>
                            <p class="text-sm font-bold text-koperasi-black">+{{ number_format($order->points_awarded) }} Poin</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Fulfillment --}}
                <div class="card-bordered p-5">
                    <h3 class="font-bold text-sm text-koperasi-black mb-3">{{ $order->fulfillment_type === 'delivery' ? 'Alamat Pengiriman' : 'Pengambilan' }}</h3>
                    @if($order->fulfillment_type === 'delivery' && $order->shipping_address)
                        <p class="text-sm font-medium">{{ $order->shipping_address['recipient'] ?? '-' }}</p>
                        <p class="text-xs text-koperasi-dark/60">{{ $order->shipping_address['phone'] ?? '-' }}</p>
                        <p class="text-xs text-koperasi-dark/60 mt-1">{{ $order->shipping_address['address'] ?? '-' }}</p>
                        <p class="text-xs text-koperasi-dark/60">{{ $order->shipping_address['city'] ?? '-' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                    @else
                        <p class="text-sm font-medium">Ambil di Toko</p>
                        <p class="text-xs text-koperasi-dark/60">Koperasi Sembako Makmur Jaya</p>
                        <p class="text-xs text-koperasi-dark/60">Jl. Koperasi No. 17, Surabaya</p>
                    @endif
                </div>

                @if($order->notes)
                <div class="card-bordered p-5">
                    <h3 class="font-bold text-sm text-koperasi-black mb-2">Catatan</h3>
                    <p class="text-sm text-koperasi-dark/70">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Cancellation Modal --}}
    @if($showCancelModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-koperasi-dark/50 backdrop-blur-sm" x-data="{}" @keydown.escape.window="$wire.closeCancelModal()">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden border-4 border-koperasi-dark" @click.outside="$wire.closeCancelModal()">
            <div class="px-5 py-4 border-b border-koperasi-dark/10 flex justify-between items-center bg-red-50">
                <h3 class="font-bold text-red-700">Batalkan Pesanan</h3>
                <button wire:click="closeCancelModal" class="text-koperasi-dark/50 hover:text-koperasi-black">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form wire:submit="processCancellation" class="p-5">
                <div class="space-y-4">
                    <p class="text-sm text-koperasi-dark/70">Pesanan yang sudah dibatalkan tidak dapat dikembalikan lagi. Stok akan otomatis dikembalikan ke toko.</p>
                    
                    <div>
                        <label class="input-label">Alasan Pembatalan</label>
                        <select wire:model="cancelReason" class="input mb-2" required>
                            <option value="">-- Pilih Alasan --</option>
                            <option value="Ingin mengubah pesanan (tambah/kurang item)">Ingin mengubah pesanan (tambah/kurang item)</option>
                            <option value="Salah pilih alamat pengiriman">Salah pilih alamat pengiriman</option>
                            <option value="Menemukan harga yang lebih murah">Menemukan harga yang lebih murah</option>
                            <option value="Berubah pikiran">Berubah pikiran</option>
                            <option value="Lainnya">Lainnya...</option>
                        </select>
                        @error('cancelReason') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" wire:click="closeCancelModal" class="btn-outline">Tutup</button>
                    <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700 text-white" wire:loading.attr="disabled">
                        <span wire:loading.remove>Konfirmasi Batal</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
