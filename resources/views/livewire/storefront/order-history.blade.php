<div>
    <div class="container-app py-6">
        <h1 class="text-2xl font-bold text-koperasi-black mb-6">Pesanan Saya</h1>

        @if($orders->count())
        <div class="space-y-3">
            @foreach($orders as $order)
            <a href="{{ route('orders.show', $order->order_number) }}" class="card-bordered p-4 block hover:-translate-y-0.5 transition-all duration-200" wire:navigate>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-mono text-xs font-bold text-koperasi-black">{{ $order->order_number }}</p>
                        <p class="text-[10px] text-koperasi-dark/50 mt-0.5">{{ $order->created_at?->format('d M Y, H:i') }}</p>
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
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'ready' => 'Siap Ambil',
                                'shipped' => 'Dikirim',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="badge {{ $statusColors[$order->status] ?? '' }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                    </div>
                </div>

                {{-- Items preview --}}
                <div class="mt-3 pt-3 border-t border-koperasi-dark/5">
                    <div class="flex flex-wrap gap-3">
                        @foreach(array_slice($order->items ?? [], 0, 3) as $item)
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-koperasi-dark/5 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-koperasi-dark/20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                            <span class="text-xs text-koperasi-dark/60 line-clamp-1">{{ $item['snapshot_name'] ?? '-' }} x{{ $item['qty'] }}</span>
                        </div>
                        @endforeach
                        @if(count($order->items ?? []) > 3)
                        <span class="text-xs text-koperasi-dark/40">+{{ count($order->items) - 3 }} lainnya</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
            </svg>
            <h3>Belum ada pesanan</h3>
            <p>Mulai belanja dan pesanan Anda akan muncul di sini</p>
            <a href="{{ route('products.index') }}" class="btn-primary btn-sm mt-4" wire:navigate>Belanja Sekarang</a>
        </div>
        @endif
    </div>
</div>
