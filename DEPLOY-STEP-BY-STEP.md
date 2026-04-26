# 🚀 PANDUAN DEPLOY STEP-BY-STEP - 100% GRATIS

> **Target**: Deploy aplikasi Laravel ke internet dengan biaya $0/bulan  
> **Waktu**: 20-30 menit  
> **Platform**: Railway + MongoDB Atlas  

---

## 📋 PERSIAPAN AWAL

### ✅ Yang Harus Sudah Ada:
- [x] Project sudah di-push ke GitHub ✅
- [x] Akun GitHub aktif
- [x] Email untuk daftar MongoDB Atlas
- [x] Email untuk daftar Railway

---

## 🗄️ BAGIAN 1: SETUP DATABASE MONGODB ATLAS (10 menit)

### Step 1.1: Daftar MongoDB Atlas

1. **Buka browser** dan kunjungi: https://www.mongodb.com/cloud/atlas
2. **Klik "Try Free"** (tombol hijau di kanan atas)
3. **Pilih cara daftar**:
   - Dengan Google: Klik "Sign up with Google"
   - Dengan Email: Isi form pendaftaran
4. **Verifikasi email** jika diminta
5. **Login** ke dashboard MongoDB Atlas

### Step 1.2: Buat Cluster Database Gratis

1. **Setelah login**, Anda akan melihat halaman "Deploy your database"
2. **Klik "Create"** pada pilihan **M0 (FREE)**
3. **Pilih Cloud Provider**: 
   - Provider: **AWS** (recommended)
   - Region: **Singapore (ap-southeast-1)** (terdekat dengan Indonesia)
4. **Cluster Name**: Ganti menjadi `koperasi-sembako`
5. **Klik "Create Deployment"**
6. **Tunggu 3-5 menit** sampai cluster selesai dibuat

### Step 1.3: Buat Database User (Username & Password)

1. **Setelah cluster selesai**, akan muncul popup "Security Quickstart"
2. **Di bagian "How would you like to authenticate your connection?"**:
   - Pilih **"Username and Password"**
   - Username: `admin`
   - Password: **Klik "Autogenerate Secure Password"** 
   - **PENTING**: Copy dan simpan password ini! Contoh: `MySecurePass123`
3. **Klik "Create User"**

### Step 1.4: Setup Network Access (Izin IP)

1. **Di bagian "Where would you like to connect from?"**:
   - Pilih **"My Local Environment"**
   - Klik **"Add My Current IP Address"**
2. **Tambah akses untuk semua IP**:
   - Klik **"Add a Different IP Address"**
   - IP Address: `0.0.0.0/0`
   - Description: `Allow all IPs for deployment`
   - Klik **"Add Entry"**
3. **Klik "Finish and Close"**

### Step 1.5: Dapatkan Connection String

1. **Klik "Connect"** pada cluster Anda
2. **Pilih "Drivers"**
3. **Driver**: Node.js, **Version**: 6.7 or later
4. **Copy connection string**:
   ```
   mongodb+srv://admin:<password>@koperasi-sembako.xxxxx.mongodb.net/?retryWrites=true&w=majority
   ```
5. **Ganti `<password>`** dengan password yang tadi disimpan
6. **Tambahkan nama database** di akhir: `/koperasi_sembako`

**Contoh Connection String Final**:
```
mongodb+srv://admin:MySecurePass123@koperasi-sembako.abc123.mongodb.net/koperasi_sembako?retryWrites=true&w=majority
```

**✅ MongoDB Atlas Setup Selesai!**

---

## 🚀 BAGIAN 2: DEPLOY KE RAILWAY (10 menit)

### Step 2.1: Daftar Railway

1. **Buka browser** dan kunjungi: https://railway.app
2. **Klik "Login"** di kanan atas
3. **Pilih "Login with GitHub"**
4. **Authorize Railway** untuk mengakses GitHub Anda
5. **Selesaikan profil** jika diminta

### Step 2.2: Deploy Project dari GitHub

1. **Di Railway Dashboard**, klik **"New Project"**
2. **Pilih "Deploy from GitHub repo"**
3. **Pilih repository**: `koperasi-sembako-platform`
4. **Railway akan otomatis**:
   - Detect Laravel project
   - Mulai build process
   - Assign random URL

### Step 2.3: Tunggu Build Pertama

1. **Klik project** yang baru dibuat
2. **Klik tab "Deployments"**
3. **Tunggu build selesai** (3-5 menit)
4. **Status akan berubah**:
   - 🟡 Building → 🔴 Failed (normal, karena belum ada environment)

### Step 2.4: Set Environment Variables

1. **Klik tab "Variables"** di Railway dashboard
2. **Klik "New Variable"** dan tambahkan satu per satu:

#### 🔑 WAJIB - Application Settings:
```env
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_URL=https://koperasi-sembako-production.up.railway.app
```

#### 🔑 WAJIB - Database MongoDB:
```env
DB_CONNECTION=mongodb
DB_DSN=mongodb+srv://admin:MySecurePass123@koperasi-sembako.abc123.mongodb.net/koperasi_sembako?retryWrites=true&w=majority
```
> ⚠️ **Ganti dengan connection string Anda sendiri!**

#### 🔑 WAJIB - Session & Cache:
```env
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

#### 🔑 WAJIB - File Storage:
```env
FILESYSTEM_DISK=public
```

#### 🔑 WAJIB - Logging:
```env
LOG_CHANNEL=stack
LOG_LEVEL=error
```

#### 🔑 WAJIB - Mail (untuk notifikasi):
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@koperasi-sembako.com
MAIL_FROM_NAME=Koperasi Sembako
```

### Step 2.5: Generate APP_KEY

1. **Di komputer lokal**, buka terminal/command prompt
2. **Masuk ke folder project**:
   ```bash
   cd path/to/koperasi-sembako-platform
   ```
3. **Generate key**:
   ```bash
   php artisan key:generate --show
   ```
4. **Copy hasil output** (contoh: `base64:abc123def456...`)
5. **Tambahkan ke Railway Variables**:
   ```env
   APP_KEY=base64:abc123def456...
   ```

### Step 2.6: Deploy Ulang

1. **Klik tab "Deployments"**
2. **Klik "Deploy"** atau tunggu auto-deploy
3. **Tunggu build selesai** (3-5 menit)
4. **Status akan berubah**: 🟡 Building → 🟢 Success

### Step 2.7: Dapatkan URL Aplikasi

1. **Klik tab "Settings"**
2. **Di bagian "Domains"**, Anda akan melihat URL seperti:
   ```
   https://koperasi-sembako-production.up.railway.app
   ```
3. **Update APP_URL** di Variables dengan URL ini
4. **Deploy ulang** jika perlu

**✅ Railway Deploy Selesai!**

---

## 🧪 BAGIAN 3: TESTING APLIKASI (5 menit)

### Step 3.1: Test Homepage

1. **Buka URL aplikasi** di browser
2. **Pastikan halaman loading** tanpa error
3. **Cek elemen**:
   - Header dengan logo
   - Banner hero
   - Daftar produk
   - Footer

### Step 3.2: Test Register & Login

1. **Klik "Daftar"** di header
2. **Isi form registrasi**:
   - Nama: Test User
   - Email: test@example.com
   - Password: password123
3. **Submit** dan pastikan berhasil
4. **Test login** dengan akun yang baru dibuat

### Step 3.3: Test Fitur Utama

1. **Test Add to Cart**:
   - Klik produk → Add to Cart
   - Cek cart badge bertambah
2. **Test Checkout**:
   - Masuk ke cart → Checkout
   - Isi alamat pengiriman
3. **Test Seller Dashboard**:
   - Login dengan: `admin@koperasisembako.id` / `password`
   - Cek dashboard analytics
   - Test tambah produk

### Step 3.4: Test Database Connection

1. **Buka MongoDB Atlas Dashboard**
2. **Klik "Browse Collections"**
3. **Pastikan ada data**:
   - Database: `koperasi_sembako`
   - Collections: `users`, `products`, `orders`, dll

**✅ Testing Selesai!**

---

## 🎛️ BAGIAN 4: KONFIGURASI TAMBAHAN (Opsional)

### Custom Domain (Gratis)

1. **Di Railway Settings → Domains**
2. **Klik "Custom Domain"**
3. **Masukkan domain** (jika punya)
4. **Update DNS** sesuai instruksi

### Environment Production Optimization

Tambahkan variables berikut untuk optimasi:

```env
# Optimasi Performance
BCRYPT_ROUNDS=10
SESSION_LIFETIME=120

# Optimasi Cache
CACHE_PREFIX=koperasi_

# Optimasi Database
DB_TIMEOUT=30
```

---

## 📊 BAGIAN 5: MONITORING & MAINTENANCE

### Railway Dashboard Monitoring

1. **Metrics Tab**: Lihat CPU, Memory, Network usage
2. **Logs Tab**: Monitor error logs real-time
3. **Usage Tab**: Track $5 credit monthly

### MongoDB Atlas Monitoring

1. **Metrics Tab**: Database operations, connections
2. **Performance Advisor**: Query optimization tips
3. **Alerts**: Setup alerts untuk 80% storage usage

---

## 🔧 TROUBLESHOOTING UMUM

### ❌ Build Failed - Missing APP_KEY

**Error**: `No application encryption key has been specified`

**Solusi**:
1. Generate APP_KEY: `php artisan key:generate --show`
2. Tambahkan ke Railway Variables
3. Deploy ulang

### ❌ Database Connection Failed

**Error**: `Connection refused` atau `Authentication failed`

**Solusi**:
1. Cek DB_DSN format benar
2. Pastikan password tidak ada karakter khusus
3. Cek Network Access di MongoDB Atlas: 0.0.0.0/0
4. Cek Database User permissions

### ❌ 500 Internal Server Error

**Solusi**:
1. Set `APP_DEBUG=true` sementara
2. Cek Logs di Railway Dashboard
3. Pastikan semua required variables sudah diset
4. Cek file permissions

### ❌ Assets Not Loading (CSS/JS)

**Solusi**:
1. Pastikan `APP_URL` sesuai dengan domain Railway
2. Run `npm run build` di local, commit, push
3. Cek `FILESYSTEM_DISK=public`

---

## 💰 ESTIMASI USAGE & BIAYA

### Railway ($5 Credit/Bulan)

| Metric | Limit | Estimasi Usage |
|--------|-------|----------------|
| **Uptime** | 24/7 | 720 jam/bulan |
| **Memory** | 512MB | ~200MB average |
| **CPU** | Shared | Low usage |
| **Network** | Unlimited | ~10GB/bulan |

### MongoDB Atlas (512MB Gratis)

| Metric | Limit | Estimasi Usage |
|--------|-------|----------------|
| **Storage** | 512MB | ~100MB (10K products) |
| **Operations** | Unlimited | ~1M ops/bulan |
| **Network** | 10GB/bulan | ~2GB actual |

**💡 Kapasitas**: Cukup untuk 1000+ users, 10K+ products, 5K+ orders/bulan

---

## 🎉 SELESAI! APLIKASI SUDAH LIVE

### 🌐 URL Aplikasi Anda:
```
https://your-app-name.up.railway.app
```

### 🔐 Akun Default:
- **Seller**: `admin@koperasisembako.id` / `password`
- **Customer**: Daftar baru di halaman register

### 📱 Fitur yang Bisa Digunakan:
- ✅ Belanja online lengkap
- ✅ Dashboard seller dengan analytics
- ✅ Sistem notifikasi real-time
- ✅ Program loyalitas poin
- ✅ Review & rating produk
- ✅ Kupon diskon
- ✅ AI support widget (jika API key diset)

### 🔄 Update Aplikasi:
```bash
# Setiap ada perubahan code:
git add .
git commit -m "Update fitur baru"
git push origin main

# Railway akan auto-deploy dalam 2-3 menit
```

---

## 📞 SUPPORT & BANTUAN

### Jika Ada Masalah:

1. **Cek Railway Logs**: Dashboard → Logs tab
2. **Cek MongoDB Metrics**: Atlas Dashboard → Metrics
3. **Community Support**:
   - Railway Discord: https://discord.gg/railway
   - MongoDB Community: https://community.mongodb.com
4. **Documentation**:
   - Railway Docs: https://docs.railway.app
   - Laravel Docs: https://laravel.com/docs

---

<div align="center">

## 🎊 SELAMAT! 

**Aplikasi E-commerce Koperasi Sembako Anda sudah LIVE di internet!**

**Total Biaya: $0/bulan** 💰  
**Waktu Deploy: ~30 menit** ⏱️  
**Kapasitas: 1000+ users** 👥  

</div>

---

**📝 Catatan**: Simpan file ini sebagai referensi untuk deploy ulang atau troubleshooting di masa depan.