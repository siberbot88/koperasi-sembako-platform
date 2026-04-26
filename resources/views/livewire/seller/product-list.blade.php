<div>
    <x-slot:header>Kelola Produk</x-slot:header>

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-2 flex-1">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." class="input py-1.5 text-xs max-w-xs">
            <select wire:model.live="status" class="input py-1.5 text-xs w-auto">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="draft">Draft</option>
                <option value="archived">Arsip</option>
            </select>
        </div>
        <a href="{{ route('seller.products.create') }}" class="btn-primary btn-sm" wire:navigate>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Table --}}
    @if($products->count())
    <div class="table-wrapper">
        <table class="table-base">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Terjual</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-koperasi-dark/5 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($product->thumbnail)
                                    <img src="{{ Str::startsWith($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-koperasi-dark/20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a2.25 2.25 0 0 0 2.25-2.25V5.25a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-koperasi-dark line-clamp-1">{{ $product->name }}</p>
                                <p class="text-[10px] text-koperasi-dark/50">{{ $product->category?->name ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="font-mono text-xs">{{ $product->sku }}</td>
                    <td>
                        <p class="text-sm font-semibold">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</p>
                        @if($product->is_on_sale)
                            <p class="text-[10px] text-koperasi-dark/40 line-through">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
                        @endif
                    </td>
                    <td>
                        @if($product->stock <= 0)
                            <span class="badge bg-red-100 text-red-800 border-red-300">Habis</span>
                        @elseif($product->stock <= 10)
                            <span class="badge bg-orange-100 text-orange-800 border-orange-300">{{ $product->stock }}</span>
                        @else
                            <span class="text-sm font-medium text-green-700">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td>
                        @if($product->status === 'active')
                            <span class="badge-accent">Aktif</span>
                        @elseif($product->status === 'draft')
                            <span class="badge">Draft</span>
                        @else
                            <span class="badge bg-gray-100 text-gray-600 border-gray-300">Arsip</span>
                        @endif
                    </td>
                    <td class="text-sm">{{ $product->sold_count }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('seller.products.edit', $product->_id) }}" class="p-1.5 rounded-lg hover:bg-koperasi-dark/5 transition-colors" title="Edit" wire:navigate>
                                <svg class="w-4 h-4 text-koperasi-dark/60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <button 
                                @click="$dispatch('confirm', {
                                    title: 'Hapus Produk?',
                                    message: 'Produk yang dihapus tidak dapat dikembalikan.',
                                    confirmText: 'Ya, Hapus',
                                    cancelText: 'Batal',
                                    type: 'danger',
                                    onConfirm: '$wire.deleteProduct(\'{{ $product->_id }}\')'
                                })"
                                class="p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Hapus">
                                <svg class="w-4 h-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
        <h3>Belum ada produk</h3>
        <p>Mulai tambahkan produk pertama Anda</p>
        <a href="{{ route('seller.products.create') }}" class="btn-primary btn-sm mt-4" wire:navigate>Tambah Produk</a>
    </div>
    @endif
</div>
