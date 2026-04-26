<div>
    <div class="container-app py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Product Image --}}
            <div>
                <div class="aspect-square bg-koperasi-dark/5 rounded-2xl border-2 border-koperasi-black/10 overflow-hidden">
                    @if($product->thumbnail)
                        <img src="{{ Str::startsWith($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-koperasi-dark/15" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a2.25 2.25 0 0 0 2.25-2.25V5.25a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div>
                {{-- Breadcrumb --}}
                <div class="flex items-center gap-1.5 text-xs text-koperasi-dark/50 mb-3">
                    <a href="{{ route('home') }}" class="hover:text-koperasi-dark transition-colors" wire:navigate>Beranda</a>
                    <span>/</span>
                    <a href="{{ route('products.index') }}" class="hover:text-koperasi-dark transition-colors" wire:navigate>Produk</a>
                    @if($product->category)
                    <span>/</span>
                    <a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}" class="hover:text-koperasi-dark transition-colors" wire:navigate>{{ $product->category->name }}</a>
                    @endif
                </div>

                {{-- Badges --}}
                <div class="flex flex-wrap gap-1.5 mb-2">
                    @if($product->is_on_sale)
                        <span class="badge-primary">Diskon {{ $product->discount_percent }}%</span>
                    @endif
                    @if(in_array('best-seller', $product->tags ?? []))
                        <span class="badge-accent">Terlaris</span>
                    @endif
                    <span class="badge">SKU: {{ $product->sku }}</span>
                </div>

                {{-- Name --}}
                <h1 class="text-2xl md:text-3xl font-extrabold text-koperasi-black leading-tight">{{ $product->name }}</h1>

                {{-- Rating Mini Display --}}
                @if($reviewSummary['total'] > 0)
                <div class="flex items-center gap-2 mt-1.5">
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($reviewSummary['average']) ? 'text-koperasi-primary' : 'text-koperasi-dark/15' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-koperasi-dark">{{ number_format($reviewSummary['average'], 1) }}</span>
                    <span class="text-sm text-koperasi-dark/50">({{ $reviewSummary['total'] }} ulasan)</span>
                </div>
                @endif

                {{-- Price --}}
                <div class="mt-4 p-4 bg-koperasi-accent/20 rounded-2xl border border-koperasi-dark/10">
                    @if($product->is_on_sale)
                        <p class="text-sm text-koperasi-dark/50 line-through">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
                    @endif
                    <p class="text-3xl font-extrabold text-koperasi-black">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-koperasi-dark/50 mt-0.5">per {{ $product->unit }} | Berat: {{ number_format($product->weight_grams / 1000, 1) }}kg</p>
                </div>

                {{-- Stock --}}
                <div class="mt-4 flex items-center gap-2">
                    @if($product->stock > 10)
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-sm text-green-700 font-medium">Stok tersedia ({{ $product->stock }})</span>
                    @elseif($product->stock > 0)
                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                        <span class="text-sm text-orange-600 font-medium">Tersisa {{ $product->stock }} {{ $product->unit }}</span>
                    @else
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        <span class="text-sm text-red-600 font-medium">Stok habis</span>
                    @endif
                </div>

                {{-- Description --}}
                @if($product->description)
                <div class="mt-4">
                    <p class="text-sm text-koperasi-dark/70 leading-relaxed">{{ $product->description }}</p>
                </div>
                @endif

                {{-- Qty & Add to Cart --}}
                @if($product->stock > 0)
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    {{-- Qty --}}
                    <div class="flex items-center border-2 border-koperasi-black rounded-xl overflow-hidden">
                        <button wire:click="decrementQty"
                                class="px-3 py-2 text-lg font-bold hover:bg-koperasi-dark/5 transition-colors"
                                @if($qty <= ($product->min_order ?? 1)) disabled @endif>
                            -
                        </button>
                        <span class="px-4 py-2 text-sm font-bold min-w-[3rem] text-center border-x-2 border-koperasi-black">{{ $qty }}</span>
                        <button wire:click="incrementQty"
                                class="px-3 py-2 text-lg font-bold hover:bg-koperasi-dark/5 transition-colors"
                                @if($qty >= min($product->stock, $product->max_order ?? 50)) disabled @endif>
                            +
                        </button>
                    </div>

                    {{-- Add to Cart --}}
                    <button wire:click="addToCart" class="btn-primary btn-lg flex-1 md:flex-none hover:translate-y-[-2px] transition-transform">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        Tambah ke Keranjang
                    </button>

                    {{-- Add to Wishlist --}}
                    <button wire:click="toggleWishlist" class="btn-secondary btn-lg border-2 border-koperasi-dark hover:bg-red-50 text-koperasi-dark hover:text-red-500 transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center justify-center p-3 w-14 group {{ $inWishlist ? 'bg-red-50 text-red-500' : 'bg-white' }}">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform {{ $inWishlist ? 'fill-current text-red-500' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </button>
                </div>

                {{-- Subtotal hint --}}
                <p class="text-xs text-koperasi-dark/50 mt-2">Subtotal: <span class="font-bold text-koperasi-black">Rp {{ number_format($product->effective_price * $qty, 0, ',', '.') }}</span></p>
                @endif
            </div>
        </div>

        {{-- Reviews --}}
        <section class="mt-12">
            <h2 class="text-xl font-bold text-koperasi-black mb-6">Ulasan Pelanggan</h2>

            {{-- Rating Summary --}}
            @if($reviewSummary['total'] > 0)
            <div class="card-bordered p-5 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    {{-- Average Score --}}
                    <div class="text-center flex-shrink-0">
                        <p class="text-5xl font-extrabold text-koperasi-black">{{ number_format($reviewSummary['average'], 1) }}</p>
                        <div class="flex items-center justify-center gap-0.5 mt-1 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($reviewSummary['average']) ? 'text-koperasi-primary' : 'text-koperasi-dark/15' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                            </svg>
                            @endfor
                        </div>
                        <p class="text-xs text-koperasi-dark/50">{{ $reviewSummary['total'] }} ulasan</p>
                    </div>

                    {{-- Distribution Bars --}}
                    <div class="flex-1 w-full space-y-1.5">
                        @foreach([5,4,3,2,1] as $star)
                        @php
                            $count = $reviewSummary['distribution'][$star] ?? 0;
                            $pct = $reviewSummary['total'] > 0 ? round($count / $reviewSummary['total'] * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-koperasi-dark/60 w-3 flex-shrink-0">{{ $star }}</span>
                            <svg class="w-3 h-3 text-koperasi-primary flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1 bg-koperasi-dark/10 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full bg-koperasi-primary transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-xs text-koperasi-dark/50 w-6 text-right flex-shrink-0">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Review Cards --}}
            @if($reviews->count())
                <div class="space-y-4">
                    @foreach($reviews as $review)
                    <div class="card-bordered p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 bg-koperasi-accent rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($review->user?->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-koperasi-dark">{{ $review->user?->name ?? 'Anonim' }}</p>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-koperasi-primary' : 'text-koperasi-dark/15' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                        </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                @if($review->is_verified_buyer)
                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-green-700 bg-green-50 border border-green-200 rounded-md px-1.5 py-0.5">
                                    <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.491 4.491 0 0 1-3.497-1.307 4.491 4.491 0 0 1-1.307-3.497A4.49 4.49 0 0 1 2.25 12a4.49 4.49 0 0 1 1.549-3.397 4.491 4.491 0 0 1 1.307-3.497 4.491 4.491 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    Pembelian Terverifikasi
                                </span>
                                @endif
                                <p class="text-[10px] text-koperasi-dark/40 mt-1">{{ $review->created_at?->format('d M Y') }}</p>
                            </div>
                        </div>

                        <p class="text-sm text-koperasi-dark/80 mt-3 leading-relaxed">{{ $review->comment }}</p>

                        {{-- Review Images --}}
                        @if(!empty($review->images))
                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach($review->images as $imgPath)
                            <img src="{{ asset('storage/' . $imgPath) }}" class="w-16 h-16 object-cover rounded-lg border-2 border-koperasi-dark/10 cursor-pointer">
                            @endforeach
                        </div>
                        @endif

                        {{-- Seller Reply --}}
                        @if($review->seller_reply)
                        <div class="mt-3 pl-3 border-l-2 border-koperasi-primary bg-koperasi-bg/50 rounded-r-lg p-3">
                            <p class="text-[10px] font-bold text-koperasi-dark/60 uppercase tracking-wider mb-1">Balasan Penjual</p>
                            <p class="text-sm text-koperasi-dark/80">{{ $review->seller_reply }}</p>
                            @if($review->seller_replied_at)
                            <p class="text-[10px] text-koperasi-dark/40 mt-1">{{ $review->seller_replied_at->format('d M Y') }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="card p-8 text-center">
                    <svg class="w-10 h-10 text-koperasi-dark/20 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                    <p class="text-sm font-medium text-koperasi-dark/50">Belum ada ulasan untuk produk ini.</p>
                    <p class="text-xs text-koperasi-dark/35 mt-1">Jadilah yang pertama memberi ulasan setelah menerima pesanan.</p>
                </div>
            @endif
        </section>

        {{-- Related Products --}}
        @if($relatedProducts->count())
        <section class="mt-12">
            <h2 class="text-xl font-bold text-koperasi-black mb-4">Produk Serupa</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-4">
                @foreach($relatedProducts as $relProduct)
                    @include('livewire.storefront.partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
