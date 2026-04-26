<div>
    <x-slot:header>Kelola Pesanan</x-slot:header>

    {{-- Status Tabs --}}
    <div class="flex flex-wrap items-center gap-1.5 mb-4 border-b border-koperasi-dark/10 pb-3">
        @php
            $tabs = ['' => 'Semua', 'pending' => 'Pending', 'processing' => 'Diproses', 'ready' => 'Siap', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Batal'];
        @endphp
        @foreach($tabs as $value => $label)
        <button wire:click="$set('filterStatus', '{{ $value }}')"
                class="px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors
                       {{ $filterStatus === $value ? 'bg-koperasi-primary border-koperasi-black text-koperasi-black' : 'border-koperasi-dark/15 text-koperasi-dark/60 hover:bg-koperasi-dark/5' }}">
            {{ $label }}
        </button>
        @endforeach
    </div>

    @if($orders->count())
    <div class="space-y-3">
        @foreach($orders as $order)
        <div class="card-bordered p-4" x-data="{ expanded: false }">
            {{-- Order Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3 cursor-pointer" @click="expanded = !expanded">
                <div class="flex items-center gap-3">
                    <div>
                        <p class="font-mono text-xs font-bold text-koperasi-black">{{ $order->order_number }}</p>
                        <p class="text-[10px] text-koperasi-dark/50">{{ $order->created_at?->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <p class="text-sm font-bold text-koperasi-black">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'ready' => 'bg-green-100 text-green-800 border-green-300',
                            'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                            'completed' => 'bg-koperasi-accent text-koperasi-dark border-koperasi-dark/20',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-300',
                        ];
                    @endphp
                    <span class="badge {{ $statusColors[$order->status] ?? '' }}">{{ ucfirst($order->status) }}</span>
                    <svg class="w-4 h-4 text-koperasi-dark/40 transition-transform" :class="expanded && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            {{-- Expanded Detail --}}
            <div x-show="expanded" x-cloak x-collapse class="mt-4 pt-4 border-t border-koperasi-dark/10">
                {{-- Customer --}}
                <div class="mb-3">
                    <p class="text-xs text-koperasi-dark/50 mb-1">Pelanggan</p>
                    <p class="text-sm font-medium">{{ $order->user?->name ?? '-' }}</p>
                </div>

                {{-- Items --}}
                <div class="mb-3">
                    <p class="text-xs text-koperasi-dark/50 mb-1">Item Pesanan</p>
                    <div class="space-y-1.5">
                        @foreach($order->items ?? [] as $item)
                        <div class="flex items-center justify-between text-sm">
                            <span>{{ $item['snapshot_name'] ?? '-' }} x{{ $item['qty'] }}</span>
                            <span class="font-medium">Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Fulfillment --}}
                <div class="mb-4">
                    <p class="text-xs text-koperasi-dark/50 mb-1">Pengambilan</p>
                    <p class="text-sm font-medium">{{ ucfirst($order->fulfillment_type ?? 'pickup') }}</p>
                </div>

                @if($order->notes)
                <div class="mb-4">
                    <p class="text-xs text-koperasi-dark/50 mb-1">Catatan</p>
                    <p class="text-sm">{{ $order->notes }}</p>
                </div>
                @endif

                {{-- Shipment Info (If Available) --}}
                @if($order->shipment)
                <div class="mb-4 bg-koperasi-bg/50 p-3 rounded-xl border border-koperasi-dark/10">
                    <p class="text-xs text-koperasi-dark/50 mb-2 font-bold uppercase tracking-wider">Info Pengiriman</p>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <p class="text-koperasi-dark/50 text-[10px]">Kurir</p>
                            <p class="font-medium">{{ $order->shipment['courier'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-koperasi-dark/50 text-[10px]">No. Resi</p>
                            <p class="font-medium font-mono text-koperasi-primary">{{ $order->shipment['tracking_number'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                <div class="flex flex-wrap gap-2">
                    @if($order->status === 'pending')
                        <button wire:click="updateOrderStatus('{{ $order->_id }}', 'processing')" class="btn-primary btn-sm">Proses Pesanan</button>
                        <button wire:click="updateOrderStatus('{{ $order->_id }}', 'cancelled')"
                                wire:confirm="Yakin ingin membatalkan pesanan ini?"
                                class="btn-outline btn-sm text-red-600 border-red-400 hover:bg-red-50 hover:text-red-700">Batalkan</button>
                    @elseif($order->status === 'processing')
                        @if($order->fulfillment_type === 'delivery')
                            <button wire:click="openShipmentModal('{{ $order->_id }}')" class="btn-secondary btn-sm">Tandai Dikirim (Input Resi)</button>
                        @else
                            <button wire:click="updateOrderStatus('{{ $order->_id }}', 'ready')" class="btn-primary btn-sm">Tandai Siap Ambil</button>
                            <button wire:click="updateOrderStatus('{{ $order->_id }}', 'shipped')" class="btn-secondary btn-sm">Tandai Dikirim</button>
                        @endif
                    @elseif($order->status === 'ready' || $order->status === 'shipped')
                        <button wire:click="updateOrderStatus('{{ $order->_id }}', 'completed')" class="btn-primary btn-sm">Tandai Selesai</button>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
        </svg>
        <h3>Belum ada pesanan</h3>
        <p>Pesanan baru akan muncul di sini</p>
    </div>
    @endif

    {{-- Shipment Modal --}}
    @if($showShipmentModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-koperasi-dark/50 backdrop-blur-sm"
         x-data="{}"
         @keydown.escape.window="$wire.closeShipmentModal()">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden border-4 border-koperasi-dark"
             @click.outside="$wire.closeShipmentModal()">

            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-koperasi-dark/10 flex justify-between items-center bg-koperasi-bg">
                <div>
                    <h3 class="font-bold text-koperasi-black">Kirim Pesanan</h3>
                    <p class="text-[11px] text-koperasi-dark/50 mt-0.5">Pilih kurir, nomor resi otomatis digenerate</p>
                </div>
                <button wire:click="closeShipmentModal" class="text-koperasi-dark/50 hover:text-koperasi-black">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit="processShipment" class="p-5 space-y-5">

                {{-- Courier Selector Grid --}}
                <div>
                    <label class="input-label mb-1.5">Pilih Kurir</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(\App\Models\Order::COURIERS as $name => $config)
                        <button
                            type="button"
                            wire:click="$set('courier', '{{ $name }}')"
                            class="flex flex-col items-center gap-1 p-2.5 rounded-xl border-2 text-center transition-all duration-150
                                   {{ $courier === $name
                                       ? 'border-koperasi-dark bg-koperasi-primary shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]'
                                       : 'border-koperasi-dark/15 hover:border-koperasi-dark/40 hover:bg-koperasi-bg' }}">
                            <div class="h-6 flex items-center justify-center">
                                <img src="{{ $config['logo'] }}" alt="{{ $name }}" class="max-h-full max-w-[40px] object-contain {{ $courier === $name ? '' : 'grayscale opacity-50' }}">
                            </div>
                            <span class="text-[10px] font-bold leading-tight text-koperasi-dark">{{ $name }}</span>
                        </button>
                        @endforeach
                    </div>
                    @error('courier') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Auto-Generated Tracking Number --}}
                @if($courier)
                <div
                    x-data="{}"
                    x-init="$el.style.opacity='0'; $el.style.transform='translateY(8px)'; requestAnimationFrame(function() { $el.style.transition='all 0.2s ease'; $el.style.opacity='1'; $el.style.transform='translateY(0)'; })">
                    <label class="input-label mb-1.5">Nomor Resi (Auto-Generated)</label>
                    <div class="flex items-center gap-2">
                        {{-- Resi display --}}
                        <div class="flex-1 bg-koperasi-dark rounded-xl px-4 py-3 flex items-center justify-between group">
                            <span class="font-mono font-bold text-koperasi-primary tracking-wider text-sm">{{ $trackingNumber }}</span>
                            <span class="text-[10px] text-koperasi-bg/50 ml-2 flex-shrink-0">{{ $courier }}</span>
                        </div>
                        {{-- Regenerate button --}}
                        <button
                            type="button"
                            wire:click="updatedCourier"
                            title="Generate ulang nomor resi"
                            class="w-11 h-11 flex-shrink-0 bg-koperasi-bg border-2 border-koperasi-dark/20 hover:border-koperasi-dark rounded-xl flex items-center justify-center transition-colors group">
                            <svg class="w-4 h-4 text-koperasi-dark/60 group-hover:text-koperasi-dark group-hover:rotate-180 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>
                    </div>
                    {{-- Optional: allow manual edit --}}
                    <div class="mt-2">
                        <label class="text-[10px] text-koperasi-dark/50 mb-1 block">Atau edit manual (opsional)</label>
                        <input type="text" wire:model="trackingNumber"
                               class="input text-sm font-mono"
                               placeholder="Edit jika resi berbeda...">
                    </div>
                    @error('trackingNumber') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ── Shipping Cost ── --}}
                <div
                    x-data="{}"
                    x-init="$el.style.opacity='0'; $el.style.transform='translateY(8px)'; requestAnimationFrame(function() { $el.style.transition='all 0.2s ease'; $el.style.opacity='1'; $el.style.transform='translateY(0)'; })">
                    <label class="input-label mb-1.5">Biaya Ongkir</label>
                    <div class="flex items-center gap-2">
                        <span class="flex-shrink-0 text-sm font-bold text-koperasi-dark/60 pl-1">Rp</span>
                        <input
                            type="number"
                            wire:model.live="shippingCost"
                            class="input flex-1 font-mono text-sm"
                            min="0"
                            max="500000"
                            step="500"
                            placeholder="0">
                    </div>
                    @php
                        $baseRate = \App\Models\Order::COURIERS[$courier]['base_rate'] ?? 0;
                    @endphp
                    <div class="mt-1.5 flex items-center justify-between text-[11px]">
                        <span class="text-koperasi-dark/50">
                            Tarif dasar {{ $courier }}: <strong>Rp {{ number_format($baseRate, 0, ',', '.') }}</strong>
                            · Sesuaikan berdasarkan jarak
                        </span>
                        @if($shippingCost !== $baseRate && $baseRate > 0)
                        <button type="button" wire:click="$set('shippingCost', {{ $baseRate }})"
                                class="text-koperasi-primary underline hover:no-underline flex-shrink-0 ml-2">Reset</button>
                        @endif
                    </div>
                    @error('shippingCost') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

                    {{-- Live total preview --}}
                    @php
                        $order = \App\Models\Order::find($selectedOrderIdForShipment);
                        $subtotal = $order?->subtotal ?? 0;
                        $discount = $order?->discount_amount ?? 0;
                        $newTotal = $subtotal - $discount + $shippingCost;
                    @endphp
                    @if($order)
                    <div class="mt-3 bg-koperasi-bg rounded-xl p-3 border border-koperasi-dark/10 text-xs space-y-1.5">
                        <p class="font-bold text-[10px] text-koperasi-dark/50 uppercase tracking-wider mb-2">Preview Total Baru</p>
                        <div class="flex justify-between text-koperasi-dark/70">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="flex justify-between text-green-700">
                            <span>Diskon</span>
                            <span>−Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-koperasi-dark/70">
                            <span>Ongkir ({{ $courier }})</span>
                            <span class="{{ $shippingCost > 0 ? 'text-koperasi-dark font-semibold' : '' }}">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-koperasi-black border-t border-koperasi-dark/10 pt-1.5">
                            <span>Total Baru</span>
                            <span>Rp {{ number_format($newTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div class="bg-koperasi-bg/50 border border-dashed border-koperasi-dark/20 rounded-xl p-4 text-center">
                    <p class="text-xs text-koperasi-dark/50">Pilih kurir di atas untuk generate nomor resi otomatis</p>
                </div>
                @endif

                {{-- Actions --}}
                <div class="flex justify-end gap-2 pt-1">
                    <button type="button" wire:click="closeShipmentModal" class="btn-outline">Batal</button>
                    <button type="submit"
                            class="btn-primary"
                            wire:loading.attr="disabled"
                            {{ !$courier || !$trackingNumber ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="processShipment">
                            <svg class="w-4 h-4 inline mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3.478 2.405a.75.75 0 0 0-.926.94l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.405Z" />
                            </svg>
                            Kirim Sekarang
                        </span>
                        <span wire:loading wire:target="processShipment">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
