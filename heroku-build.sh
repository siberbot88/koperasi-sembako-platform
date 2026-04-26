#!/usr/bin/env bash
# Heroku build script

set -e

echo "-----> Running Heroku build script"

# Install composer dependencies without running scripts
echo "-----> Installing Composer dependencies"
composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Run autoload dump manually
echo "-----> Generating autoload files"
composer dump-autoload --optimize --no-scripts

# Install npm dependencies
echo "-----> Installing NPM dependencies"
npm ci --only=production

# Build assets
echo "-----> Building assets"
npm run build

echo "-----> Build completed successfully"