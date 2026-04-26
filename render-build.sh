#!/usr/bin/env bash
# Render.com build script

set -o errexit

echo "🔧 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Installing NPM dependencies..."
npm install

echo "🏗️ Building assets..."
npm run build

echo "✅ Build completed successfully!"