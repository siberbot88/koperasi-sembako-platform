# 🔧 TROUBLESHOOTING DEPLOY - Solusi Masalah Umum

> **Panduan mengatasi error yang sering terjadi saat deploy ke Railway + MongoDB Atlas**

---

## 🚨 ERROR PALING SERING

### ❌ 1. "No application encryption key has been specified"

**Penyebab**: APP_KEY belum di-set atau format salah

**Solusi**:
```bash
# 1. Di terminal lokal, generate key:
php artisan key:generate --show

# 2. Copy hasil output (contoh: base64:abc123...)
# 3. Tambahkan ke Railway Variables:
APP_KEY=base64:abc123def456...

# 4. Deploy ulang
```

**Cek**: Pastikan APP_KEY dimulai dengan `base64:`

---

### ❌ 2. "Connection could not be established with host"

**Penyebab**: Database MongoDB tidak bisa diakses

**Solusi Step-by-Step**:

1. **Cek MongoDB Atlas Network Access**:
   - Login ke MongoDB Atlas
   - Network Access → IP Access List
   - Pastikan ada entry: `0.0.0.0/0` (Allow access from anywhere)

2. **Cek Database User**:
   - Database Access → Database Users
   - Pastikan user `admin` ada dan aktif
   - Pastikan password benar

3. **Cek Format DB_DSN**:
   ```env
   # Format yang BENAR:
   DB_DSN=mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako?retryWrites=true&w=majority
   
   # Ganti:
   # - PASSWORD dengan password sebenarnya
   # - cluster dengan nama cluster Anda
   # - Pastikan ada /koperasi_sembako
   ```

4. **Test Connection String**:
   - Copy connection string
   - Test di MongoDB Compass atau mongosh

---

### ❌ 3. "Class 'MongoDB\Laravel\Eloquent\Model' not found"

**Penyebab**: MongoDB package tidak terinstall

**Solusi**:
```bash
# 1. Di terminal lokal:
composer require mongodb/laravel-mongodb

# 2. Commit dan push:
git add composer.json composer.lock
git commit -m "Add MongoDB package"
git push origin main

# 3. Railway akan auto-deploy
```

---

### ❌ 4. "500 Internal Server Error" (Halaman Putih)

**Penyebab**: Multiple kemungkinan

**Solusi Debugging**:

1. **Enable Debug Mode**:
   ```env
   APP_DEBUG=true
   LOG_LEVEL=debug
   ```

2. **Cek Railway Logs**:
   - Railway Dashboard → Logs tab
   - Lihat error message detail

3. **Common Fixes**:
   ```env
   # Pastikan semua ini ada:
   SESSION_DRIVER=database
   CACHE_STORE=database
   FILESYSTEM_DISK=public
   MAIL_MAILER=log
   ```

4. **Setelah fix, kembalikan**:
   ```env
   APP_DEBUG=false
   LOG_LEVEL=error
   ```

---

### ❌ 5. "Storage disk [public] not configured"

**Penyebab**: Filesystem tidak dikonfigurasi

**Solusi**:
```env
FILESYSTEM_DISK=public
```

**Jika masih error**, tambahkan:
```env
FILESYSTEM_CLOUD=public
```

---

### ❌ 6. "Session store not configured"

**Penyebab**: Session driver tidak di-set

**Solusi**:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

### ❌ 7. "CSRF token mismatch"

**Penyebab**: Session tidak persistent atau domain tidak match

**Solusi**:
```env
# Pastikan APP_URL sesuai dengan domain Railway:
APP_URL=https://your-actual-railway-domain.up.railway.app

# Tambahkan:
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
```

---

## 🔍 BUILD ERRORS

### ❌ 8. "Build failed: npm run build"

**Penyebab**: Node.js dependencies atau build script error

**Solusi**:
```bash
# 1. Di terminal lokal, test build:
npm install
npm run build

# 2. Jika error, fix dulu, lalu:
git add .
git commit -m "Fix build issues"
git push origin main
```

**Common npm issues**:
- Node version tidak compatible
- Missing dependencies
- Vite config error

---

### ❌ 9. "Build failed: composer install"

**Penyebab**: PHP dependencies error

**Solusi**:
```bash
# 1. Cek composer.json requirements
# 2. Update jika perlu:
composer update

# 3. Commit:
git add composer.lock
git commit -m "Update dependencies"
git push origin main
```

---

## 🌐 RUNTIME ERRORS

### ❌ 10. "Assets not loading (CSS/JS 404)"

**Penyebab**: Asset path tidak benar

**Solusi**:
```bash
# 1. Build assets lokal:
npm run build

# 2. Commit hasil build:
git add public/build
git commit -m "Add built assets"
git push origin main

# 3. Pastikan APP_URL benar di Railway
```

---

### ❌ 11. "File upload not working"

**Penyebab**: Storage tidak dikonfigurasi

**Solusi**:
```env
FILESYSTEM_DISK=public
```

**Jika masih error**, cek:
- Folder `storage/app/public` ada
- Symlink `public/storage` ada
- Permissions correct

---

### ❌ 12. "Queue jobs not processing"

**Penyebab**: Queue driver tidak dikonfigurasi

**Solusi**:
```env
QUEUE_CONNECTION=database
```

**Untuk production**, consider:
```env
QUEUE_CONNECTION=redis  # Jika ada Redis
```

---

## 🗄️ DATABASE ERRORS

### ❌ 13. "Collection doesn't exist"

**Penyebab**: Database kosong, belum ada collections

**Solusi**:
```bash
# 1. Akses aplikasi dan register user baru
# 2. Atau run seeder (jika ada):
php artisan db:seed

# 3. Cek di MongoDB Atlas → Browse Collections
```

---

### ❌ 14. "Authentication failed"

**Penyebab**: Username/password MongoDB salah

**Solusi**:
1. **Reset password di MongoDB Atlas**:
   - Database Access → Database Users
   - Edit user → Reset password
   - Update DB_DSN dengan password baru

2. **Atau buat user baru**:
   - Add New Database User
   - Username: `admin2`
   - Generate password
   - Update DB_DSN

---

### ❌ 15. "Connection timeout"

**Penyebab**: Network atau cluster issue

**Solusi**:
1. **Cek cluster status** di MongoDB Atlas
2. **Cek region**: Pilih yang terdekat (Singapore)
3. **Tambahkan timeout** di connection string:
   ```env
   DB_DSN=mongodb+srv://admin:pass@cluster.mongodb.net/db?retryWrites=true&w=majority&connectTimeoutMS=30000&socketTimeoutMS=30000
   ```

---

## 🔄 DEPLOYMENT ISSUES

### ❌ 16. "Deploy stuck at building"

**Penyebab**: Build process hang

**Solusi**:
1. **Cancel deploy** di Railway
2. **Cek build logs** untuk error
3. **Fix issue** dan push ulang
4. **Atau restart service**:
   - Railway Dashboard → Settings → Restart

---

### ❌ 17. "Out of memory during build"

**Penyebab**: Build process butuh memory besar

**Solusi**:
```bash
# 1. Optimize package.json:
npm prune

# 2. Reduce build size:
# Edit vite.config.js untuk optimize

# 3. Atau upgrade Railway plan (jika perlu)
```

---

### ❌ 18. "Domain not accessible"

**Penyebab**: DNS atau Railway domain issue

**Solusi**:
1. **Cek Railway domain**:
   - Settings → Domains
   - Generate new domain jika perlu

2. **Update APP_URL**:
   ```env
   APP_URL=https://new-domain.up.railway.app
   ```

3. **Clear cache**:
   - Restart Railway service

---

## 🛠️ DEBUGGING TOOLS

### 1. Railway Logs
```
Railway Dashboard → Logs tab
- Real-time error monitoring
- Filter by error level
- Search specific errors
```

### 2. MongoDB Atlas Logs
```
Atlas Dashboard → Metrics
- Connection attempts
- Query performance
- Error rates
```

### 3. Local Testing
```bash
# Test dengan production config:
cp .env.production .env
php artisan config:clear
php artisan serve

# Test database connection:
php artisan tinker
>>> DB::connection()->getMongoDB()->listCollections()
```

---

## 📋 DEBUGGING CHECKLIST

Jika aplikasi tidak jalan, cek satu per satu:

### ✅ Environment Variables:
- [ ] APP_KEY ada dan format benar
- [ ] DB_DSN format benar dan password benar
- [ ] APP_URL sesuai dengan Railway domain
- [ ] SESSION_DRIVER=database
- [ ] CACHE_STORE=database
- [ ] FILESYSTEM_DISK=public

### ✅ MongoDB Atlas:
- [ ] Cluster aktif dan running
- [ ] Database user ada dan password benar
- [ ] Network access: 0.0.0.0/0
- [ ] Connection string format benar

### ✅ Railway:
- [ ] Build success (hijau)
- [ ] Service running
- [ ] Domain accessible
- [ ] Logs tidak ada error critical

### ✅ Code:
- [ ] composer.json dependencies complete
- [ ] package.json dependencies complete
- [ ] No syntax errors
- [ ] Git push successful

---

## 🆘 LAST RESORT SOLUTIONS

### Jika Semua Gagal:

1. **Deploy Ulang dari Awal**:
   ```bash
   # 1. Delete Railway project
   # 2. Create new project
   # 3. Deploy from GitHub repo
   # 4. Set environment variables lagi
   ```

2. **Reset MongoDB Cluster**:
   ```bash
   # 1. Delete cluster di Atlas
   # 2. Create new M0 cluster
   # 3. Setup user dan network access
   # 4. Update DB_DSN
   ```

3. **Coba Platform Lain**:
   - Heroku (jika Railway tidak work)
   - Render (alternatif lain)
   - Vercel (untuk static parts)

---

## 📞 BANTUAN LEBIH LANJUT

### Community Support:
- **Railway Discord**: https://discord.gg/railway
- **MongoDB Community**: https://community.mongodb.com
- **Laravel Discord**: https://discord.gg/laravel

### Documentation:
- **Railway Docs**: https://docs.railway.app
- **MongoDB Atlas Docs**: https://docs.atlas.mongodb.com
- **Laravel Deployment**: https://laravel.com/docs/deployment

---

<div align="center">

**💡 Tips**: Bookmark halaman ini untuk troubleshooting cepat!

**🔄 Update**: File ini akan diupdate seiring ditemukan masalah baru.

</div>