<div>
    <x-slot:header>{{ $productId ? 'Edit Produk' : 'Tambah Produk' }}</x-slot:header>

    <form wire:submit="save" class="max-w-3xl">
        <div class="space-y-5">
            {{-- Basic Info --}}
            <div class="card-bordered p-5">
                <h3 class="font-bold text-sm text-koperasi-black mb-4">Informasi Produk</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="sm:col-span-2">
                        <label class="input-label">Nama Produk</label>
                        <input type="text" wire:model="name" class="input" placeholder="Contoh: Beras Premium Pandan Wangi 5kg">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">SKU</label>
                        <input type="text" wire:model="sku" class="input" placeholder="BRS-001">
                        @error('sku') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Kategori</label>
                        <select wire:model="categoryId" class="input">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->_id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('categoryId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="input-label">Deskripsi</label>
                        <textarea wire:model="description" class="input" rows="3" placeholder="Deskripsi singkat produk"></textarea>
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="card-bordered p-5">
                <h3 class="font-bold text-sm text-koperasi-black mb-4">Harga & Satuan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="input-label">Harga Dasar (Rp)</label>
                        <input type="number" wire:model="basePrice" class="input" min="0" placeholder="0">
                        @error('basePrice') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Satuan</label>
                        <select wire:model="unit" class="input">
                            <option value="pack">Pack</option>
                            <option value="kg">Kg</option>
                            <option value="liter">Liter</option>
                            <option value="pcs">Pcs</option>
                            <option value="botol">Botol</option>
                            <option value="sachet">Sachet</option>
                        </select>
                    </div>
                    <div>
                        <label class="input-label">Berat (gram)</label>
                        <input type="number" wire:model="weightGrams" class="input" min="0" placeholder="0">
                    </div>
                </div>

                {{-- Discount --}}
                <div class="mt-4 pt-4 border-t border-koperasi-dark/10">
                    <h4 class="text-xs font-semibold text-koperasi-dark/60 uppercase tracking-wider mb-3">Diskon (Opsional)</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="input-label">Harga Diskon (Rp)</label>
                            <input type="number" wire:model="discountPrice" class="input" min="0" placeholder="Kosongkan jika tidak ada">
                        </div>
                        <div>
                            <label class="input-label">Mulai Diskon</label>
                            <input type="date" wire:model="discountStart" class="input">
                        </div>
                        <div>
                            <label class="input-label">Akhir Diskon</label>
                            <input type="date" wire:model="discountEnd" class="input">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stock --}}
            <div class="card-bordered p-5">
                <h3 class="font-bold text-sm text-koperasi-black mb-4">Stok & Pemesanan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="input-label">Stok</label>
                        <input type="number" wire:model="stock" class="input" min="0" placeholder="0">
                        @error('stock') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Min. Order</label>
                        <input type="number" wire:model="minOrder" class="input" min="1" placeholder="1">
                    </div>
                    <div>
                        <label class="input-label">Max. Order</label>
                        <input type="number" wire:model="maxOrder" class="input" min="1" placeholder="50">
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="card-bordered p-5">
                <h3 class="font-bold text-sm text-koperasi-black mb-4">Gambar Produk</h3>
                <div>
                    <label class="input-label">Thumbnail</label>
                    <input type="file" wire:model="thumbnail" accept="image/*" class="input py-1.5">
                    @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

                    @if($thumbnail)
                    <div class="mt-3">
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-xl border-2 border-koperasi-dark/10">
                    </div>
                    @elseif($existingThumbnail)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $existingThumbnail) }}" class="w-24 h-24 object-cover rounded-xl border-2 border-koperasi-dark/10">
                        <p class="text-[10px] text-koperasi-dark/50 mt-1">Gambar saat ini</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Status & Submit --}}
            <div class="card-bordered p-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <label class="input-label">Status</label>
                        <select wire:model="status" class="input w-auto">
                            <option value="active">Aktif</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('seller.products') }}" class="btn-outline" wire:navigate>Batal</a>
                        <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>{{ $productId ? 'Simpan Perubahan' : 'Tambah Produk' }}</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
