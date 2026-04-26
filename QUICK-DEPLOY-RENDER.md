# ⚡ Quick Deploy ke Render.com

## 🚀 3 Langkah Mudah (15 menit)

### 1️⃣ Daftar Render (2 menit)
1. Kunjungi: https://render.com
2. Sign up with GitHub
3. Authorize Render

### 2️⃣ Create Web Service (5 menit)
1. Dashboard → "New +" → "Web Service"
2. Connect repo: `koperasi-sembako-platform`
3. Settings:
   - **Runtime**: PHP
   - **Build Command**: 
     ```
     composer install --no-dev --optimize-autoloader && npm install && npm run build
     ```
   - **Start Command**: 
     ```
     php artisan serve --host=0.0.0.0 --port=$PORT
     ```
   - **Instance**: Free

### 3️⃣ Set Environment Variables (5 menit)

Klik "Advanced" → Add Environment Variable:

```env
APP_KEY=GENERATE_WITH_ARTISAN
APP_URL=https://your-app.onrender.com
DB_DSN=mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako
```

**Generate APP_KEY**:
```bash
php artisan key:generate --show
```

### 4️⃣ Deploy!
Klik "Create Web Service" → Tunggu 10 menit → Done! 🎉

---

## 📋 Environment Variables Lengkap

Copy-paste ke Render:

```
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY
APP_URL=https://your-app.onrender.com
DB_CONNECTION=mongodb
DB_DSN=mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako
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

---

## ✅ Hasil Akhir

- **URL**: https://koperasi-sembako.onrender.com
- **Biaya**: $0/bulan
- **Uptime**: 750 jam/bulan (gratis)
- **Auto-deploy**: Push ke GitHub = auto update

**Lebih mudah dari Railway!** 🎯