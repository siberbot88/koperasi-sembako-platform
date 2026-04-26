<div>
    <div class="container-app py-6">
        <h1 class="text-2xl font-bold text-koperasi-black mb-6">Wishlist</h1>

        @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-4">
            @foreach($products as $product)
            <div class="flex flex-col gap-3">
                @include('livewire.storefront.partials.product-card', ['product' => $product])

                {{-- Remove from Wishlist --}}
                <button wire:click="toggleWishlist('{{ $product->_id }}')"
                        class="btn-secondary w-full border-2 border-koperasi-black bg-white hover:bg-red-50 text-red-500 font-bold transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    <svg class="w-4 h-4 mr-1.5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Hapus
                </button>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
            <h3>Wishlist Kosong</h3>
            <p>Simpan produk favorit Anda di sini</p>
            <a href="{{ route('products.index') }}" class="btn-primary btn-sm mt-4" wire:navigate>Jelajahi Produk</a>
        </div>
        @endif
    </div>
</div>
