#!/bin/sh
# ─────────────────────────────────────────────────────────────────
# GoodPanda — Docker entrypoint
# Runs every time the app container starts
# ─────────────────────────────────────────────────────────────────

set -e

# Ensure git safe.directory is set for mounted host repo ownership
git config --global --add safe.directory /var/www/html || true

# Only run heavy initialization once per container lifecycle
INIT_FLAG_FILE="/var/www/html/storage/logs/.container_ready"
if [ ! -f "$INIT_FLAG_FILE" ]; then
  echo "==> Installing PHP dependencies..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
  composer dump-autoload -o

  echo "==> Installing Node dependencies..."
  npm install

  echo "==> Building frontend assets (Vite)..."
  npm run build

  echo "==> Clearing Laravel caches..."
  php artisan config:clear
  php artisan cache:clear
#echo "==> Running migrations..."
#php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

  echo "==> Running migrations..."
  php artisan migrate --force

  touch "$INIT_FLAG_FILE"
fi

# Start PHP-FPM (foreground)
exec php-fpm