# 🔑 DAFTAR LENGKAP ENVIRONMENT VARIABLES

> **Panduan lengkap semua environment variables yang harus diisi di Railway**

---

## 📋 TEMPLATE COPY-PASTE

### 🟢 WAJIB - Core Application

```env
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app
APP_KEY=base64:GENERATE_WITH_ARTISAN_COMMAND
```

**Cara generate APP_KEY**:
```bash
# Di terminal lokal:
php artisan key:generate --show
# Copy hasil output (contoh: base64:abc123...)
```

### 🟢 WAJIB - Database MongoDB

```env
DB_CONNECTION=mongodb
DB_DSN=mongodb+srv://admin:PASSWORD@cluster.mongodb.net/koperasi_sembako?retryWrites=true&w=majority
```

**Format DB_DSN**:
- Ganti `PASSWORD` dengan password MongoDB Atlas Anda
- Ganti `cluster` dengan nama cluster Anda
- Pastikan ada `/koperasi_sembako` di akhir

### 🟢 WAJIB - Session & Cache

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### 🟢 WAJIB - File Storage

```env
FILESYSTEM_DISK=public
```

### 🟢 WAJIB - Logging

```env
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### 🟢 WAJIB - Mail Configuration

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@koperasi-sembako.com
MAIL_FROM_NAME=Koperasi Sembako
```

---

## 🟡 OPSIONAL - Optimasi Performance

### Security & Encryption

```env
BCRYPT_ROUNDS=10
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

### Cache Optimization

```env
CACHE_PREFIX=koperasi_
```

### Broadcasting (untuk real-time features)

```env
BROADCAST_CONNECTION=log
```

---

## 🟡 OPSIONAL - AI Support Widget

Jika ingin mengaktifkan AI Support dengan Grok:

```env
GROK_API_KEY=xai-your-api-key-here
```

**Cara mendapatkan Grok API Key**:
1. Daftar di https://x.ai
2. Buat API key
3. Copy dan paste ke environment

---

## 🟡 OPSIONAL - Email SMTP (untuk notifikasi email nyata)

Jika ingin kirim email nyata (bukan log):

### Gmail SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Mailtrap (untuk testing):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
```

---

## 🔴 JANGAN DIISI - Variables yang Tidak Perlu

Variables berikut **TIDAK PERLU** diisi di Railway:

```env
# Jangan isi ini:
DB_HOST=          # Sudah ada di DB_DSN
DB_PORT=          # Sudah ada di DB_DSN  
DB_DATABASE=      # Sudah ada di DB_DSN
DB_USERNAME=      # Sudah ada di DB_DSN
DB_PASSWORD=      # Sudah ada di DB_DSN

# Jangan isi ini (untuk local development):
VITE_APP_NAME=
PHP_CLI_SERVER_WORKERS=
```

---

## 📝 CARA MENGISI DI RAILWAY

### Step-by-Step:

1. **Login ke Railway Dashboard**
2. **Pilih project Anda**
3. **Klik tab "Variables"**
4. **Klik "New Variable"**
5. **Isi satu per satu**:
   - **Key**: Nama variable (contoh: `APP_NAME`)
   - **Value**: Nilai variable (contoh: `Koperasi Sembako`)
6. **Klik "Add"**
7. **Ulangi untuk semua variables**

### 💡 Tips Mengisi:

- **Copy-paste** dari template di atas
- **Isi yang WAJIB dulu**, baru yang opsional
- **Ganti placeholder** dengan nilai sebenarnya
- **Jangan ada spasi** di awal/akhir value
- **Gunakan quotes** jika value ada spasi

---

## ✅ CHECKLIST ENVIRONMENT VARIABLES

### 🟢 WAJIB (Harus Ada):
- [ ] `APP_NAME`
- [ ] `APP_ENV`
- [ ] `APP_DEBUG`
- [ ] `APP_URL`
- [ ] `APP_KEY`
- [ ] `DB_CONNECTION`
- [ ] `DB_DSN`
- [ ] `SESSION_DRIVER`
- [ ] `CACHE_STORE`
- [ ] `QUEUE_CONNECTION`
- [ ] `FILESYSTEM_DISK`
- [ ] `LOG_CHANNEL`
- [ ] `LOG_LEVEL`
- [ ] `MAIL_MAILER`
- [ ] `MAIL_FROM_ADDRESS`
- [ ] `MAIL_FROM_NAME`

### 🟡 OPSIONAL (Boleh Ada/Tidak):
- [ ] `BCRYPT_ROUNDS`
- [ ] `SESSION_LIFETIME`
- [ ] `CACHE_PREFIX`
- [ ] `GROK_API_KEY`
- [ ] SMTP settings (jika ingin email nyata)

---

## 🔍 CONTOH LENGKAP UNTUK COPY-PASTE

```env
# === WAJIB ===
APP_NAME=Koperasi Sembako
APP_ENV=production
APP_DEBUG=false
APP_URL=https://koperasi-sembako-production.up.railway.app
APP_KEY=base64:abc123def456ghi789jkl012mno345pqr678stu901vwx234yz=

DB_CONNECTION=mongodb
DB_DSN=mongodb+srv://admin:MySecurePass123@koperasi-sembako.abc123.mongodb.net/koperasi_sembako?retryWrites=true&w=majority

SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=public

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@koperasi-sembako.com
MAIL_FROM_NAME=Koperasi Sembako

# === OPSIONAL ===
BCRYPT_ROUNDS=10
CACHE_PREFIX=koperasi_
BROADCAST_CONNECTION=log
```

---

## 🚨 TROUBLESHOOTING ENVIRONMENT

### ❌ Error: "No application encryption key"
**Solusi**: Generate dan set `APP_KEY`
```bash
php artisan key:generate --show
```

### ❌ Error: "Database connection failed"
**Solusi**: Cek format `DB_DSN`
- Pastikan password benar
- Pastikan nama database ada
- Pastikan IP whitelist: 0.0.0.0/0

### ❌ Error: "Session store not configured"
**Solusi**: Set `SESSION_DRIVER=database`

### ❌ Error: "Storage disk not configured"
**Solusi**: Set `FILESYSTEM_DISK=public`

### ❌ Error: "Mail driver not configured"
**Solusi**: Set minimal:
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@example.com
```

---

## 📞 BANTUAN

Jika masih ada error setelah mengisi semua environment variables:

1. **Cek Railway Logs**: Dashboard → Logs tab
2. **Cek spelling**: Pastikan nama variable benar
3. **Cek format**: Pastikan tidak ada spasi extra
4. **Deploy ulang**: Setelah update variables

---

<div align="center">

**💡 Tips**: Simpan file ini sebagai referensi saat setup environment variables!

</div>