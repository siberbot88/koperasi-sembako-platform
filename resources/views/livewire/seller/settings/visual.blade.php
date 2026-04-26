<div class="space-y-6">
    {{-- Logo & Banner --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Profil Visual Toko</h2>
                <p class="text-sm text-koperasi-dark/60">Logo dan banner untuk identitas visual toko</p>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Logo --}}
            <div>
                <label class="label">Logo Toko</label>
                <p class="text-xs text-koperasi-dark/40 mb-3">Ukuran maksimal 1MB. Format: JPG, PNG</p>
                
                <div class="flex items-start gap-4">
                    {{-- Preview --}}
                    @if($logo)
                        <div class="w-24 h-24 rounded-xl border-3 border-koperasi-dark shadow-brutal overflow-hidden bg-white">
                            <img src="{{ $logo->temporaryUrl() }}" alt="Preview Logo" class="w-full h-full object-cover">
                        </div>
                    @elseif($existingLogo)
                        <div class="w-24 h-24 rounded-xl border-3 border-koperasi-dark shadow-brutal overflow-hidden bg-white">
                            <img src="{{ Storage::url($existingLogo) }}" alt="Logo Toko" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-xl border-3 border-koperasi-dark shadow-brutal bg-koperasi-dark/5 flex items-center justify-center">
                            <svg class="w-10 h-10 text-koperasi-dark/30" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Upload Button --}}
                    <div class="flex-1">
                        <label class="btn-secondary cursor-pointer inline-flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                            </svg>
                            Pilih Logo
                            <input type="file" wire:model="logo" accept="image/*" class="hidden">
                        </label>
                        @if($logo || $existingLogo)
                            <button type="button" wire:click="$set('logo', null)" class="ml-2 text-sm text-red-500 hover:text-red-700">
                                Hapus
                            </button>
                        @endif
                        <div wire:loading wire:target="logo" class="text-xs text-koperasi-dark/60 mt-2">
                            Mengunggah...
                        </div>
                    </div>
                </div>
                @error('logo') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Banner --}}
            <div>
                <label class="label">Banner Toko</label>
                <p class="text-xs text-koperasi-dark/40 mb-3">Ukuran maksimal 2MB. Format: JPG, PNG. Rasio 16:9 atau 21:9</p>
                
                <div class="space-y-3">
                    {{-- Preview --}}
                    @if($banner)
                        <div class="w-full h-48 rounded-xl border-3 border-koperasi-dark shadow-brutal overflow-hidden bg-white">
                            <img src="{{ $banner->temporaryUrl() }}" alt="Preview Banner" class="w-full h-full object-cover">
                        </div>
                    @elseif($existingBanner)
                        <div class="w-full h-48 rounded-xl border-3 border-koperasi-dark shadow-brutal overflow-hidden bg-white">
                            <img src="{{ Storage::url($existingBanner) }}" alt="Banner Toko" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-48 rounded-xl border-3 border-koperasi-dark shadow-brutal bg-koperasi-dark/5 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-koperasi-dark/30 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <p class="text-sm text-koperasi-dark/40">Banner toko belum diunggah</p>
                            </div>
                        </div>
                    @endif

                    {{-- Upload Button --}}
                    <div class="flex items-center gap-3">
                        <label class="btn-secondary cursor-pointer inline-flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                            </svg>
                            Pilih Banner
                            <input type="file" wire:model="banner" accept="image/*" class="hidden">
                        </label>
                        @if($banner || $existingBanner)
                            <button type="button" wire:click="$set('banner', null)" class="text-sm text-red-500 hover:text-red-700">
                                Hapus
                            </button>
                        @endif
                        <div wire:loading wire:target="banner" class="text-xs text-koperasi-dark/60">
                            Mengunggah...
                        </div>
                    </div>
                </div>
                @error('banner') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="card p-5 bg-blue-50 border-blue-200">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-blue-900">
                <p class="font-semibold mb-1">Tips Gambar Berkualitas:</p>
                <ul class="list-disc list-inside space-y-1 text-blue-800">
                    <li>Logo: Gunakan gambar persegi dengan latar belakang transparan atau putih</li>
                    <li>Banner: Gunakan gambar landscape dengan resolusi minimal 1920x1080px</li>
                    <li>Pastikan gambar jelas dan tidak buram</li>
                    <li>Hindari teks terlalu kecil yang sulit dibaca</li>
                </ul>
            </div>
        </div>
    </div>
</div>
