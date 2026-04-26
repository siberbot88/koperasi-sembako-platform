<div>
    {{-- ======== HERO BANNER ======== --}}
    <section class="bg-koperasi-primary/20 border-b-2 border-koperasi-black/10">
        <div class="container-app py-10 md:py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="badge-accent mb-3 inline-block">Koperasi Sembako Online</span>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-koperasi-black leading-tight mb-4">
                        Belanja Hemat,<br>
                        <span class="bg-koperasi-primary px-2 py-0.5 rounded-xl border-2 border-koperasi-black inline-block mt-1">Harga Koperasi</span>
                    </h1>
                    <p class="text-koperasi-dark/70 leading-relaxed mb-6 max-w-md">
                        Kebutuhan pokok harian dengan harga jujur dan stok terjamin. Beras, minyak, gula, telur, semua tersedia untuk anggota dan umum.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('products.index') }}" class="btn-primary btn-lg" wire:navigate>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Mulai Belanja
                        </a>
                        <a href="#kategori" class="btn-outline btn-lg">Lihat Kategori</a>
                    </div>
                </div>
                <div class="hidden md:flex justify-center">
                    <div class="w-full max-w-sm aspect-square bg-koperasi-accent/40 rounded-3xl border-2 border-koperasi-black/10 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('img/hero.png') }}" class="w-full h-full object-cover mix-blend-multiply" alt="Koperasi Sembako">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== PROMO BANNERS ======== --}}
    @if($banners->count())
    <section class="container-app mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($banners as $banner)
            <div class="card-bordered p-5 bg-gradient-to-br from-koperasi-accent/30 to-koperasi-primary/20">
                <h3 class="text-lg font-bold text-koperasi-black">{{ $banner->title }}</h3>
                <p class="text-sm text-koperasi-dark/70 mt-1">{{ $banner->subtitle }}</p>
                <a href="{{ route('products.index') }}" class="btn-primary btn-sm mt-3 inline-flex" wire:navigate>Lihat Promo</a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ======== KATEGORI ======== --}}
    <section id="kategori" class="container-app mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-koperasi-black">Kategori Produk</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-koperasi-dark/60 hover:text-koperasi-black transition-colors" wire:navigate>Lihat semua &rarr;</a>
        </div>
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-9 gap-3">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['kategori' => $category->slug]) }}"
               class="card-bordered flex flex-col items-center justify-center p-3 text-center group hover:-translate-y-0.5 transition-all duration-200"
               wire:navigate
              >
                <div class="w-10 h-10 bg-koperasi-accent/40 rounded-xl flex items-center justify-center mb-2 group-hover:bg-koperasi-primary/60 transition-colors">
                    <svg class="w-5 h-5 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-koperasi-dark leading-tight">{{ $category->name }}</span>
            </a>
            @endforeach
        </div>
    </section>

    {{-- ======== BEST SELLERS ======== --}}
    <section class="container-app mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-koperasi-black">Terlaris</h2>
            <a href="{{ route('products.index', ['urut' => 'terlaris']) }}" class="text-sm font-medium text-koperasi-dark/60 hover:text-koperasi-black transition-colors" wire:navigate>Lihat semua &rarr;</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-4">
            @foreach($bestSellers as $product)
                @include('livewire.storefront.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    {{-- ======== LATEST PRODUCTS ======== --}}
    <section class="container-app mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-koperasi-black">Produk Terbaru</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-koperasi-dark/60 hover:text-koperasi-black transition-colors" wire:navigate>Lihat semua &rarr;</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-4">
            @foreach($latestProducts as $product)
                @include('livewire.storefront.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    {{-- ======== USP SECTION ======== --}}
    <section class="container-app mt-16 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="card-bordered p-5 text-center">
                <div class="w-10 h-10 mx-auto bg-koperasi-primary/40 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm text-koperasi-black">Harga Jujur</h4>
                <p class="text-xs text-koperasi-dark/60 mt-1">Harga koperasi tanpa markup berlebihan</p>
            </div>
            <div class="card-bordered p-5 text-center">
                <div class="w-10 h-10 mx-auto bg-koperasi-accent/40 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.139-.487 1.166-1.108l.397-7.5A1.125 1.125 0 0 0 19.875 9H4.5M8.25 18.75H17.25M12 2.25l5.25 3.75H6.75L12 2.25Z" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm text-koperasi-black">Stok Terjamin</h4>
                <p class="text-xs text-koperasi-dark/60 mt-1">Ketersediaan barang rutin diperbarui</p>
            </div>
            <div class="card-bordered p-5 text-center">
                <div class="w-10 h-10 mx-auto bg-koperasi-primary/40 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm text-koperasi-black">Layanan Ramah</h4>
                <p class="text-xs text-koperasi-dark/60 mt-1">Pelayanan amanah untuk semua anggota</p>
            </div>
        </div>
    </section>
</div>
