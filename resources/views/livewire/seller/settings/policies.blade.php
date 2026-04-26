<div class="space-y-6">
    {{-- Kebijakan Toko --}}
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-koperasi-dark">Kebijakan Toko</h2>
                <p class="text-sm text-koperasi-dark/60">Aturan dan ketentuan toko</p>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Kebijakan Pengembalian --}}
            <div>
                <label class="label">Kebijakan Pengembalian Barang</label>
                <textarea wire:model="return_policy" rows="6" class="input" placeholder="Contoh:
- Barang dapat dikembalikan dalam 7 hari setelah diterima
- Barang harus dalam kondisi asli dan tidak rusak
- Biaya pengiriman pengembalian ditanggung pembeli
- Pengembalian uang akan diproses dalam 3-5 hari kerja
- Barang yang sudah dibuka/digunakan tidak dapat dikembalikan"></textarea>
                <p class="text-xs text-koperasi-dark/40 mt-1">Jelaskan syarat dan ketentuan pengembalian barang</p>
                @error('return_policy') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Kebijakan Pengiriman --}}
            <div>
                <label class="label">Kebijakan Pengiriman</label>
                <textarea wire:model="shipping_policy" rows="6" class="input" placeholder="Contoh:
- Pengiriman dilakukan setiap hari Senin-Sabtu
- Pesanan akan diproses dalam 1-2 hari kerja
- Estimasi pengiriman 2-5 hari kerja (tergantung lokasi)
- Gratis ongkir untuk pembelian minimal Rp 100.000
- Barang akan dikemas dengan aman dan rapi
- Komplain kerusakan saat pengiriman maksimal 1x24 jam"></textarea>
                <p class="text-xs text-koperasi-dark/40 mt-1">Jelaskan proses dan ketentuan pengiriman</p>
                @error('shipping_policy') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Syarat dan Ketentuan --}}
            <div>
                <label class="label">Syarat dan Ketentuan</label>
                <textarea wire:model="terms_conditions" rows="8" class="input" placeholder="Contoh:
1. UMUM
- Dengan berbelanja di toko ini, pembeli dianggap telah memahami dan menyetujui syarat dan ketentuan
- Toko berhak mengubah syarat dan ketentuan tanpa pemberitahuan sebelumnya

2. PEMESANAN
- Pastikan alamat pengiriman sudah benar sebelum checkout
- Pesanan yang sudah dikonfirmasi tidak dapat dibatalkan
- Stok barang dapat berubah sewaktu-waktu

3. PEMBAYARAN
- Pembayaran harus dilakukan sesuai metode yang tersedia
- Pesanan akan diproses setelah pembayaran dikonfirmasi
- Bukti pembayaran harus disimpan sebagai referensi

4. LAYANAN PELANGGAN
- Jam operasional customer service: Senin-Sabtu 08:00-17:00
- Komplain dapat disampaikan melalui WhatsApp atau email
- Respon komplain maksimal 1x24 jam"></textarea>
                <p class="text-xs text-koperasi-dark/40 mt-1">Syarat dan ketentuan lengkap berbelanja di toko</p>
                @error('terms_conditions') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- Template Kebijakan --}}
    <div class="card p-5 bg-green-50 border-green-200">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm1.5 9.75a.75.75 0 0 0-.75.75v2.25a.75.75 0 0 0 1.5 0V12a.75.75 0 0 0-.75-.75Zm0 5.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-green-900">
                <p class="font-semibold mb-1">Tips Kebijakan:</p>
                <ul class="list-disc list-inside space-y-1 text-green-800">
                    <li>Buat kebijakan yang jelas dan mudah dipahami pelanggan</li>
                    <li>Sesuaikan dengan jenis produk yang dijual (sembako)</li>
                    <li>Cantumkan jam operasional dan kontak customer service</li>
                    <li>Update kebijakan secara berkala sesuai kebutuhan</li>
                    <li>Kebijakan akan ditampilkan di footer website</li>
                </ul>
            </div>
        </div>
    </div>
</div>