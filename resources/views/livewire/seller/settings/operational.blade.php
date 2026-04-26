<div class="space-y-6">
    {{-- Status Toko --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Status & Jam Operasional</h2>
                <p class="text-sm text-koperasi-dark/60">Atur ketersediaan dan jam buka toko</p>
            </div>
        </div>

        {{-- Status Aktif --}}
        <div class="mb-6 p-4 rounded-xl border-3 border-koperasi-dark shadow-brutal bg-white">
            <label class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" :class="$wire.is_active ? 'bg-green-100' : 'bg-red-100'">
                        <svg class="w-6 h-6" :class="$wire.is_active ? 'text-green-600' : 'text-red-600'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 0 0 7.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 0 0 4.902-5.652l-1.3-1.299a1.875 1.875 0 0 0-1.325-.549H5.223Z" />
                            <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 0 0 9.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 0 0 2.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3Zm3-6a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75v-3Zm8.25-.75a.75.75 0 0 0-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-5.25a.75.75 0 0 0-.75-.75h-3Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-koperasi-dark">Status Toko</p>
                        <p class="text-sm" :class="$wire.is_active ? 'text-green-600' : 'text-red-600'">
                            <span x-show="$wire.is_active">Toko sedang buka dan menerima pesanan</span>
                            <span x-show="!$wire.is_active">Toko sedang tutup, tidak menerima pesanan</span>
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                    <div class="w-14 h-8 bg-gray-300 rounded-full peer peer-checked:bg-green-500 transition-colors border-3 border-koperasi-dark shadow-brutal"></div>
                    <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full transition-transform peer-checked:translate-x-6 border-2 border-koperasi-dark"></div>
                </div>
            </label>
        </div>

        {{-- Jam Operasional --}}
        <div>
            <h3 class="font-bold text-koperasi-dark mb-3">Jam Operasional</h3>
            <div class="space-y-3">
                @foreach($operationalHours as $day => $hours)
                    <div class="p-4 rounded-xl border-2 border-koperasi-dark/20 bg-white" wire:key="day-{{ $day }}">
                        <div class="flex items-center gap-4">
                            {{-- Checkbox Tutup --}}
                            <label class="flex items-center gap-2 min-w-[100px]">
                                <input type="checkbox" wire:model="operationalHours.{{ $day }}.is_closed" class="w-4 h-4 rounded border-2 border-koperasi-dark text-koperasi-primary focus:ring-koperasi-primary">
                                <span class="text-sm font-semibold text-koperasi-dark">{{ $day }}</span>
                            </label>

                            {{-- Jam Buka/Tutup --}}
                            <div class="flex items-center gap-3 flex-1" x-show="!$wire.operationalHours.{{ $day }}.is_closed">
                                <input type="time" wire:model="operationalHours.{{ $day }}.open" class="input text-sm py-2">
                                <span class="text-koperasi-dark/40">-</span>
                                <input type="time" wire:model="operationalHours.{{ $day }}.close" class="input text-sm py-2">
                            </div>

                            {{-- Label Tutup --}}
                            <div x-show="$wire.operationalHours.{{ $day }}.is_closed" class="flex-1">
                                <span class="text-sm text-red-500 font-semibold">Tutup</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Pengaturan Pesanan --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Pengaturan Pesanan</h2>
                <p class="text-sm text-koperasi-dark/60">Minimal pembelian dan gratis ongkir</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Minimal Order --}}
            <div>
                <label class="label">Minimal Pembelian</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-koperasi-dark/60 font-semibold">Rp</span>
                    <input type="number" wire:model="min_order" class="input pl-12" placeholder="0" min="0">
                </div>
                <p class="text-xs text-koperasi-dark/40 mt-1">Minimal total belanja untuk bisa checkout (0 = tidak ada minimal)</p>
                @error('min_order') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Gratis Ongkir --}}
            <div>
                <label class="label">Gratis Ongkir Minimal</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-koperasi-dark/60 font-semibold">Rp</span>
                    <input type="number" wire:model="free_shipping_min" class="input pl-12" placeholder="0" min="0">
                </div>
                <p class="text-xs text-koperasi-dark/40 mt-1">Minimal belanja untuk gratis ongkir (0 = tidak ada gratis ongkir)</p>
                @error('free_shipping_min') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- Info --}}
    <div class="card p-5 bg-yellow-50 border-yellow-200">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-yellow-900">
                <p class="font-semibold mb-1">Perhatian:</p>
                <ul class="list-disc list-inside space-y-1 text-yellow-800">
                    <li>Jika status toko "Tutup", pelanggan tidak bisa melakukan checkout</li>
                    <li>Jam operasional akan ditampilkan di halaman toko</li>
                    <li>Centang hari untuk menandai toko tutup di hari tersebut</li>
                </ul>
            </div>
        </div>
    </div>
</div>
