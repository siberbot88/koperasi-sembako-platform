<div>
    <x-slot:header>Promosi & Tukar Poin</x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form Create --}}
        <div class="lg:col-span-1">
            <div class="card-bordered p-5 sticky top-20">
                <h3 class="font-bold text-sm text-koperasi-black mb-4">Buat Promo Baru</h3>
                <form wire:submit="save" class="space-y-4">
                    
                    <div>
                        <label class="input-label">Tipe Kupon</label>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <label class="px-3 py-2 border-2 rounded-lg cursor-pointer flex items-center justify-center text-xs font-bold transition-colors {{ $couponType === 'public' ? 'bg-koperasi-primary/20 border-koperasi-primary text-koperasi-black' : 'border-gray-200 text-gray-500' }}">
                                <input type="radio" wire:model.live="couponType" value="public" class="sr-only">
                                Kupon Publik
                            </label>
                            <label class="px-3 py-2 border-2 rounded-lg cursor-pointer flex items-center justify-center text-xs font-bold transition-colors {{ $couponType === 'reward' ? 'bg-koperasi-accent/30 border-koperasi-primary text-koperasi-black' : 'border-gray-200 text-gray-500' }}">
                                <input type="radio" wire:model.live="couponType" value="reward" class="sr-only">
                                Reward Poin
                            </label>
                        </div>
                    </div>

                    @if($couponType === 'reward')
                    <div class="bg-koperasi-accent/10 p-3 rounded-xl border border-koperasi-accent/30">
                        <label class="input-label text-koperasi-dark">Harga Poin</label>
                        <input type="number" wire:model="pointsCost" class="input" min="1" placeholder="Contoh: 100">
                        @error('pointsCost') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        <p class="text-[10px] text-koperasi-dark/60 mt-1">Berapa poin yang harus ditukar pelanggan untuk mendapat diskon ini?</p>
                    </div>
                    @endif

                    <div>
                        <label class="input-label">Kode / Nama Singkat</label>
                        <input type="text" wire:model="code" class="input uppercase" placeholder="MERDEKA50">
                        @error('code') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="input-label">Tipe Diskon</label>
                            <select wire:model.live="type" class="input">
                                <option value="fixed">Nominal (Rp)</option>
                                <option value="percentage">Persen (%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="input-label">Nilai Diskon</label>
                            <input type="number" wire:model="value" class="input">
                            @error('value') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($type === 'percentage')
                    <div>
                        <label class="input-label">Maksimal Diskon (Rp)</label>
                        <input type="number" wire:model="maxDiscount" class="input" placeholder="Kosongkan jika tanpa batas">
                    </div>
                    @endif

                    <div>
                        <label class="input-label">Minimal Pembelanjaan (Rp)</label>
                        <input type="number" wire:model="minOrder" class="input" min="0">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="input-label">Mulai Berlaku</label>
                            <input type="date" wire:model="validFrom" class="input text-sm">
                        </div>
                        <div>
                            <label class="input-label">Berakhir Pada</label>
                            <input type="date" wire:model="validUntil" class="input text-sm">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-primary w-full justify-center">Simpan Promosi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table List --}}
        <div class="lg:col-span-2">
            <div class="card-bordered overflow-hidden p-1 sm:p-4 bg-white">
                <div class="overflow-x-auto">
                    <table class="table-koperasi w-full">
                        <thead>
                            <tr>
                                <th>Promo</th>
                                <th>Detail Diskon</th>
                                <th>Periode & Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                            <tr class="hover:bg-koperasi-dark/5">
                                <td>
                                    <span class="font-mono font-bold text-sm bg-koperasi-dark/10 px-2 py-1 rounded">{{ $coupon->code }}</span>
                                    @if($coupon->points_cost > 0)
                                    <div class="mt-2 text-xs font-bold text-koperasi-primary flex items-center gap-1">
                                        <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/></svg>
                                        Reward ({{ $coupon->points_cost }} Pts)
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="font-bold text-sm text-koperasi-black">
                                        {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'Rp ' . number_format($coupon->value, 0, ',', '.') }}
                                    </p>
                                    @if($coupon->min_order_amount > 0)
                                    <p class="text-[10px] text-koperasi-dark/50">Min. Rp {{ number_format($coupon->min_order_amount, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->valid_until)
                                    <p class="text-xs text-koperasi-dark/70 mb-1">s/d {{ $coupon->valid_until->format('d M Y') }}</p>
                                    @else
                                    <p class="text-xs text-koperasi-dark/50 mb-1">Selamanya</p>
                                    @endif
                                    
                                    <label class="relative inline-flex items-center cursor-pointer mt-1">
                                      <input type="checkbox" class="sr-only peer" wire:click="toggleStatus('{{ $coupon->_id }}')" {{ $coupon->is_active ? 'checked' : '' }}>
                                      <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-koperasi-primary"></div>
                                      <span class="ml-2 text-[10px] font-bold {{ $coupon->is_active ? 'text-koperasi-primary' : 'text-gray-400' }}">{{ $coupon->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <button 
                                        @click="$dispatch('confirm', {
                                            title: 'Hapus Kupon?',
                                            message: 'Kupon yang dihapus tidak dapat dikembalikan.',
                                            confirmText: 'Ya, Hapus',
                                            cancelText: 'Batal',
                                            type: 'danger',
                                            onConfirm: '$wire.delete(\'{{ $coupon->_id }}\')'
                                        })"
                                        class="text-red-500 hover:text-red-700 p-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-sm text-koperasi-dark/50">
                                    Belum ada promosi berjalan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
