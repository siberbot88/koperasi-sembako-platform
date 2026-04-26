# 🆓 Deploy GRATIS - Panduan Lengkap

## 🎯 Target: 100% Gratis Selamanya

### 📊 Kapasitas Gratis:
- **Railway**: $5 credit/bulan (cukup untuk 500+ jam)
- **MongoDB Atlas**: 512MB storage gratis selamanya
- **Total Biaya**: $0 per bulan

---

## 🗄️ LANGKAH 1: Setup MongoDB Atlas (5 menit)

### 1.1 Daftar MongoDB Atlas
```
🌐 Kunjungi: https://www.mongodb.com/cloud/atlas
📧 Klik "Try Free" 
👤 Daftar dengan email/Google
```

### 1.2 Buat Cluster Gratis
```
🏗️ "Build a Database"
💰 Pilih "M0 Sandbox" (FREE FOREVER)
🌏 Region: AWS Singapore (ap-southeast-1)
📝 Cluster Name: koperasi-sembako
⏱️ Tunggu 3-5 menit cluster dibuat
```

### 1.3 Setup Database User
```
🔐 Database Access → "Add New Database User"
👤 Username: admin
🔑 Password: [Generate Secure Password - SIMPAN INI!]
🎭 Role: "Read and write to any database"
✅ Add User
```

### 1.4 Setup Network Access
```
🌐 Network Access → "Add IP Address"
🔓 "Allow access from anywhere" (0.0.0.0/0)
✅ Confirm
```

### 1.5 Get Connection String
```
🔗 Connect → "Drivers" → "Node.js"
📋 Copy connection string:
mongodb+srv://admin:<password>@koperasi-sembako.xxxxx.mongodb.net/?retryWrites=true&w=majority

🔄 Ganti <password> dengan password yang tadi dibuat
📝 Tambahkan database name: /koperasi_sembako
```

**Contoh Final Connection String:**
```
mongodb+srv://admin:MySecurePass123@koperasi-sembako.abc123.mongodb.net/koperasi_sembako?retryWrites=true&w=majority
```

---

## 🚀 LANGKAH 2: Deploy ke Railway (10 menit)

### 2.1 Persiapan Repository
```bash
# Pastikan semua file sudah di-commit
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

### 2.2 Deploy ke Railway
```
🌐 Kunjungi: https://railway.app
🔐 Login dengan GitHub
🆕 "New Project"
📂 "Deploy from GitHub repo"
🎯 Pilih repository: koperasi-sembako
⚡ Railway akan auto-detect Laravel dan mulai build
```

### 2.3 Set Environment Variables
Di Railway Dashboard → Variables, tambahkan:

```env
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_URL=https://koperasi-sembako-production.up.railway.app
DB_CONNECTION=mongodb
DB_DSN=mongodb+srv://admin:MySecurePass123@koperasi-sembako.abc123.mongodb.net/koperasi_sembako?retryWrites=true&w=majority
SESSION_DRIVER=database
FILESYSTEM_DISK=public
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
```

### 2.4 Generate APP_KEY
```bash
# Di local, jalankan:
php artisan key:generate --show

# Copy hasilnya (contoh: base64:abc123...)
# Tambahkan ke Railway Variables:
APP_KEY=base64:abc123def456...
```

### 2.5 Custom Domain (Opsional - Gratis)
```
⚙️ Settings → Domains
🌐 Generate Domain: koperasi-sembako-production.up.railway.app
🔗 Atau connect custom domain gratis
```

---

## 🧪 LANGKAH 3: Testing Deployment

### 3.1 Cek Status Deploy
```
📊 Railway Dashboard → Deployments
✅ Status: "Success" (hijau)
🌐 Klik URL untuk test
```

### 3.2 Test Endpoints
```bash
# Homepage
curl https://your-app.up.railway.app

# Login page
curl https://your-app.up.railway.app/login

# API health check
curl https://your-app.up.railway.app/api/health
```

### 3.3 Test Database Connection
```
🔗 Buka: https://your-app.up.railway.app
📝 Coba register user baru
🔐 Coba login
🛒 Test fitur utama (add to cart, dll)
```

---

## 📊 Monitoring Gratis

### Railway Usage
```
📊 Dashboard → Usage
💰 Credit remaining: $5.00
⏱️ Hours used: 0/500+
📈 Memory: 512MB limit
```

### MongoDB Atlas
```
📊 Atlas Dashboard → Metrics
💾 Storage: 0MB/512MB
🔄 Operations: Unlimited reads/writes
📡 Network: 10GB/month transfer
```

---

## 🔧 Troubleshooting

### ❌ Build Failed
```bash
# Cek logs di Railway Dashboard
# Common issues:
1. Missing APP_KEY → Generate dan set di Variables
2. Composer dependencies → Cek composer.json
3. Node.js build → Cek package.json
```

### ❌ Database Connection Failed
```bash
# Cek:
1. DB_DSN format benar
2. Password tidak ada karakter khusus yang perlu di-encode
3. IP whitelist: 0.0.0.0/0
4. Database user permissions
```

### ❌ 500 Internal Server Error
```bash
# Set di Railway Variables:
APP_DEBUG=true
LOG_LEVEL=debug

# Cek logs untuk error detail
```

---

## 💡 Tips Optimasi Gratis

### 1. Reduce Memory Usage
```php
// config/app.php
'debug' => false,

// Disable unused services
// config/app.php - providers array
```

### 2. Optimize Database Queries
```php
// Use select() untuk limit fields
User::select('id', 'name', 'email')->get();

// Use pagination
Product::paginate(20);
```

### 3. Cache Configuration
```bash
# Di Railway, set:
CACHE_STORE=database
SESSION_DRIVER=database
```

---

## 🎉 Selesai!

### ✅ Yang Sudah Didapat:
- ✅ Database MongoDB 512MB gratis selamanya
- ✅ Hosting Laravel dengan $5 credit/bulan
- ✅ HTTPS otomatis
- ✅ Custom domain gratis
- ✅ Auto-deploy dari Git
- ✅ Monitoring dan logs

### 📱 URL Aplikasi:
```
🌐 Production: https://koperasi-sembako-production.up.railway.app
🔐 Admin: https://koperasi-sembako-production.up.railway.app/seller
```

### 💰 Total Biaya: $0/bulan

---

## 🔄 Update Aplikasi

```bash
# Setiap kali ada perubahan:
git add .
git commit -m "Update fitur baru"
git push origin main

# Railway akan auto-deploy dalam 2-3 menit
```

---

## 📞 Support

Jika ada masalah:
1. 📊 Cek Railway Dashboard → Logs
2. 📊 Cek MongoDB Atlas → Metrics
3. 🔍 Google error message
4. 💬 Railway Discord community (gratis)