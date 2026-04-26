#!/usr/bin/env bash
# Heroku .profile script - runs after build, before web process starts

echo "Running post-deploy commands..."

# Discover packages
php artisan package:discover --ansi || echo "Package discovery skipped"

# Clear and cache config
php artisan config:cache || echo "Config cache skipped"

# Clear views
php artisan view:clear || echo "View clear skipped"

echo "Post-deploy commands completed"