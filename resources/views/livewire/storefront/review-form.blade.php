<div>
    @if($alreadyDone || $submitted)
    {{-- Already Reviewed State --}}
    <div class="flex items-center gap-3 p-4 bg-koperasi-accent/20 rounded-xl border border-koperasi-dark/10">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
        </svg>
        <p class="text-sm font-medium text-koperasi-dark">Anda sudah memberikan ulasan untuk produk ini.</p>
    </div>

    @else
    {{-- Review Form --}}
    <form wire:submit="submitReview" class="space-y-4">

        {{-- Star Rating Picker --}}
        <div>
            <p class="text-xs font-semibold text-koperasi-dark/60 uppercase tracking-wider mb-2">Rating Anda</p>
            <div class="flex items-center gap-1.5" x-data="{ hovered: 0 }">
                @for($i = 1; $i <= 5; $i++)
                <button
                    type="button"
                    wire:click="setRating({{ $i }})"
                    @mouseenter="hovered = {{ $i }}"
                    @mouseleave="hovered = 0"
                    class="transition-transform hover:scale-110 focus:outline-none"
                    title="{{ $i }} Bintang">
                    <svg class="w-8 h-8 transition-colors"
                         :class="hovered >= {{ $i }} || {{ $rating }} >= {{ $i }} ? 'text-koperasi-primary' : 'text-koperasi-dark/15'"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                    </svg>
                </button>
                @endfor
                @if($rating > 0)
                <span class="text-sm font-bold text-koperasi-dark ml-2">
                    {{ ['', 'Sangat Buruk', 'Kurang Puas', 'Cukup', 'Puas', 'Sangat Puas'][$rating] }}
                </span>
                @endif
            </div>
            @error('rating') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Comment --}}
        <div>
            <label class="input-label">Tulis Ulasan Anda</label>
            <textarea
                wire:model="comment"
                rows="3"
                maxlength="500"
                placeholder="Ceritakan pengalaman belanja Anda: kualitas produk, kecepatan pengiriman, dll..."
                class="input resize-none"></textarea>
            <div class="flex justify-between mt-1">
                @error('comment') <p class="text-xs text-red-500">{{ $message }}</p> @else <span></span> @enderror
                <p class="text-[10px] text-koperasi-dark/40">{{ strlen($comment) }}/500</p>
            </div>
        </div>

        {{-- Optional Photo Upload --}}
        <div>
            <label class="input-label">Foto Produk (Opsional)</label>
            <input type="file" wire:model="reviewImage" accept="image/*" class="input py-1.5 text-sm">
            @error('reviewImage') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            @if($reviewImage)
                <div class="mt-2">
                    <img src="{{ $reviewImage->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-xl border-2 border-koperasi-dark/10">
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="btn-primary"
                    wire:loading.attr="disabled"
                    :disabled="{{ $rating }} === 0">
                <span wire:loading.remove>Kirim Ulasan</span>
                <span wire:loading>Mengirim...</span>
            </button>
        </div>

    </form>
    @endif
</div>
