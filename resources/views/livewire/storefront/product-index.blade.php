<div>
    <div class="container-app py-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-koperasi-black">Semua Produk</h1>
                <p class="text-sm text-koperasi-dark/60 mt-0.5">Temukan kebutuhan pokok harian Anda</p>
            </div>

            {{-- Sort --}}
            <div class="flex items-center gap-2">
                <span class="text-xs text-koperasi-dark/60">Urutkan:</span>
                <select wire:model.live="sortBy" class="input py-1.5 px-3 text-xs w-auto rounded-lg">
                    <option value="terbaru">Terbaru</option>
                    <option value="terlaris">Terlaris</option>
                    <option value="harga-rendah">Harga Terendah</option>
                    <option value="harga-tinggi">Harga Tertinggi</option>
                </select>
            </div>
        </div>

        <div class="flex gap-6">
            {{-- Sidebar Filters (Desktop) --}}
            <aside class="hidden md:block w-52 flex-shrink-0">
                {{-- Search --}}
                <div class="mb-5">
                    <label class="input-label">Cari Produk</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Ketik nama produk..." class="input py-1.5 text-xs">
                </div>

                {{-- Categories --}}
                <div>
                    <label class="input-label mb-2">Kategori</label>
                    <div class="space-y-1">
                        <button wire:click="setCategory('')"
                                class="w-full text-left px-3 py-2 rounded-lg text-xs font-medium transition-colors
                                       {{ $categorySlug === '' ? 'bg-koperasi-primary text-koperasi-black border-2 border-koperasi-black' : 'hover:bg-koperasi-dark/5 text-koperasi-dark/70' }}">
                            Semua Kategori
                        </button>
                        @foreach($categories as $category)
                        <button wire:click="setCategory('{{ $category->slug }}')"
                                class="w-full text-left px-3 py-2 rounded-lg text-xs font-medium transition-colors
                                       {{ $categorySlug === $category->slug ? 'bg-koperasi-primary text-koperasi-black border-2 border-koperasi-black' : 'hover:bg-koperasi-dark/5 text-koperasi-dark/70' }}">
                            {{ $category->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </aside>

            {{-- Mobile Filter Bar --}}
            <div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-koperasi-bg border-t-2 border-koperasi-dark/10 p-3"
                 x-data="{ filterOpen: false }">
                <div class="flex gap-2">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." class="input py-2 text-xs flex-1">
                    <button @click="filterOpen = !filterOpen" class="btn-outline btn-sm flex-shrink-0">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                        Filter
                    </button>
                </div>

                {{-- Mobile Category Drawer --}}
                <div x-show="filterOpen" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-3 flex flex-wrap gap-1.5">
                    <button wire:click="setCategory('')"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors
                                   {{ $categorySlug === '' ? 'bg-koperasi-primary border-koperasi-black text-koperasi-black' : 'border-koperasi-dark/20 text-koperasi-dark/70' }}">
                        Semua
                    </button>
                    @foreach($categories as $category)
                    <button wire:click="setCategory('{{ $category->slug }}')"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors
                                   {{ $categorySlug === $category->slug ? 'bg-koperasi-primary border-koperasi-black text-koperasi-black' : 'border-koperasi-dark/20 text-koperasi-dark/70' }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="flex-1">
                {{-- Active filters --}}
                @if($search || $categorySlug)
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @if($search)
                    <span class="badge-accent">
                        Cari: "{{ $search }}"
                        <button wire:click="$set('search', '')" class="ml-1 font-bold">&times;</button>
                    </span>
                    @endif
                    @if($categorySlug)
                    <span class="badge-primary">
                        {{ $categories->firstWhere('slug', $categorySlug)?->name ?? $categorySlug }}
                        <button wire:click="setCategory('')" class="ml-1 font-bold">&times;</button>
                    </span>
                    @endif
                </div>
                @endif

                @if($products->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                    @foreach($products as $product)
                        @include('livewire.storefront.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8 pb-16 md:pb-0">
                    {{ $products->links() }}
                </div>
                @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <h3>Produk tidak ditemukan</h3>
                    <p>Coba ubah kata kunci atau filter kategori</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
