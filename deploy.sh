#!/bin/bash

echo "🚀 Koperasi Sembako - Deploy Script"
echo "=================================="

# Check if .env.production exists
if [ ! -f .env.production ]; then
    echo "❌ File .env.production tidak ditemukan!"
    echo "Silakan buat file .env.production terlebih dahulu"
    exit 1
fi

# Backup current .env
if [ -f .env ]; then
    cp .env .env.backup
    echo "✅ Backup .env ke .env.backup"
fi

# Copy production environment
cp .env.production .env
echo "✅ Menggunakan .env.production"

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Clear and cache config
echo "🔧 Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generate key if needed
if grep -q "APP_KEY=$" .env; then
    php artisan key:generate
    echo "🔑 Generated new APP_KEY"
fi

echo ""
echo "✅ Deploy preparation completed!"
echo ""
echo "📋 Next steps:"
echo "1. Push to your Git repository"
echo "2. Deploy to your chosen platform (Railway/Heroku/Render)"
echo "3. Set environment variables in platform dashboard"
echo "4. Test your application"
echo ""
echo "🔗 Useful links:"
echo "- Railway: https://railway.app"
echo "- Heroku: https://heroku.com"
echo "- Render: https://render.com"
echo "- MongoDB Atlas: https://cloud.mongodb.com"

# Restore original .env
if [ -f .env.backup ]; then
    mv .env.backup .env
    echo "🔄 Restored original .env"
fi