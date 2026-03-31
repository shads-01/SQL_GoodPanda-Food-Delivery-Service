#!/bin/sh
# ─────────────────────────────────────────────────────────────────
# GoodPanda — Docker entrypoint
# Runs every time the app container starts
# ─────────────────────────────────────────────────────────────────

set -e

echo "==> Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "==> Installing Node dependencies..."
npm install

echo "==> Building frontend assets (Vite)..."
npm run build

echo "==> Clearing config cache..."
php artisan config:clear
php artisan cache:clear

#echo "==> Running migrations..."
#php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting PHP-FPM..."
exec php-fpm