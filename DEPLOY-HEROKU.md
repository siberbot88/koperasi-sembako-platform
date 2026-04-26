# 🚀 Deploy ke Heroku - Panduan Lengkap (PALING MUDAH)

> **Platform**: Heroku (Paling reliable untuk Laravel)  
> **Waktu**: 10-15 menit  
> **Biaya**: $0/bulan (550-1000 jam gratis)  
> **Success Rate**: 99% ✅

---

## 🎯 Kenapa Heroku?

✅ **Paling mature** untuk PHP/Laravel  
✅ **Dokumentasi terlengkap**  
✅ **Auto-detect** Laravel tanpa konfigurasi  
✅ **MongoDB support** built-in  
✅ **CLI powerful** untuk debugging  
✅ **550-1000 jam gratis** per bulan  

---

## 📋 LANGKAH 1: Install Heroku CLI

### Windows:
1. Download: https://devcenter.heroku.com/articles/heroku-cli
2. Install file `.exe` yang didownload
3. Restart terminal/command prompt

### Verify Installation:
```bash
heroku --version
# Output: heroku/8.x.x
```

---

## 🔐 LANGKAH 2: Login Heroku

```bash
heroku login
```

Browser akan terbuka → Klik "Log in" → Done!

---

## 🚀 LANGKAH 3: Create Heroku App

```bash
# Di folder project Anda
cd path/to/koperasi-sembako-platform

# Create app
heroku create koperasi-sembako

# Output: 
# Creating ⬢ koperasi-sembako... done
# https://koperasi-sembako.herokuapp.com/ | https://git.heroku.com/koperasi-sembako.git
```

**Jika nama sudah dipakai**, gunakan nama lain:
```bash
heroku create koperasi-sembako-2024
```

---

## 🔧 LANGKAH 4: Add Buildpacks

```bash
# Add PHP buildpack
heroku buildpacks:add heroku/php

# Add Node.js buildpack (untuk npm build)
heroku buildpacks:add heroku/nodejs

# Verify
heroku buildpacks
# Output:
# 1. heroku/php
# 2. heroku/nodejs
```

---

## 🔑 LANGKAH 5: Set Environment Variables

### Generate APP_KEY:
```bash
php artisan key:generate --show
# Copy hasilnya (contoh: base64:abc123...)
```

### Set Variables:
```bash
# Core App
heroku config:set APP_NAME="Koperasi Sembako"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="base64:PASTE_YOUR_KEY_HERE"
heroku config:set APP_URL="https://koperasi-sembako.herokuapp.com"

# Database MongoDB
heroku config:set DB_CONNECTION=mongodb
heroku config:set DB_DSN="mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako?retryWrites=true&w=majority"

# Session & Cache
heroku config:set SESSION_DRIVER=database
heroku config:set CACHE_STORE=database
heroku config:set QUEUE_CONNECTION=database
heroku config:set FILESYSTEM_DISK=public

# Logging
heroku config:set LOG_CHANNEL=stack
heroku config:set LOG_LEVEL=error

# Mail
heroku config:set MAIL_MAILER=log
heroku config:set MAIL_FROM_ADDRESS="noreply@koperasi-sembako.com"
heroku config:set MAIL_FROM_NAME="Koperasi Sembako"
```

**Ganti**:
- `PASTE_YOUR_KEY_HERE` dengan hasil `php artisan key:generate --show`
- `PASSWORD` dengan password MongoDB Atlas Anda
- `cluster` dengan nama cluster MongoDB Anda

### Verify:
```bash
heroku config
# Akan tampil semua environment variables
```

---

## 📦 LANGKAH 6: Deploy!

```bash
# Push ke Heroku
git push heroku main

# Jika branch Anda bukan 'main', gunakan:
git push heroku master:main
```

**Tunggu 5-10 menit** untuk build selesai.

Output yang diharapkan:
```
remote: -----> Building on the Heroku-22 stack
remote: -----> Using buildpack: heroku/php
remote: -----> PHP app detected
remote: -----> Installing platform packages...
remote: -----> Installing dependencies...
remote: -----> Discovering process types
remote:        Procfile declares types -> web
remote: -----> Compressing...
remote: -----> Launching...
remote:        Released v3
remote:        https://koperasi-sembako.herokuapp.com/ deployed to Heroku
```

---

## 🌐 LANGKAH 7: Open App

```bash
heroku open
```

Browser akan membuka aplikasi Anda!

---

## 🔍 LANGKAH 8: Monitoring & Debugging

### View Logs:
```bash
heroku logs --tail
```

### Check Dyno Status:
```bash
heroku ps
```

### Restart App:
```bash
heroku restart
```

### Run Artisan Commands:
```bash
heroku run php artisan migrate
heroku run php artisan db:seed
heroku run php artisan cache:clear
```

---

## 🗄️ MONGODB ATLAS (Jika Belum Setup)

1. **Daftar**: https://cloud.mongodb.com
2. **Create M0 Cluster** (gratis) → Singapore
3. **Database User**: `admin` / generate password
4. **Network Access**: `0.0.0.0/0` (allow all)
5. **Connection String**: 
   ```
   mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako
   ```
6. **Update di Heroku**:
   ```bash
   heroku config:set DB_DSN="mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako"
   ```

---

## 🔧 TROUBLESHOOTING

### ❌ Build Failed

**Cek logs**:
```bash
heroku logs --tail
```

**Common issues**:
1. **Composer error**: 
   ```bash
   composer install --no-dev
   git add composer.lock
   git commit -m "Update composer.lock"
   git push heroku main
   ```

2. **NPM error**:
   ```bash
   npm install
   npm run build
   git add public/build
   git commit -m "Build assets"
   git push heroku main
   ```

### ❌ Application Error (H10)

**Set debug mode**:
```bash
heroku config:set APP_DEBUG=true
heroku logs --tail
```

**Check**:
- APP_KEY is set
- DB_DSN is correct
- All required env vars are set

### ❌ Database Connection Failed

```bash
# Test connection
heroku run php artisan tinker
>>> DB::connection()->getMongoDB()->listCollections()
```

---

## 💰 BIAYA & KAPASITAS

### Heroku Free Tier:
- **550-1000 jam/bulan** (cukup untuk 24/7 dengan 1 dyno)
- **512MB RAM**
- **Sleep**: Setelah 30 menit idle
- **Wake up**: ~5 detik

### MongoDB Atlas Free:
- **512MB storage**
- **Unlimited operations**

**Total**: **$0/bulan**

---

## 🎯 KELEBIHAN HEROKU

✅ **Paling mudah** untuk Laravel  
✅ **Auto-detect** semua dependencies  
✅ **CLI powerful** untuk debugging  
✅ **Add-ons ecosystem** (Redis, Postgres, dll)  
✅ **Mature platform** (15+ tahun)  
✅ **Best documentation**  

---

## 🔄 UPDATE APLIKASI

Setiap kali ada perubahan:

```bash
git add .
git commit -m "Update fitur baru"
git push heroku main
```

Heroku akan **auto-deploy** dalam 5-10 menit.

---

## 📞 SUPPORT

**Jika ada masalah**:
1. `heroku logs --tail` untuk lihat error
2. Heroku Dev Center: https://devcenter.heroku.com
3. Heroku Community: https://help.heroku.com

---

## 🎉 SELESAI!

Aplikasi Anda sekarang live di:
```
https://koperasi-sembako.herokuapp.com
```

**Akun default**:
- **Seller**: `admin@koperasisembako.id` / `password`
- **Customer**: Daftar baru di halaman register

**Selamat! Aplikasi e-commerce Anda sudah online!** 🚀

---

## 💡 TIPS

### Keep Dyno Awake (Opsional):
Gunakan service gratis seperti:
- **UptimeRobot**: https://uptimerobot.com
- Ping setiap 25 menit untuk prevent sleep

### Custom Domain (Opsional):
```bash
heroku domains:add www.tokosembako.com
# Follow DNS instructions
```

### Scale Dyno (Jika Perlu):
```bash
# Check current
heroku ps

# Scale up (berbayar)
heroku ps:scale web=1:standard-1x
```