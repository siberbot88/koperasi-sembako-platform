{{-- Reusable Product Card --}}
<div class="card-bordered group hover:-translate-y-0.5 transition-all duration-200 flex flex-col">
    {{-- Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block" wire:navigate>
        <div class="aspect-square bg-koperasi-dark/5 rounded-t-2xl overflow-hidden relative">
            @if($product->thumbnail)
                @php $imgSrc = Str::startsWith($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail); @endphp
                <img src="{{ $imgSrc }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-koperasi-dark/15" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a2.25 2.25 0 0 0 2.25-2.25V5.25a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                    </svg>
                </div>
            @endif

            {{-- Discount Badge --}}
            @if($product->is_on_sale)
            <div class="absolute top-2 left-2">
                <span class="badge-primary text-[10px]">-{{ $product->discount_percent }}%</span>
            </div>
            @endif

            {{-- Best Seller Tag --}}
            @if(in_array('best-seller', $product->tags ?? []))
            <div class="absolute top-2 right-2">
                <span class="badge-accent text-[10px]">Terlaris</span>
            </div>
            @endif
        </div>
    </a>

    {{-- Info --}}
    <div class="p-3 flex flex-col flex-1">
        <a href="{{ route('products.show', $product->slug) }}" class="block" wire:navigate>
            <p class="text-xs text-koperasi-dark/50 font-medium mb-0.5">{{ $product->category?->name ?? 'Umum' }}</p>
            <h3 class="text-sm font-semibold text-koperasi-dark leading-snug line-clamp-2 group-hover:text-koperasi-black transition-colors">
                {{ $product->name }}
            </h3>
        </a>

        <div class="mt-auto pt-2">
            @if($product->is_on_sale)
                <p class="text-xs text-koperasi-dark/40 line-through">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
            @endif
            <p class="text-base font-bold text-koperasi-black">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</p>
            <p class="text-[10px] text-koperasi-dark/40 mt-0.5">per {{ $product->unit }}</p>
        </div>

        {{-- Stock indicator --}}
        <div class="mt-2">
            @if($product->stock <= 10 && $product->stock > 0)
                <span class="text-[10px] font-medium text-orange-600">Tersisa {{ $product->stock }}</span>
            @elseif($product->stock > 10)
                <span class="text-[10px] font-medium text-green-700">Tersedia</span>
            @else
                <span class="text-[10px] font-medium text-red-600">Habis</span>
            @endif
        </div>
    </div>
</div>
