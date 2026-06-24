# ConWeb ID — Laravel 11 + Filament v3

Landing page lama (file HTML tanpa framework) sudah diubah menjadi aplikasi **Laravel + Filament** dengan desain yang **persis sama**, dan **semua elemen bisa diganti lewat panel admin**.

## Menjalankan

```bash
cd conweb-app
php artisan serve
```

- **Website**: http://127.0.0.1:8000
- **Panel Admin**: http://127.0.0.1:8000/admin

### Login Admin
- Email: `andreasafp2@gmail.com`
- Password: `password`

> Ganti password: `php artisan tinker` lalu set `User::first()->update(['password'=>bcrypt('passwordbaru')])`.

## Yang bisa diedit dari Admin

**Menu "Pengaturan → Konten Website"** (semua teks + brand, dwibahasa ID/EN):
- Brand & SEO (judul, meta, **upload logo**, email, link WhatsApp)
- Navbar, Hero (termasuk kartu mengambang & window dashboard)
- Heading semua seksi, Why/Keunggulan, CTA/Kontak, Footer, link sosial media

**Menu "Konten Halaman"** (data berulang, bisa tambah/hapus/urutkan drag-drop):
- **Layanan** (Services) + poin fitur (ID/EN)
- **Statistik**
- **Proses** (Process)
- **Portofolio** — termasuk **upload gambar background**, gradient, tags, link
- **Tech Stack**
- **Testimoni**
- **FAQ**
- **Logo Strip**

Setiap item punya toggle **Aktif** dan field **Urutan** (atau drag untuk mengurutkan).

## Catatan teknis
- Database: **SQLite** (`database/database.sqlite`) — tanpa setup MySQL.
- Bahasa: switcher ID/EN tetap berfungsi instan (tanpa reload); kedua bahasa diisi dari admin.
- Upload file disimpan di `storage/app/public` dan dilink via `public/storage` (`php artisan storage:link` sudah dijalankan).
- Ikon dipilih dari pustaka SVG bawaan (`app/Support/Icons.php`).

## Seed ulang konten awal
```bash
php artisan migrate:fresh
php artisan db:seed --class=Database\\Seeders\\ContentSeeder
```
