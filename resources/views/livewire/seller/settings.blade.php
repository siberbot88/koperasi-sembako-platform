<div class="max-w-4xl mx-auto pb-24">
    <x-slot:header>Pengaturan Toko</x-slot:header>

    <form wire:submit.prevent="save" class="space-y-8">
        {{-- Section: Visual Profile --}}
        <div class="card-bordered p-8 bg-white">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-koperasi-primary/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-koperasi-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-koperasi-black">Profil Visual Toko</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                {{-- Logo Upload --}}
                <div class="md:col-span-4 space-y-3">
                    <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">Logo Toko (1:1)</label>
                    <div class="relative group">
                        <div class="w-full aspect-square rounded-3xl border-2 border-dashed border-koperasi-dark/10 bg-koperasi-bg flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-koperasi-primary/50">
                            @if ($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($existingLogo)
                                <img src="{{ asset('storage/' . $existingLogo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center p-4">
                                    <svg class="w-10 h-10 text-koperasi-dark/20 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-[10px] font-medium text-koperasi-dark/40">Upload Logo</p>
                                </div>
                            @endif
                        </div>
                        <input type="file" wire:model="logo" id="logo-upload" class="hidden">
                        <label for="logo-upload" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-koperasi-black/0 group-hover:bg-koperasi-black/40 transition-all rounded-3xl opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-koperasi-black text-[10px] font-bold px-3 py-1.5 rounded-xl shadow-brutal-sm">Ganti Logo</span>
                        </label>
                    </div>
                </div>

                {{-- Banner Upload --}}
                <div class="md:col-span-8 space-y-3">
                    <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">Banner Toko (16:9)</label>
                    <div class="relative group h-full max-h-[200px]">
                        <div class="w-full h-full aspect-video md:aspect-auto rounded-3xl border-2 border-dashed border-koperasi-dark/10 bg-koperasi-bg flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-koperasi-primary/50">
                            @if ($banner)
                                <img src="{{ $banner->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($existingBanner)
                                <img src="{{ asset('storage/' . $existingBanner) }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center p-4">
                                    <svg class="w-12 h-12 text-koperasi-dark/20 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                    <p class="text-[10px] font-medium text-koperasi-dark/40">Upload Banner</p>
                                </div>
                            @endif
                        </div>
                        <input type="file" wire:model="banner" id="banner-upload" class="hidden">
                        <label for="banner-upload" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-koperasi-black/0 group-hover:bg-koperasi-black/40 transition-all rounded-3xl opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-koperasi-black text-[10px] font-bold px-3 py-1.5 rounded-xl shadow-brutal-sm">Ganti Banner</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Basic Info --}}
        <div class="card-bordered p-8 bg-white">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-koperasi-primary/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-koperasi-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-koperasi-black">Informasi Dasar Toko</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-8">
                <div class="space-y-2">
                    <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">Nama Toko</label>
                    <input type="text" wire:model="name" class="input w-full py-4 px-5 text-base font-medium rounded-2xl" placeholder="Masukkan nama toko Anda">
                    @error('name') <span class="text-xs text-red-500 font-medium px-2">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">Deskripsi Toko</label>
                    <textarea wire:model="description" rows="4" class="input w-full py-4 px-5 text-base font-medium rounded-2xl resize-none" placeholder="Ceritakan tentang produk dan layanan toko Anda..."></textarea>
                    @error('description') <span class="text-xs text-red-500 font-medium px-2">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">No. WhatsApp</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-koperasi-dark/40 font-bold">+62</span>
                            <input type="text" wire:model="phone" class="input w-full py-4 pl-14 pr-5 text-base font-medium rounded-2xl" placeholder="8123456789">
                        </div>
                        @error('phone') <span class="text-xs text-red-500 font-medium px-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">Kota / Kabupaten</label>
                        <input type="text" wire:model="city" class="input w-full py-4 px-5 text-base font-medium rounded-2xl" placeholder="Contoh: Jakarta Timur">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="input-label font-bold text-xs uppercase tracking-wider text-koperasi-dark/60">Alamat Lengkap</label>
                    <input type="text" wire:model="address" class="input w-full py-4 px-5 text-base font-medium rounded-2xl" placeholder="Nama jalan, nomor gedung, atau patokan alamat">
                </div>
            </div>
        </div>

        {{-- Section: Operational Hours --}}
        <div class="card-bordered p-8 bg-white">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-koperasi-primary/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-koperasi-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-koperasi-black">Jam Operasional</h3>
            </div>
            
            <div class="overflow-hidden rounded-2xl border-2 border-koperasi-black">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-koperasi-bg border-b-2 border-koperasi-black">
                            <th class="px-6 py-4 text-left font-bold text-xs uppercase tracking-widest text-koperasi-dark/50">Hari</th>
                            <th class="px-6 py-4 text-left font-bold text-xs uppercase tracking-widest text-koperasi-dark/50">Jam Buka</th>
                            <th class="px-6 py-4 text-left font-bold text-xs uppercase tracking-widest text-koperasi-dark/50">Jam Tutup</th>
                            <th class="px-6 py-4 text-center font-bold text-xs uppercase tracking-widest text-koperasi-dark/50">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-koperasi-dark/5">
                        @foreach($operationalHours as $day => $config)
                        <tr class="{{ ($operationalHours[$day]['is_closed'] ?? false) ? 'bg-koperasi-dark/[0.02]' : '' }}">
                            <td class="px-6 py-4 font-bold text-koperasi-black">{{ $day }}</td>
                            <td class="px-6 py-4">
                                <input type="time" wire:model="operationalHours.{{ $day }}.open" 
                                       class="bg-koperasi-bg border-2 border-koperasi-dark/10 rounded-xl px-3 py-2 focus:ring-2 focus:ring-koperasi-primary outline-none font-bold"
                                       {{ ($operationalHours[$day]['is_closed'] ?? false) ? 'disabled' : '' }}>
                            </td>
                            <td class="px-6 py-4">
                                <input type="time" wire:model="operationalHours.{{ $day }}.close"
                                       class="bg-koperasi-bg border-2 border-koperasi-dark/10 rounded-xl px-3 py-2 focus:ring-2 focus:ring-koperasi-primary outline-none font-bold"
                                       {{ ($operationalHours[$day]['is_closed'] ?? false) ? 'disabled' : '' }}>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="operationalHours.{{ $day }}.is_closed" class="sr-only peer">
                                    <div class="w-11 h-6 bg-koperasi-dark/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-koperasi-dark"></div>
                                    <span class="ms-3 text-xs font-bold text-koperasi-dark/40 peer-checked:text-koperasi-dark">Tutup</span>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sticky Footer Actions --}}
        <div class="sticky bottom-6 z-40 mt-12">
            <div class="bg-white/95 backdrop-blur-xl border-2 border-koperasi-black p-4 rounded-3xl shadow-brutal flex items-center justify-between gap-4">
                <div class="hidden sm:block">
                    <p class="text-xs font-bold text-koperasi-black">Konfigurasi Toko</p>
                    <p class="text-[10px] text-koperasi-dark/50">Pastikan semua informasi sudah benar</p>
                </div>
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <button type="button" class="px-6 py-2 text-sm font-bold text-koperasi-dark/60 hover:text-red-500 transition-colors">Reset</button>
                    <button type="submit" class="btn-primary flex-1 sm:flex-none justify-center px-8 py-3" wire:loading.attr="disabled">
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
