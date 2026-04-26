# ⚡ QUICK DEPLOY - Ringkasan Cepat

> **Deploy dalam 20 menit - Copy paste langsung!**

---

## 🚀 LANGKAH CEPAT

### 1. MongoDB Atlas (5 menit)
1. Daftar: https://cloud.mongodb.com
2. Create M0 cluster → Singapore
3. User: `admin` / generate password
4. Network: Allow 0.0.0.0/0
5. Copy connection string

### 2. Railway (10 menit)
1. Login: https://railway.app (dengan GitHub)
2. New Project → Deploy from GitHub repo
3. Pilih: `koperasi-sembako-platform`
4. Set environment variables (lihat di bawah)
5. Deploy otomatis

### 3. Testing (5 menit)
1. Buka URL Railway
2. Test register/login
3. Test add to cart
4. Done! 🎉

---

## 📋 ENVIRONMENT VARIABLES - COPY PASTE

```env
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-url.up.railway.app
APP_KEY=GENERATE_WITH_ARTISAN

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
php artisan key:generate --show
```

---

## 🔧 JIKA ERROR

| Error | Solusi |
|-------|--------|
| No encryption key | Generate `APP_KEY` |
| Database connection | Cek `DB_DSN` format |
| 500 error | Set `APP_DEBUG=true`, cek logs |
| Assets 404 | Update `APP_URL` |

---

## 📚 DOKUMENTASI LENGKAP

- **Step-by-step detail**: `DEPLOY-STEP-BY-STEP.md`
- **Environment variables**: `ENVIRONMENT-VARIABLES.md`  
- **Troubleshooting**: `TROUBLESHOOTING-DEPLOY.md`

---

## 🎯 HASIL AKHIR

✅ **Website live** di internet  
✅ **Database MongoDB** cloud  
✅ **Biaya**: $0/bulan  
✅ **Kapasitas**: 1000+ users  

**URL**: https://your-app.up.railway.app  
**Admin**: admin@koperasisembako.id / password