# 📋 Deploy Checklist

## ✅ Persiapan Database
- [ ] Buat MongoDB Atlas cluster (gratis)
- [ ] Setup database user dan password
- [ ] Whitelist IP address (0.0.0.0/0)
- [ ] Copy connection string

## ✅ Persiapan Aplikasi
- [ ] Update composer.json untuk production
- [ ] Set APP_ENV=production
- [ ] Set APP_DEBUG=false
- [ ] Generate APP_KEY baru
- [ ] Update APP_URL dengan domain production
- [ ] Set DB_CONNECTION=mongodb
- [ ] Set DB_DSN dengan connection string MongoDB

## ✅ File Konfigurasi
- [ ] Procfile dibuat
- [ ] railway.json atau nixpacks.toml (untuk Railway)
- [ ] .env.production template

## ✅ Optimisasi Production
- [ ] composer install --no-dev --optimize-autoloader
- [ ] npm run build
- [ ] php artisan config:cache
- [ ] php artisan route:cache
- [ ] php artisan view:cache

## ✅ Testing
- [ ] Test koneksi database
- [ ] Test fitur utama (login, register, CRUD)
- [ ] Test upload file
- [ ] Test notifikasi

## 🔧 Commands untuk Testing Lokal
```bash
# Test dengan environment production
cp .env.production .env
php artisan config:clear
php artisan cache:clear
php artisan serve

# Kembali ke development
cp .env.example .env
php artisan key:generate
```

## 🌐 Platform Gratis Terbaik untuk Laravel

### 1. Railway (Recommended) ⭐⭐⭐⭐⭐
- ✅ Support PHP/Laravel native
- ✅ Easy deployment
- ✅ $5 credit gratis per bulan
- ✅ Auto-scaling
- ✅ Custom domain gratis

### 2. Heroku ⭐⭐⭐⭐
- ✅ Mature platform
- ✅ Good documentation
- ✅ 550-1000 dyno hours gratis
- ❌ Sleep mode setelah 30 menit idle

### 3. Render ⭐⭐⭐
- ✅ Modern platform
- ✅ Static site gratis unlimited
- ✅ Web service gratis 750 jam/bulan
- ❌ Spin down setelah 15 menit idle

## 💡 Tips Optimisasi

### Performance
- Gunakan Redis untuk cache (upgrade plan)
- Optimize gambar sebelum upload
- Enable gzip compression
- Minify CSS/JS

### Security
- Set APP_DEBUG=false di production
- Use HTTPS (otomatis di platform modern)
- Set secure session cookies
- Validate semua input

### Monitoring
- Setup error logging
- Monitor database usage
- Track response time
- Setup uptime monitoring (UptimeRobot gratis)