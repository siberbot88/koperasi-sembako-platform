# 🌐 Deploy ke Heroku via Web Dashboard (Tanpa CLI)

> **Cara termudah**: Deploy langsung dari browser!  
> **Waktu**: 15 menit  
> **Biaya**: $0/bulan

---

## 🎯 LANGKAH 1: Daftar Heroku (2 menit)

1. **Kunjungi**: https://signup.heroku.com
2. **Isi form**:
   - First name
   - Last name
   - Email
   - Country: Indonesia
   - Role: Student/Hobbyist
   - Primary language: PHP
3. **Klik "Create Free Account"**
4. **Cek email** → Klik link verifikasi
5. **Set password** → Login

---

## 🚀 LANGKAH 2: Create New App (3 menit)

1. **Dashboard Heroku**: https://dashboard.heroku.com
2. **Klik "New"** (kanan atas) → **"Create new app"**
3. **App name**: `koperasi-sembako` (atau nama lain jika sudah dipakai)
4. **Region**: `United States` atau `Europe` (pilih yang terdekat)
5. **Klik "Create app"**

---

## 🔗 LANGKAH 3: Connect GitHub (2 menit)

1. **Di halaman app** → Tab **"Deploy"**
2. **Deployment method** → Pilih **"GitHub"**
3. **Klik "Connect to GitHub"**
4. **Authorize Heroku** (jika diminta)
5. **Search repository**: `koperasi-sembako-platform`
6. **Klik "Connect"**

---

## 🔧 LANGKAH 4: Configure Buildpacks (2 menit)

1. **Tab "Settings"**
2. **Scroll ke "Buildpacks"**
3. **Klik "Add buildpack"**
4. **Pilih "php"** → Klik "Save changes"
5. **Klik "Add buildpack"** lagi
6. **Pilih "nodejs"** → Klik "Save changes"

**Urutan harus**:
```
1. heroku/php
2. heroku/nodejs
```

Jika salah urutan, drag & drop untuk ubah urutan.

---

## 🔑 LANGKAH 5: Set Environment Variables (5 menit)

1. **Tab "Settings"**
2. **Scroll ke "Config Vars"**
3. **Klik "Reveal Config Vars"**
4. **Tambahkan satu per satu**:

### Generate APP_KEY Dulu:
Di terminal lokal:
```bash
php artisan key:generate --show
```
Copy hasilnya (contoh: `base64:abc123...`)

### Tambahkan Config Vars:

| KEY | VALUE |
|-----|-------|
| `APP_NAME` | `Koperasi Sembako` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `base64:PASTE_YOUR_KEY` |
| `APP_URL` | `https://koperasi-sembako.herokuapp.com` |
| `DB_CONNECTION` | `mongodb` |
| `DB_DSN` | `mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako` |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `FILESYSTEM_DISK` | `public` |
| `LOG_CHANNEL` | `stack` |
| `LOG_LEVEL` | `error` |
| `MAIL_MAILER` | `log` |
| `MAIL_FROM_ADDRESS` | `noreply@koperasi-sembako.com` |
| `MAIL_FROM_NAME` | `Koperasi Sembako` |

**Ganti**:
- `PASTE_YOUR_KEY` dengan hasil `php artisan key:generate --show`
- `PASSWORD` dengan password MongoDB Atlas Anda
- `koperasi-sembako` di APP_URL dengan nama app Anda

**Cara menambahkan**:
1. Ketik KEY di kolom kiri
2. Ketik VALUE di kolom kanan
3. Klik "Add"
4. Ulangi untuk semua variables

---

## 🚀 LANGKAH 6: Deploy! (1 menit)

1. **Tab "Deploy"**
2. **Scroll ke "Manual deploy"**
3. **Branch**: `main`
4. **Klik "Deploy Branch"**

**Tunggu 5-10 menit** untuk build selesai.

Progress akan tampil:
```
-----> Building on the Heroku-22 stack
-----> Using buildpack: heroku/php
-----> PHP app detected
-----> Installing platform packages...
-----> Installing dependencies...
-----> Discovering process types
-----> Compressing...
-----> Launching...
```

Jika berhasil:
```
✅ Your app was successfully deployed.
```

---

## 🌐 LANGKAH 7: Open App (1 menit)

1. **Klik "View"** atau **"Open app"** (kanan atas)
2. **Browser akan membuka** aplikasi Anda!

**URL**: `https://koperasi-sembako.herokuapp.com`

---

## 🔄 LANGKAH 8: Enable Auto Deploy (Opsional)

Agar setiap push ke GitHub otomatis deploy:

1. **Tab "Deploy"**
2. **Scroll ke "Automatic deploys"**
3. **Branch**: `main`
4. **Klik "Enable Automatic Deploys"**

Sekarang setiap `git push origin main` akan auto-deploy!

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
   - Tab "Settings" → Config Vars
   - Edit `DB_DSN` dengan connection string baru

---

## 📊 LANGKAH 9: View Logs (Untuk Debugging)

1. **Tab "More"** (kanan atas) → **"View logs"**
2. **Atau klik "Open app"** → Jika error, logs akan tampil

**Logs real-time** akan tampil di browser.

---

## 🔧 TROUBLESHOOTING

### ❌ Build Failed

**Cek logs**:
1. Tab "Activity" → Klik build yang failed
2. Lihat error message

**Common issues**:
- **Composer error**: Cek `composer.json` syntax
- **NPM error**: Cek `package.json` dependencies
- **Buildpack order**: PHP harus di atas Node.js

### ❌ Application Error (H10)

**Cek Config Vars**:
1. Tab "Settings" → Config Vars
2. Pastikan semua variables ada:
   - `APP_KEY` (harus ada)
   - `DB_DSN` (format benar)
   - `APP_URL` (sesuai dengan domain Heroku)

**Set debug mode**:
1. Edit `APP_DEBUG` → `true`
2. Refresh app
3. Error detail akan tampil
4. Setelah fix, kembalikan ke `false`

### ❌ Database Connection Failed

**Cek MongoDB Atlas**:
1. Cluster running?
2. User credentials benar?
3. Network access: `0.0.0.0/0`?
4. Connection string format benar?

**Test connection**:
1. Tab "More" → "Run console"
2. Ketik: `php artisan tinker`
3. Test: `DB::connection()->getMongoDB()->listCollections()`

---

## 🔄 UPDATE APLIKASI

Setiap kali ada perubahan code:

### Jika Auto Deploy Enabled:
```bash
git add .
git commit -m "Update fitur baru"
git push origin main
```
Heroku akan auto-deploy dalam 5-10 menit.

### Jika Manual Deploy:
1. Push ke GitHub dulu
2. Heroku Dashboard → Tab "Deploy"
3. Klik "Deploy Branch"

---

## 💰 BIAYA & KAPASITAS

### Heroku Free Tier:
- **550-1000 jam/bulan** (cukup untuk 24/7)
- **512MB RAM**
- **Sleep**: Setelah 30 menit idle
- **Wake up**: ~5 detik

### MongoDB Atlas Free:
- **512MB storage**
- **Unlimited operations**

**Total**: **$0/bulan**

---

## 🎯 KELEBIHAN DEPLOY VIA WEB

✅ **Tidak perlu install CLI**  
✅ **Visual interface** lebih mudah  
✅ **Logs di browser** real-time  
✅ **Config Vars** mudah diedit  
✅ **Auto-deploy** dari GitHub  
✅ **Monitoring** built-in  

---

## 📱 HEROKU MOBILE APP (Opsional)

Download Heroku app untuk monitoring:
- **iOS**: https://apps.apple.com/app/heroku/id177400355
- **Android**: https://play.google.com/store/apps/details?id=com.heroku.android

Monitor app dari smartphone!

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

### Keep Dyno Awake:
Gunakan **UptimeRobot** (gratis):
1. Daftar: https://uptimerobot.com
2. Add Monitor → HTTP(s)
3. URL: `https://koperasi-sembako.herokuapp.com`
4. Interval: 25 menit
5. Dyno tidak akan sleep!

### Custom Domain:
1. Tab "Settings" → "Domains"
2. Klik "Add domain"
3. Masukkan domain Anda
4. Update DNS sesuai instruksi

### View Metrics:
1. Tab "Metrics"
2. Lihat:
   - Response time
   - Memory usage
   - Request volume
   - Error rate

---

## 📞 SUPPORT

**Jika ada masalah**:
1. Tab "More" → "View logs"
2. Heroku Dev Center: https://devcenter.heroku.com
3. Heroku Status: https://status.heroku.com

---

**Deploy via web lebih mudah untuk pemula!** 🎯