<?php

namespace Database\Seeders;

use App\Models\SeamediaAddon;
use App\Models\SeamediaPackage;
use App\Models\SeamediaService;
use App\Models\SeamediaShowcase;
use App\Models\Setting;
use App\Models\WebTemplate;
use Illuminate\Database\Seeder;

class SeamediaSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Settings teks (hanya isi default bila belum ada — tidak menimpa editan admin)
        $defaults = [
            'seamedia.hero_eyebrow' => 'Conversion Web Partner',
            'seamedia.hero_title' => 'Social media bawa perhatian, website bangun kepercayaan.',
            'seamedia.hero_desc' => 'Seamedia ConWeb membantu UMKM & local brand punya rumah digital profesional — website, katalog produk, dan funnel order WhatsApp — agar perhatian dari konten berubah jadi konversi nyata.',
            'seamedia.stat1_value' => '4.000+', 'seamedia.stat1_label' => 'Creator multi-platform',
            'seamedia.stat2_value' => '500+', 'seamedia.stat2_label' => 'Seller partnership',
            'seamedia.stat3_value' => '2.000+', 'seamedia.stat3_label' => 'TAP product collaboration',
            'seamedia.quote' => 'Di era biaya digital dan potongan platform yang terus meningkat, memiliki website bukan lagi pilihan — melainkan kebutuhan.',
            'seamedia.cta_title' => 'Saatnya UMKM punya kehadiran digital yang nyata',
            'seamedia.cta_desc' => 'Bukan sekadar aktif di sosial media — miliki website profesional, katalog online, dan halaman order WhatsApp dalam satu ekosistem.',
            'seamedia.contact_name' => 'Agung Ando',
            'seamedia.contact_email' => 'seamediaindonesia@gmail.com',
            'seamedia.contact_wa' => 'https://wa.me/6281234567890',
            'seamedia.contact_location' => 'Palembang, Indonesia',
        ];
        foreach ($defaults as $key => $val) {
            if (Setting::get($key) === null) {
                Setting::put($key, $val, 'seamedia');
            }
        }

        // 2) Paket (hanya bila kosong)
        if (SeamediaPackage::count() === 0) {
            $packages = [
                ['name' => 'Care', 'title' => 'Rawat & Lanjutkan', 'badge' => null, 'is_featured' => false,
                    'description' => 'Untuk bisnis yang sudah punya website dan ingin menjaga keberlangsungan serta performanya.',
                    'features' => ['Perawatan & pembaruan rutin', 'Domain, hosting & SSL terjaga', 'Dukungan teknis berkelanjutan']],
                ['name' => 'Launch', 'title' => 'Website Baru Premium', 'badge' => 'Paling Populer', 'is_featured' => true,
                    'description' => 'Pembuatan website baru dengan desain premium, lengkap hingga siap tayang & mudah dikelola.',
                    'features' => ['Website / landing page (s/d 7 halaman)', 'Dashboard admin & WhatsApp funnel', 'SEO basic & siap di-index Google']],
                ['name' => 'Signature', 'title' => 'Eksklusif & Custom', 'badge' => null, 'is_featured' => false,
                    'description' => 'Untuk bisnis dengan kebutuhan lebih bervariasi yang ingin tampilan eksklusif & berciri khas.',
                    'features' => ['Desain & fitur sepenuhnya custom', 'Identitas visual khas brand', 'Konsultasi mendalam & fleksibel']],
            ];
            foreach ($packages as $i => $p) {
                SeamediaPackage::create($p + ['sort' => $i, 'is_active' => true]);
            }
        }

        // 3) Layanan (hanya bila kosong)
        if (SeamediaService::count() === 0) {
            $services = [
                ['icon' => 'web', 'title' => 'Website & Landing Page', 'description' => 'Company profile, katalog, dan landing page premium yang membangun kredibilitas brand.'],
                ['icon' => 'cart', 'title' => 'Katalog Produk Online', 'description' => 'Tampilkan produk/menu rapi dengan detail, foto, dan tombol order langsung.'],
                ['icon' => 'wa', 'title' => 'Funnel Order WhatsApp', 'description' => 'Arahkan traffic ke chat WhatsApp dengan tombol & format pesan otomatis.'],
                ['icon' => 'panel', 'title' => 'Dashboard Admin', 'description' => 'Kelola profil, produk, promo, galeri, dan testimoni sendiri dengan mudah.'],
                ['icon' => 'seo', 'title' => 'SEO & Google Ready', 'description' => 'Struktur ramah Google, meta, sitemap, hingga Google Business Profile.'],
                ['icon' => 'care', 'title' => 'Maintenance & Support', 'description' => 'Perawatan rutin, update konten, dan dukungan teknis berkelanjutan.'],
            ];
            foreach ($services as $i => $s) {
                SeamediaService::create($s + ['sort' => $i, 'is_active' => true]);
            }
        }

        // 4) Add-on (hanya bila kosong)
        if (SeamediaAddon::count() === 0) {
            $addons = ['Tambah Halaman', 'Upload Produk', 'Edit Konten Ringan', 'Desain Banner', 'Maintenance Bulanan Khusus', 'Optimasi Pencarian (SEO)', 'Setup Google Business Profile'];
            foreach ($addons as $i => $a) {
                SeamediaAddon::create(['name' => $a, 'sort' => $i, 'is_active' => true]);
            }
        }

        // 5) Showcase — ambil dari template ConWeb yang sudah ada (sekali, bila kosong)
        if (SeamediaShowcase::count() === 0) {
            foreach (WebTemplate::where('is_active', true)->orderBy('sort')->get() as $i => $tpl) {
                SeamediaShowcase::create([
                    'title' => $tpl->name,
                    'category' => $tpl->category,
                    'thumbnail' => $tpl->thumbnail,
                    'preview_url' => url('/template/'.$tpl->slug),
                    'is_featured' => (bool) $tpl->is_featured,
                    'sort' => $i,
                    'is_active' => true,
                ]);
            }
        }
    }
}
