#!/usr/bin/env bash
# Render.com build script for Laravel

set -o errexit

echo "🔍 Checking environment..."
php -v
composer -V
node -v
npm -v

echo "🔧 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "📦 Installing NPM dependencies..."
npm ci --only=production

echo "🏗️ Building assets..."
npm run build

echo "🧹 Cleaning up..."
php artisan config:clear
php artisan cache:clear

echo "✅ Build completed successfully!"