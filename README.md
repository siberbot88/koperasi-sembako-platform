# 🛒 Koperasi Sembako Platform

> Platform e-commerce koperasi sembako modern berbasis web, dibangun dengan Laravel 12, Livewire 3, dan MongoDB.

---

## 📖 Tentang Aplikasi

**Koperasi Sembako Platform** adalah sistem e-commerce khusus yang dirancang untuk membantu **koperasi kebutuhan pokok (sembako)** dalam mengelola dan menjual produk secara digital kepada anggota maupun masyarakat umum.

### Latar Belakang & Sejarah

Koperasi adalah salah satu pilar perekonomian Indonesia. Namun, kebanyakan koperasi masih beroperasi secara konvensional — pencatatan manual, transaksi tatap muka, dan tanpa digitalisasi. Di era e-commerce yang terus berkembang, koperasi perlu bertransformasi agar tetap relevan dan kompetitif.

Platform ini lahir dari kebutuhan nyata: **bagaimana sebuah koperasi sembako bisa bersaing dengan marketplace besar**, namun tetap mempertahankan nilai gotong royong dan keterjangkauan harga koperasi. Solusinya adalah platform e-commerce terintegrasi yang mudah dioperasikan oleh pengelola koperasi, namun tetap memberikan pengalaman belanja yang modern bagi pelanggan.

---

## 🎯 Fungsi Utama

| Peran | Fungsi |
|---|---|
| **Pelanggan (Customer)** | Belanja produk sembako secara online, lacak pesanan, kumpulkan poin loyalitas, wishlist, dan chat AI support |
| **Penjual (Seller/Admin)** | Kelola produk, pantau pesanan, analitik penjualan, atur promosi, baca ulasan |

---

## ✨ Fitur Lengkap

### 🏪 Storefront (Halaman Pelanggan)

| Fitur | Deskripsi |
|---|---|
| **Beranda** | Banner promo, produk unggulan, kategori, produk terlaris |
| **Katalog Produk** | Filter kategori, pencarian, sorting harga/terlaris |
| **Detail Produk** | Foto produk, deskripsi, spesifikasi, ulasan pembeli |
| **Keranjang Belanja** | Tambah/kurangi produk, hitung subtotal otomatis |
| **Checkout** | Pilih alamat pengiriman, pilih kurir (JNE, J&T, dll), pilih kupon diskon |
| **Riwayat Pesanan** | Daftar semua pesanan beserta status real-time |
| **Detail Pesanan** | Tracking status, info kurir, ringkasan produk yang dipesan |
| **Ulasan Produk** | Beri rating bintang dan komentar setelah menerima pesanan |
| **Wishlist** | Simpan produk favorit untuk dibeli nanti |
| **Program Loyalitas** | Kumpulkan poin dari setiap transaksi, lihat riwayat poin |
| **AI Support Widget** | Chat langsung dengan AI asisten berbasis Grok untuk tanya jawab produk & pesanan |

### 🖥️ Dashboard Seller (Panel Admin Toko)

| Fitur | Deskripsi |
|---|---|
| **Ringkasan Statistik** | Total produk, pesanan hari ini, pendapatan hari ini, produk stok rendah |
| **Grafik Retensi Pelanggan** | Timeseries harian transaksi 30 hari terakhir (ApexCharts) |
| **Pie Chart Kategori Terlaris** | Visualisasi proporsi penjualan per kategori produk |
| **Treemap Distribusi Volume** | Perbandingan volume penjualan antar kategori |
| **Manajemen Produk** | CRUD produk lengkap dengan upload foto, harga diskon, stok |
| **Manajemen Pesanan** | Lihat semua pesanan, update status (pending → diproses → dikirim → selesai) |
| **Promosi & Kupon** | Buat kode kupon diskon persentase atau nominal |
| **Insight Ulasan** | Analisis rating dan komentar pelanggan |
| **Pengaturan Toko** | Profil toko, logo, banner, jam operasional per hari, nomor WhatsApp |

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Fungsi |
|---|---|---|
| **Laravel** | 12.x | Backend framework utama |
| **Livewire** | 3.x | Reactive UI tanpa JavaScript berat |
| **MongoDB** | 7.x | Database NoSQL untuk fleksibilitas data |
| **Tailwind CSS** | 3.x | Utility-first CSS framework |
| **ApexCharts** | Latest | Grafik interaktif di dashboard |
| **Vite** | 6.x | Asset bundler & hot reload |
| **PHP** | 8.2+ | Runtime server |
| **Grok AI (xAI)** | API | AI support chatbot |

---

## 📁 Struktur Direktori Penting

```
app/
├── Livewire/
│   ├── Seller/
│   │   ├── Dashboard.php         # Analytics & statistik
│   │   ├── ProductForm.php       # Tambah/edit produk
│   │   ├── ProductList.php       # Daftar produk
│   │   ├── OrderList.php         # Manajemen pesanan
│   │   ├── Promotions.php        # Manajemen kupon
│   │   ├── ReviewInsight.php     # Analisis ulasan
│   │   └── Settings.php          # Pengaturan toko
│   ├── Storefront/
│   │   ├── Home.php              # Beranda
│   │   ├── ProductIndex.php      # Katalog produk
│   │   ├── ProductDetail.php     # Detail produk
│   │   ├── CartPage.php          # Keranjang
│   │   ├── Checkout.php          # Proses checkout
│   │   ├── OrderHistory.php      # Riwayat pesanan
│   │   ├── OrderDetail.php       # Detail pesanan
│   │   ├── ReviewForm.php        # Form ulasan
│   │   ├── RewardsPage.php       # Program loyalitas
│   │   └── WishlistPage.php      # Wishlist
│   └── AiSupportWidget.php       # Chat AI support
├── Models/
│   ├── User.php
│   ├── Store.php
│   ├── Product.php
│   ├── Category.php
│   ├── Order.php
│   ├── Cart.php
│   ├── Review.php
│   ├── Coupon.php
│   ├── Banner.php
│   └── Wishlist.php
└── Services/
    └── GrokSupportService.php    # Integrasi Grok AI
```

---

## ⚙️ Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan sistem Anda sudah terpasang:

- **PHP** >= 8.2 (dengan ekstensi: `mongodb`, `fileinfo`, `gd`, `openssl`, `pdo`)
- **Composer** >= 2.x
- **Node.js** >= 18.x dan **npm** >= 9.x
- **MongoDB** >= 6.x (Community Edition atau Atlas)
- **Git**

---

## 🚀 Tutorial Instalasi & Menjalankan Aplikasi

### Langkah 1 — Clone Repository

```bash
git clone https://github.com/siberbot88/koperasi-sembako-platform.git
cd koperasi-sembako-platform
```

### Langkah 2 — Install Dependensi PHP

```bash
composer install
```

### Langkah 3 — Install Dependensi Node.js

```bash
npm install
```

### Langkah 4 — Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="Koperasi Sembako"
APP_URL=http://127.0.0.1:8000

# Konfigurasi Database MongoDB
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=koperasi_sembako
DB_USERNAME=        # Kosongkan jika tanpa auth
DB_PASSWORD=        # Kosongkan jika tanpa auth

# Konfigurasi AI Support (opsional)
GROK_API_KEY=your_grok_api_key_here
```

### Langkah 5 — Generate Application Key

```bash
php artisan key:generate
```

### Langkah 6 — Buat Symlink Storage

```bash
php artisan storage:link
```

### Langkah 7 — Jalankan Migrasi & Seeder

> ⚠️ Perintah ini akan mengisi database dengan data awal (seller, produk, kategori, kupon, banner).

```bash
php artisan migrate
php artisan db:seed
```

Jika ingin mereset database dari awal (hapus semua data lama):

```bash
# Buat file drop_mongo.php di root project, lalu:
php artisan migrate:fresh
php artisan db:seed
```

### Langkah 8 — Jalankan Server

Buka **2 terminal terpisah**:

**Terminal 1 — Laravel Development Server:**
```bash
php artisan serve
```

**Terminal 2 — Vite Asset Compiler:**
```bash
npm run dev
```

### Langkah 9 — Akses Aplikasi

Buka browser dan kunjungi:

| Halaman | URL |
|---|---|
| **Storefront (Belanja)** | http://127.0.0.1:8000 |
| **Login Seller** | http://127.0.0.1:8000/login |
| **Dashboard Seller** | http://127.0.0.1:8000/seller |

---

## 🔐 Akun Default

Setelah menjalankan seeder, tersedia akun berikut:

| Peran | Email | Password |
|---|---|---|
| **Seller / Admin** | `admin@koperasisembako.id` | `password` |
| **Customer** | `siti@example.com` | `password` |

> 💡 Untuk mendaftarkan akun customer baru, gunakan tombol **"Daftar disini"** di halaman login.

---

## 📊 Mengisi Data Produk

Setelah login sebagai seller, Anda bisa:

1. **Menambah produk manual** via menu **Produk → Tambah Produk**
2. **Atau jalankan ProductSeeder** untuk mengisi 45 produk brand nyata sekaligus:

```bash
php artisan db:seed --class=ProductSeeder
```

---

## 🔧 Konfigurasi AI Support (Opsional)

Fitur **AI Support Widget** menggunakan API dari **xAI Grok**. Untuk mengaktifkannya:

1. Daftar di [https://x.ai](https://x.ai) dan dapatkan API key
2. Tambahkan ke `.env`:
   ```env
   GROK_API_KEY=xai-xxxxxxxxxxxxxxxxxxxx
   ```
3. Restart server Laravel

---

## 🌐 Kurir yang Didukung

Aplikasi mendukung pilihan kurir berikut saat checkout:

- JNE (Jalur Nugraha Ekakurir)
- J&T Express
- SiCepat Ekspres
- AnterAja
- Ninja Express
- Grab Express
- GoSend

---

## 📸 Fitur Unggulan

### Dashboard Analytics
- Grafik retensi pelanggan (timeseries 30 hari)
- Pie chart distribusi kategori produk terlaris
- Treemap perbandingan volume antar kategori
- Semua menggunakan **ApexCharts** dengan tema premium gold & black

### Program Loyalitas
- Pelanggan mendapat poin setiap transaksi selesai
- Riwayat transaksi poin tersedia di halaman Rewards
- Sistem badge berdasarkan total poin yang dikumpulkan

### Desain Premium
- Palet warna: Kuning (#F6F930), Hijau (#D2F898), Putih (#FCFCFC), Hitam (#2F2F2F)
- Efek brutal shadow pada card
- Animasi hover & transisi halus
- Responsive untuk mobile dan desktop

---

## 🤝 Kontribusi

Pull request sangat disambut. Untuk perubahan besar, harap buka issue terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](LICENSE).

---

<div align="center">
  <strong>Dibuat dengan ❤️ untuk digitalisasi koperasi Indonesia</strong>
</div>
