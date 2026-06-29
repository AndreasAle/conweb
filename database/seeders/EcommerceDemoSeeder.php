<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\StorePackage;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder DEMO untuk modul E-commerce by Conweb.
 *
 * AMAN / NON-DESTRUKTIF: hanya memakai firstOrCreate, tidak meng-truncate
 * tabel apa pun. Jalankan terpisah:
 *   php artisan db:seed --class=Database\\Seeders\\EcommerceDemoSeeder
 *
 * TIDAK didaftarkan di DatabaseSeeder agar tidak ikut `db:seed` penuh.
 */
class EcommerceDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Paket layanan
        $packages = [
            ['name' => 'Conweb Profile', 'slug' => 'conweb-profile', 'tagline' => 'Profil usaha + katalog', 'price' => 0, 'price_period' => '/tahun', 'product_limit' => 20, 'sort_order' => 1, 'features' => ['Profil usaha', 'Katalog produk', 'Checkout WhatsApp']],
            ['name' => 'Conweb Store', 'slug' => 'conweb-store', 'tagline' => 'Toko online lengkap', 'price' => 0, 'price_period' => '/tahun', 'is_featured' => true, 'product_limit' => null, 'sort_order' => 2, 'features' => ['Semua fitur Profile', 'Dashboard pesanan', 'Voucher & diskon', 'SEO produk']],
            ['name' => 'Conweb Commerce', 'slug' => 'conweb-commerce', 'tagline' => 'Skala lebih besar', 'price' => 0, 'price_period' => '/tahun', 'product_limit' => null, 'sort_order' => 3, 'features' => ['Semua fitur Store', 'Prioritas support', 'Kustomisasi tampilan']],
        ];
        foreach ($packages as $p) {
            StorePackage::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // Owner demo
        $owner = User::firstOrCreate(
            ['email' => 'owner@conwebstore.test'],
            [
                'name' => 'Owner Demo',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ],
        );

        // Toko demo
        $store = Store::firstOrCreate(
            ['slug' => 'toko-berkah-jaya'],
            [
                'user_id' => $owner->id,
                'store_package_id' => StorePackage::where('slug', 'conweb-store')->value('id'),
                'name' => 'Toko Berkah Jaya',
                'tagline' => 'Camilan rumahan kekinian',
                'description' => 'Aneka camilan rumahan dibuat fresh setiap hari. Pesan mudah langsung via WhatsApp.',
                'whatsapp_number' => '081234567890',
                'email' => 'halo@berkahjaya.test',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'primary_color' => '#e11d48',
                'secondary_color' => '#1f2937',
                'is_active' => true,
                'is_featured' => true,
            ],
        );

        // Kategori
        $catMakanan = $store->categories()->firstOrCreate(['slug' => 'makanan'], ['name' => 'Makanan', 'sort_order' => 1]);
        $catMinuman = $store->categories()->firstOrCreate(['slug' => 'minuman'], ['name' => 'Minuman', 'sort_order' => 2]);

        // Produk
        $products = [
            ['name' => 'Keripik Singkong Pedas', 'slug' => 'keripik-singkong-pedas', 'category_id' => $catMakanan->id, 'price' => 15000, 'compare_price' => 20000, 'stock' => 50, 'is_featured' => true, 'short_description' => 'Renyah, pedas nampol.'],
            ['name' => 'Brownies Panggang', 'slug' => 'brownies-panggang', 'category_id' => $catMakanan->id, 'price' => 45000, 'stock' => 20, 'is_featured' => true, 'short_description' => 'Lembut & cokelat melimpah.'],
            ['name' => 'Kopi Susu Gula Aren', 'slug' => 'kopi-susu-gula-aren', 'category_id' => $catMinuman->id, 'price' => 18000, 'stock' => null, 'short_description' => 'Signature, manis pas.'],
            ['name' => 'Teh Lemon Segar', 'slug' => 'teh-lemon-segar', 'category_id' => $catMinuman->id, 'price' => 12000, 'stock' => 100],
        ];
        foreach ($products as $p) {
            $store->products()->firstOrCreate(['slug' => $p['slug']], array_merge($p, ['is_active' => true]));
        }

        // Voucher
        $store->vouchers()->firstOrCreate(
            ['code' => 'HEMAT10'],
            ['type' => Voucher::TYPE_PERCENTAGE, 'value' => 10, 'max_discount' => 10000, 'min_order_amount' => 30000, 'is_active' => true],
        );

        $this->command?->info('Demo toko: '.url('/store/'.$store->slug));
        $this->command?->info('Login owner: owner@conwebstore.test / password (dashboard: '.url('/store-dashboard').')');
    }
}
