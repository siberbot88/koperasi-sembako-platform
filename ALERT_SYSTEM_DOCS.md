# Sistem Alert & Notifikasi - Koperasi Sembako

## 📋 Komponen yang Tersedia

Sistem alert dan notifikasi telah diintegrasikan ke dalam aplikasi dengan 5 komponen utama:

### 1. **Toast Notifications** 🍞
Notifikasi pop-up yang muncul di pojok kanan bawah layar.

**Lokasi:** `resources/views/components/ui/toast-container.blade.php`

**Cara Penggunaan di Livewire:**
```php
// Success (hijau/kuning)
$this->dispatch('toast', message: 'Berhasil menyimpan data!');

// Error (merah)
$this->dispatch('toast', message: 'Terjadi kesalahan!', type: 'error');

// Warning (kuning)
$this->dispatch('toast', message: 'Perhatian!', type: 'warning');

// Info (biru)
$this->dispatch('toast', message: 'Informasi penting', type: 'info');

// Custom duration (default 4000ms)
$this->dispatch('toast', message: 'Pesan singkat', type: 'success', duration: 2000);
```

**Cara Penggunaan di JavaScript/Alpine:**
```javascript
// Trigger dari JavaScript
window.dispatchEvent(new CustomEvent('toast', {
    detail: {
        message: 'Berhasil!',
        type: 'success',
        duration: 4000
    }
}));
```

**Fitur:**
- Auto-dismiss dengan progress bar
- 4 tipe: success, error, warning, info
- Animasi smooth masuk/keluar
- Tombol close manual
- Stack multiple toasts
- Warna sesuai tema koperasi

---

### 2. **Offline Banner** 📡
Banner yang muncul di atas layar saat koneksi internet terputus.

**Lokasi:** `resources/views/components/ui/offline-banner.blade.php`

**Fitur:**
- Deteksi otomatis saat offline/online
- Tombol "Coba Lagi" dengan loading state
- Auto-hide saat koneksi kembali
- Animasi ping pada icon
- Warna tema koperasi (hitam + kuning)

**Tidak perlu konfigurasi** - otomatis bekerja!

---

### 3. **Livewire Progress Bar** ⚡
Progress bar di atas layar saat navigasi Livewire.

**Lokasi:** `resources/views/components/ui/livewire-progress.blade.php`

**Fitur:**
- Muncul otomatis saat navigasi Livewire
- Animasi smooth 0-100%
- Warna kuning neon dengan glow effect
- Auto-hide setelah selesai

**Tidak perlu konfigurasi** - otomatis bekerja dengan Livewire!

---

### 4. **Livewire Error Overlay** ❌
Modal overlay yang muncul saat terjadi error koneksi atau server.

**Lokasi:** `resources/views/components/ui/livewire-error.blade.php`

**Fitur:**
- Deteksi 2 tipe error:
  - **Connection Failed**: Koneksi terputus
  - **Server Error**: Error 500+
- Auto-retry dengan countdown (10 detik)
- Tombol manual "Muat Ulang"
- Tombol "Tutup" untuk dismiss
- Backdrop blur

**Tidak perlu konfigurasi** - otomatis bekerja!

---

### 5. **Confirm Dialog** ⚠️
Modal konfirmasi untuk aksi penting (hapus, batalkan, dll).

**Lokasi:** `resources/views/components/ui/confirm-dialog.blade.php`

**Cara Penggunaan:**
```javascript
// Trigger dari Alpine.js
window.dispatchEvent(new CustomEvent('confirm', {
    detail: {
        title: 'Hapus Produk?',
        message: 'Produk yang dihapus tidak dapat dikembalikan.',
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        type: 'danger', // danger, warning, info
        onConfirm: '$wire.deleteProduct(123)' // Livewire method call
    }
}));
```

**Contoh di Blade:**
```html
<button @click="$dispatch('confirm', {
    title: 'Hapus Produk?',
    message: 'Apakah Anda yakin ingin menghapus produk ini?',
    confirmText: 'Ya, Hapus',
    cancelText: 'Batal',
    type: 'danger',
    onConfirm: '$wire.deleteProduct(' + productId + ')'
})">
    Hapus
</button>
```

**Tipe Dialog:**
- `danger` - Merah (untuk hapus, batalkan)
- `warning` - Kuning (untuk peringatan)
- `info` - Biru (untuk informasi)

---

## 🎨 Desain & Tema

Semua komponen menggunakan **Neobrutalism Design** dengan:
- Border tebal (2px) hitam
- Shadow brutal
- Warna tema koperasi:
  - Primary: `#F6F930` (kuning)
  - Accent: `#C8FF6D` (hijau muda)
  - Dark: `#1A1A1A` (hitam)
- Rounded corners (xl, 2xl)
- Animasi smooth

---

## 📦 Instalasi & Setup

### File JavaScript
Semua fungsi Alpine.js ada di: `resources/js/ui-components.js`

File ini sudah di-import di `resources/js/app.js`:
```javascript
import './ui-components';
```

### Komponen Blade
Semua komponen sudah di-include di layout:
- `resources/views/layouts/storefront.blade.php`
- `resources/views/layouts/seller.blade.php`

### Build Assets
Setelah perubahan, rebuild dengan:
```bash
npm run build
```

### Clear Cache
```bash
php artisan optimize:clear
```

---

## 🧪 Testing

### Test Toast
Tambahkan produk ke keranjang atau lakukan aksi apapun yang memicu toast.

### Test Offline Banner
1. Buka DevTools (F12)
2. Network tab → Throttling → Offline
3. Banner akan muncul otomatis

### Test Livewire Progress
Navigasi antar halaman dengan Livewire (wire:navigate).

### Test Error Overlay
1. Matikan server PHP
2. Coba navigasi atau submit form
3. Error overlay akan muncul dengan countdown

### Test Confirm Dialog
Gunakan tombol hapus di halaman seller (produk, kupon, dll).

---

## 🐛 Troubleshooting

### Toast tidak muncul?
1. Cek console browser untuk error JavaScript
2. Pastikan `resources/js/ui-components.js` ter-load
3. Rebuild assets: `npm run build`
4. Clear cache: `php artisan optimize:clear`

### Offline banner tidak muncul?
1. Cek apakah browser support `navigator.onLine`
2. Test dengan DevTools Network → Offline

### Livewire progress tidak muncul?
1. Pastikan menggunakan `wire:navigate` pada link
2. Cek Livewire version (harus v3+)

### Error "ArgumentCountError"?
Ini terjadi jika ada `<script>` tag di file Blade component. Semua script sudah dipindah ke `ui-components.js`.

---

## 📝 Contoh Penggunaan Lengkap

### Di Livewire Component (PHP)
```php
public function deleteProduct($id)
{
    $product = Product::find($id);
    
    if (!$product) {
        $this->dispatch('toast', message: 'Produk tidak ditemukan', type: 'error');
        return;
    }
    
    $product->delete();
    $this->dispatch('toast', message: 'Produk berhasil dihapus!');
}
```

### Di Blade View (HTML)
```html
<!-- Tombol dengan konfirmasi -->
<button 
    @click="$dispatch('confirm', {
        title: 'Hapus Produk?',
        message: 'Produk yang dihapus tidak dapat dikembalikan.',
        confirmText: 'Ya, Hapus',
        type: 'danger',
        onConfirm: '$wire.deleteProduct({{ $product->id }})'
    })"
    class="btn btn-danger"
>
    Hapus
</button>

<!-- Toast manual dari Alpine -->
<button 
    @click="$dispatch('toast', { 
        message: 'Tombol diklik!', 
        type: 'info' 
    })"
>
    Test Toast
</button>
```

---

## ✅ Status Implementasi

- ✅ Toast Container - **DONE**
- ✅ Offline Banner - **DONE**
- ✅ Livewire Progress Bar - **DONE**
- ✅ Livewire Error Overlay - **DONE**
- ✅ Confirm Dialog - **DONE**
- ✅ Integrasi ke Storefront Layout - **DONE**
- ✅ Integrasi ke Seller Layout - **DONE**
- ✅ Build Assets - **DONE**
- ✅ Clear Cache - **DONE**
- ⏳ Testing - **IN PROGRESS**

---

## 🎯 Next Steps

1. Test semua komponen di browser
2. Verifikasi toast muncul saat add to cart
3. Test offline banner dengan disconnect internet
4. Test error overlay dengan matikan server
5. Tambahkan confirm dialog ke tombol hapus yang belum ada

---

**Dibuat:** 26 April 2026
**Status:** Ready for Testing
