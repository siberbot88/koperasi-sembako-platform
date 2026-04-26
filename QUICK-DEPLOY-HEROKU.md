# ⚡ Quick Deploy ke Heroku (PALING MUDAH)

## 🚀 5 Langkah Cepat (10 menit)

### 1️⃣ Install Heroku CLI (2 menit)
Download: https://devcenter.heroku.com/articles/heroku-cli  
Install → Restart terminal

### 2️⃣ Login & Create App (2 menit)
```bash
heroku login
heroku create koperasi-sembako
heroku buildpacks:add heroku/php
heroku buildpacks:add heroku/nodejs
```

### 3️⃣ Set Environment Variables (3 menit)
```bash
# Generate APP_KEY
php artisan key:generate --show

# Set variables
heroku config:set APP_KEY="base64:YOUR_KEY"
heroku config:set APP_URL="https://koperasi-sembako.herokuapp.com"
heroku config:set DB_DSN="mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set SESSION_DRIVER=database
heroku config:set CACHE_STORE=database
heroku config:set FILESYSTEM_DISK=public
```

### 4️⃣ Deploy! (3 menit)
```bash
git push heroku main
```

### 5️⃣ Open App
```bash
heroku open
```

**Done! 🎉**

---

## 📋 Environment Variables Lengkap

```bash
heroku config:set APP_NAME="Koperasi Sembako"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="base64:YOUR_GENERATED_KEY"
heroku config:set APP_URL="https://koperasi-sembako.herokuapp.com"
heroku config:set DB_CONNECTION=mongodb
heroku config:set DB_DSN="mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako"
heroku config:set SESSION_DRIVER=database
heroku config:set CACHE_STORE=database
heroku config:set QUEUE_CONNECTION=database
heroku config:set FILESYSTEM_DISK=public
heroku config:set LOG_CHANNEL=stack
heroku config:set LOG_LEVEL=error
heroku config:set MAIL_MAILER=log
heroku config:set MAIL_FROM_ADDRESS="noreply@koperasi-sembako.com"
heroku config:set MAIL_FROM_NAME="Koperasi Sembako"
```

---

## 🔧 Troubleshooting

### Build Failed?
```bash
heroku logs --tail
```

### App Error?
```bash
heroku config:set APP_DEBUG=true
heroku logs --tail
```

### Database Error?
```bash
heroku run php artisan tinker
>>> DB::connection()->getMongoDB()->listCollections()
```

---

## ✅ Hasil Akhir

- **URL**: https://koperasi-sembako.herokuapp.com
- **Biaya**: $0/bulan
- **Uptime**: 550-1000 jam/bulan
- **Auto-deploy**: `git push heroku main`

**Paling mudah & reliable!** 🎯