<div>
    <x-slot:header>Ulasan Pelanggan</x-slot:header>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="card-bordered p-4 text-center">
            <p class="text-2xl font-extrabold text-koperasi-black">{{ $avgRating > 0 ? number_format($avgRating, 1) : '-' }}</p>
            <div class="flex justify-center gap-0.5 my-1">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-3.5 h-3.5 {{ $i <= round($avgRating) ? 'text-koperasi-primary' : 'text-koperasi-dark/15' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>
                @endfor
            </div>
            <p class="text-[10px] text-koperasi-dark/50">Rata-rata Rating</p>
        </div>
        <div class="card-bordered p-4 text-center">
            <p class="text-2xl font-extrabold text-koperasi-black">{{ $totalReviews }}</p>
            <p class="text-[10px] text-koperasi-dark/50 mt-1">Total Ulasan</p>
        </div>
        <div class="card-bordered p-4 text-center">
            <p class="text-2xl font-extrabold {{ $unreplied > 0 ? 'text-orange-500' : 'text-green-600' }}">{{ $unreplied }}</p>
            <p class="text-[10px] text-koperasi-dark/50 mt-1">Belum Dibalas</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xs font-medium text-koperasi-dark/60">Filter:</span>
        @foreach([''=>'Semua', '5'=>'5 ★', '4'=>'4 ★', '3'=>'3 ★', '2'=>'2 ★', '1'=>'1 ★'] as $value => $label)
        <button wire:click="$set('filterRating', '{{ $value }}')"
                class="px-3 py-1 rounded-lg text-xs font-medium border transition-colors
                       {{ $filterRating === $value ? 'bg-koperasi-primary border-koperasi-black' : 'border-koperasi-dark/15 text-koperasi-dark/60 hover:bg-koperasi-dark/5' }}">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- Reviews List --}}
    @if($reviews->count())
    <div class="space-y-3">
        @foreach($reviews as $review)
        <div class="card-bordered p-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    {{-- Product Name --}}
                    <p class="text-[10px] font-bold text-koperasi-dark/50 uppercase tracking-wider mb-1">{{ $review->product?->name ?? '-' }}</p>

                    {{-- Reviewer Info --}}
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-koperasi-accent rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($review->user?->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold">{{ $review->user?->name ?? 'Anonim' }}</p>
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-koperasi-primary' : 'text-koperasi-dark/15' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    @if($review->is_verified_buyer)
                    <span class="text-[10px] font-semibold text-green-700 bg-green-50 border border-green-200 rounded-md px-1.5 py-0.5">Pembelian Terverifikasi</span>
                    @endif
                    <p class="text-[10px] text-koperasi-dark/40 mt-1">{{ $review->created_at?->format('d M Y') }}</p>
                </div>
            </div>

            <p class="text-sm text-koperasi-dark/80 mt-3 leading-relaxed">{{ $review->comment }}</p>

            {{-- Review Images --}}
            @if(!empty($review->images))
            <div class="flex gap-2 mt-2 flex-wrap">
                @foreach($review->images as $img)
                <img src="{{ asset('storage/' . $img) }}" class="w-14 h-14 object-cover rounded-lg border border-koperasi-dark/10">
                @endforeach
            </div>
            @endif

            {{-- Existing Reply --}}
            @if($review->seller_reply)
            <div class="mt-3 pl-3 border-l-2 border-koperasi-primary bg-koperasi-bg/50 rounded-r-lg p-2.5">
                <p class="text-[10px] font-bold text-koperasi-dark/60 uppercase tracking-wider mb-0.5">Balasan Anda</p>
                <p class="text-sm text-koperasi-dark/80">{{ $review->seller_reply }}</p>
            </div>
            @else
            {{-- Reply Button --}}
            <div class="mt-3 flex">
                <button wire:click="openReplyModal('{{ $review->_id }}')" class="btn-outline btn-sm text-xs">
                    Balas Ulasan Ini
                </button>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>

    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
        </svg>
        <h3>Belum ada ulasan</h3>
        <p>Ulasan pelanggan akan muncul di sini setelah pesanan selesai</p>
    </div>
    @endif

    {{-- Reply Modal --}}
    @if($showReplyModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-koperasi-dark/50 backdrop-blur-sm" x-data="{}" @keydown.escape.window="$wire.closeReplyModal()">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden border-4 border-koperasi-dark" @click.outside="$wire.closeReplyModal()">
            <div class="px-5 py-4 border-b border-koperasi-dark/10 flex justify-between items-center bg-koperasi-bg">
                <h3 class="font-bold text-koperasi-black">Balas Ulasan</h3>
                <button wire:click="closeReplyModal" class="text-koperasi-dark/50 hover:text-koperasi-black">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form wire:submit="submitReply" class="p-5">
                <div>
                    <label class="input-label">Balasan Anda</label>
                    <textarea wire:model="replyText" rows="4" maxlength="500"
                        placeholder="Tulis balasan yang ramah dan informatif..."
                        class="input resize-none"></textarea>
                    @error('replyText') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" wire:click="closeReplyModal" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>Kirim Balasan</span>
                        <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
