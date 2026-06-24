#!/usr/bin/env bash
# Deploy update ConWeb di server Hostinger.
# Jalankan di server:  cd ~/conweb_app && bash deploy.sh
set -e

PROJ="/home/u598194357/conweb_app"
DOCROOT="/home/u598194357/domains/conweb.id/public_html"

cd "$PROJ"

echo "→ 1/6 Ambil kode terbaru dari Git..."
git pull origin main

echo "→ 2/6 Install dependency (composer)..."
composer install --no-dev --optimize-autoloader

echo "→ 3/6 Migrasi database (aman, hanya menambah tabel/kolom baru)..."
php artisan migrate --force

echo "→ 4/6 Sinkron aset publik (css/js/favicon) ke docroot..."
cp -r public/css public/js public/favicon.ico "$DOCROOT/" 2>/dev/null || true
# index.php & storage TIDAK disentuh (sudah dikonfigurasi khusus di server)

echo "→ 5/6 Bersihkan & cache ulang..."
php artisan optimize:clear
php artisan filament:assets
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "→ 6/6 Selesai ✓  — jangan lupa Clear cache di hPanel kalau perlu."
