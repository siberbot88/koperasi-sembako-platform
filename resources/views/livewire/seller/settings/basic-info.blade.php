<div class="space-y-6">
    {{-- Informasi Dasar --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-koperasi-primary rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Informasi Dasar Toko</h2>
                <p class="text-sm text-koperasi-dark/60">Identitas dan deskripsi toko Anda</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Nama Toko --}}
            <div class="md:col-span-2">
                <label class="label">Nama Toko <span class="text-red-500">*</span></label>
                <input type="text" wire:model="name" class="input" placeholder="Contoh: Toko Sembako Berkah">
                @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Tagline --}}
            <div class="md:col-span-2">
                <label class="label">Tagline Toko</label>
                <input type="text" wire:model="tagline" class="input" placeholder="Contoh: Kebutuhan Pokok Berkualitas dengan Harga Terjangkau">
                <p class="text-xs text-koperasi-dark/40 mt-1">Slogan singkat yang menggambarkan toko Anda</p>
                @error('tagline') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label class="label">Deskripsi Toko</label>
                <textarea wire:model="description" rows="4" class="input" placeholder="Ceritakan tentang toko Anda, produk yang dijual, dan keunggulan toko..."></textarea>
                <p class="text-xs text-koperasi-dark/40 mt-1">Maksimal 1000 karakter</p>
                @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- Kontak --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Informasi Kontak</h2>
                <p class="text-sm text-koperasi-dark/60">Cara pelanggan menghubungi toko</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Phone --}}
            <div>
                <label class="label">Nomor Telepon</label>
                <input type="text" wire:model="phone" class="input" placeholder="08123456789">
                @error('phone') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- WhatsApp --}}
            <div>
                <label class="label">WhatsApp</label>
                <input type="text" wire:model="whatsapp" class="input" placeholder="08123456789">
                <p class="text-xs text-koperasi-dark/40 mt-1">Untuk tombol chat WhatsApp</p>
                @error('whatsapp') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div class="md:col-span-2">
                <label class="label">Email Toko</label>
                <input type="email" wire:model="email" class="input" placeholder="toko@example.com">
                @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- Alamat --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Alamat Toko</h2>
                <p class="text-sm text-koperasi-dark/60">Lokasi fisik toko Anda</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Alamat Lengkap --}}
            <div class="md:col-span-2">
                <label class="label">Alamat Lengkap</label>
                <textarea wire:model="address" rows="3" class="input" placeholder="Jl. Contoh No. 123, RT/RW 01/02"></textarea>
                @error('address') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Kota --}}
            <div>
                <label class="label">Kota/Kabupaten</label>
                <input type="text" wire:model="city" class="input" placeholder="Surabaya">
                @error('city') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Provinsi --}}
            <div>
                <label class="label">Provinsi</label>
                <input type="text" wire:model="province" class="input" placeholder="Jawa Timur">
                @error('province') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Kode Pos --}}
            <div>
                <label class="label">Kode Pos</label>
                <input type="text" wire:model="postal_code" class="input" placeholder="60123">
                @error('postal_code') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
</div>
