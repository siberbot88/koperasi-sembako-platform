# 🚀 Deploy ke Render.com - Panduan Lengkap

> **Platform**: Render.com (Lebih mudah dari Railway)  
> **Waktu**: 15-20 menit  
> **Biaya**: $0/bulan (750 jam gratis)

---

## 🎯 Kenapa Render.com?

✅ **Lebih mudah** setup daripada Railway  
✅ **Support PHP native** tanpa kompleksitas  
✅ **750 jam gratis** per bulan  
✅ **Auto-deploy** dari GitHub  
✅ **Dokumentasi jelas** untuk Laravel  

---

## 📋 LANGKAH 1: Persiapan File

### 1.1 Buat render.yaml

File ini sudah dibuat otomatis. Cek di root project.

### 1.2 Buat build script

File `render-build.sh` sudah dibuat otomatis.

---

## 🌐 LANGKAH 2: Setup Render.com

### 2.1 Daftar Render

1. **Kunjungi**: https://render.com
2. **Klik "Get Started"**
3. **Sign up with GitHub** (recommended)
4. **Authorize Render** untuk akses GitHub

### 2.2 Create Web Service

1. **Dashboard** → **"New +"** → **"Web Service"**
2. **Connect repository**: `koperasi-sembako-platform`
3. **Klik "Connect"**

### 2.3 Configure Service

**Basic Settings**:
- **Name**: `koperasi-sembako`
- **Region**: `Singapore` (terdekat)
- **Branch**: `main`
- **Root Directory**: (kosongkan)

**Build Settings**:
- **Runtime**: `PHP`
- **Build Command**: 
  ```bash
  composer install --no-dev --optimize-autoloader && npm install && npm run build
  ```
- **Start Command**:
  ```bash
  php artisan serve --host=0.0.0.0 --port=$PORT
  ```

**Instance Type**:
- **Free** (pilih yang gratis)

### 2.4 Environment Variables

Klik **"Advanced"** → **"Add Environment Variable"**

Tambahkan satu per satu:

```env
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_WITH_ARTISAN
APP_URL=https://koperasi-sembako.onrender.com

DB_CONNECTION=mongodb
DB_DSN=mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako?retryWrites=true&w=majority

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@koperasi-sembako.com
MAIL_FROM_NAME=Koperasi Sembako
```

**Generate APP_KEY**:
```bash
# Di terminal lokal:
php artisan key:generate --show
# Copy hasilnya
```

### 2.5 Deploy

1. **Klik "Create Web Service"**
2. **Tunggu build** (5-10 menit)
3. **Monitor logs** di dashboard

---

## 🗄️ LANGKAH 3: MongoDB Atlas (Jika Belum)

Jika belum setup MongoDB Atlas, ikuti ini:

1. **Daftar**: https://cloud.mongodb.com
2. **Create M0 Cluster** (gratis) → Singapore
3. **Database User**: `admin` / generate password
4. **Network Access**: `0.0.0.0/0` (allow all)
5. **Connection String**: 
   ```
   mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako
   ```
6. **Update DB_DSN** di Render environment variables

---

## ✅ LANGKAH 4: Testing

### 4.1 Cek URL

Setelah deploy selesai:
- **URL**: `https://koperasi-sembako.onrender.com`
- **Klik URL** untuk test

### 4.2 Test Fitur

1. **Homepage**: Harus load tanpa error
2. **Register**: Buat akun baru
3. **Login**: Test login
4. **Add to Cart**: Test fitur cart
5. **Seller Dashboard**: Login dengan `admin@koperasisembako.id` / `password`

---

## 🔧 TROUBLESHOOTING

### ❌ Build Failed

**Cek logs** di Render Dashboard → Logs

**Common issues**:
1. **Composer error**: Cek `composer.json` syntax
2. **NPM error**: Cek `package.json` dependencies
3. **MongoDB extension**: Render auto-install PHP extensions

### ❌ 500 Error

**Set debug mode**:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

**Cek logs** untuk error detail

**Kembalikan setelah fix**:
```env
APP_DEBUG=false
LOG_LEVEL=error
```

### ❌ Database Connection Failed

1. **Cek DB_DSN** format benar
2. **Cek MongoDB Atlas**:
   - Cluster running
   - User credentials benar
   - Network access: 0.0.0.0/0
3. **Test connection string** di MongoDB Compass

---

## 💰 BIAYA & KAPASITAS

### Render Free Tier:
- **750 jam/bulan** (cukup untuk 24/7 dengan 1 service)
- **512MB RAM**
- **0.1 CPU**
- **Bandwidth**: Unlimited
- **Sleep**: Setelah 15 menit idle (spin up ~30 detik)

### MongoDB Atlas Free:
- **512MB storage**
- **Unlimited operations**
- **10GB network/month**

**Total**: **$0/bulan** untuk traffic rendah-menengah

---

## 🎯 KELEBIHAN RENDER

✅ **Mudah setup** - Tidak perlu nixpacks/Docker  
✅ **PHP native** - Auto-detect Laravel  
✅ **Auto SSL** - HTTPS gratis  
✅ **Custom domain** - Gratis  
✅ **Auto-deploy** - Push ke GitHub = auto deploy  
✅ **Logs real-time** - Easy debugging  

---

## 🔄 UPDATE APLIKASI

Setiap kali ada perubahan:

```bash
git add .
git commit -m "Update fitur baru"
git push origin main
```

Render akan **auto-deploy** dalam 5-10 menit.

---

## 📞 SUPPORT

**Jika ada masalah**:
1. Cek Render Logs
2. Cek MongoDB Atlas Metrics
3. Render Community: https://community.render.com
4. Render Docs: https://render.com/docs

---

## 🎉 SELESAI!

Aplikasi Anda sekarang live di:
```
https://koperasi-sembako.onrender.com
```

**Akun default**:
- **Seller**: `admin@koperasisembako.id` / `password`
- **Customer**: Daftar baru di halaman register

**Selamat! Aplikasi e-commerce Anda sudah online!** 🚀