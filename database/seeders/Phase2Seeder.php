<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\HeroSlide;
use App\Models\PricingPlan;
use App\Models\PromoCode;
use App\Models\Service;
use App\Models\Setting;
use App\Models\WebTemplate;
use Illuminate\Database\Seeder;

class Phase2Seeder extends Seeder
{
    public function run(): void
    {
        $this->seedHeroSlides();
        $this->seedServiceDetails();
        $this->seedTemplates();
        $this->seedPricing();
        $this->seedBlog();
        $this->seedOrderExtras();
    }

    protected function seedHeroSlides(): void
    {
        HeroSlide::truncate();

        $slides = [
            [
                'badge_id' => 'Khusus Bisnis Indonesia', 'badge_en' => 'Made for Indonesian Businesses',
                'title_id' => 'Buat website profesional, ditemukan <em>klien dunia</em>.',
                'title_en' => 'Build a professional website, found by <em>clients worldwide</em>.',
                'desc_id' => 'Website siap pakai untuk bisnis, startup, dan UMKM — tanpa ribet, langsung jalan.',
                'desc_en' => 'Ready-to-use websites for businesses, startups, and SMEs — no hassle, straight to launch.',
                'discount_text_id' => 'Diskon Rp500.000', 'discount_text_en' => 'Rp500,000 Discount',
                'promo_code' => 'WEBSITEJUARA',
                'button1_label_id' => 'Cari Domain', 'button1_label_en' => 'Find a Domain', 'button1_url' => null,
                'button2_label_id' => 'Hubungi Kami', 'button2_label_en' => 'Contact Us', 'button2_url' => null,
                'float1_text_id' => '10k+ Pelaku Usaha', 'float1_text_en' => '10k+ Business Owners',
                'float2_text_id' => 'Rilis Bulan Ini: 30+ Website', 'float2_text_en' => 'Launched This Month: 30+ Sites',
            ],
            [
                'badge_id' => 'Khusus Eksportir Indonesia', 'badge_en' => 'Made for Indonesian Exporters',
                'title_id' => 'Website ekspor profesional, ditemukan <em>buyer dunia</em>.',
                'title_en' => 'Professional export website, found by <em>global buyers</em>.',
                'desc_id' => 'Profil ekspor lengkap dengan HS Code & dokumen siap kirim ke buyer mana saja.',
                'desc_en' => 'A complete export profile with HS Code & ready-to-send documents for any buyer.',
                'discount_text_id' => 'Diskon Rp500.000', 'discount_text_en' => 'Rp500,000 Discount',
                'promo_code' => 'WEBSITEJUARA',
                'button1_label_id' => 'Cari Domain', 'button1_label_en' => 'Find a Domain', 'button1_url' => null,
                'button2_label_id' => 'Hubungi Kami', 'button2_label_en' => 'Contact Us', 'button2_url' => null,
                'float1_text_id' => '10k+ Eksportir Indonesia', 'float1_text_en' => '10k+ Indonesian Exporters',
                'float2_text_id' => 'Ekspor Bulan Ini: 10+ Kontainer', 'float2_text_en' => 'Exported This Month: 10+ Containers',
            ],
            [
                'badge_id' => 'Solusi UMKM Naik Kelas', 'badge_en' => 'Leveling Up SMEs',
                'title_id' => 'Toko online siap jualan, <em>tanpa ribet</em>.',
                'title_en' => 'Online store ready to sell, <em>without the hassle</em>.',
                'desc_id' => 'Keranjang, pembayaran, dan manajemen produk sudah siap — tinggal isi konten.',
                'desc_en' => 'Cart, payments, and product management are ready — just add your content.',
                'discount_text_id' => null, 'discount_text_en' => null,
                'promo_code' => null,
                'button1_label_id' => 'Lihat Template', 'button1_label_en' => 'Browse Templates', 'button1_url' => null,
                'button2_label_id' => 'Konsultasi Gratis', 'button2_label_en' => 'Free Consultation', 'button2_url' => null,
                'float1_text_id' => '4.9/5 Rating Pengguna', 'float1_text_en' => '4.9/5 User Rating',
                'float2_text_id' => 'Live dalam 1 Hari', 'float2_text_en' => 'Live in 1 Day',
            ],
        ];

        foreach ($slides as $i => $slide) {
            HeroSlide::create($slide + ['sort' => $i, 'is_active' => true]);
        }
    }

    protected function seedOrderExtras(): void
    {
        // Pricing model — based on the official ConWeb pricelist.
        Setting::put('order.launch_price', 1500000, 'order'); // ConWeb Launch (web baru, tahun 1)
        Setting::put('order.care_price', 1250000, 'order');   // ConWeb Care (perpanjangan/perawatan per tahun)
        Setting::put('order.signature_divisor', 0.53, 'order'); // harga Signature = modal / 0.53
        Setting::put('order.hosting_per_year', 320000, 'order'); // komponen Hosting + SSL (sudah termasuk paket)
        Setting::put('order.admin_fee', 0, 'order');
        // Nomor WhatsApp tujuan order (sementara, sebelum payment gateway aktif).
        Setting::put('order.whatsapp_admin', '6281532963501', 'order');

        PromoCode::updateOrCreate(['code' => 'WEBSITEJUARA'], [
            'discount_type' => 'fixed',
            'discount_value' => 500000,
            'is_active' => true,
        ]);
    }

    protected function seedServiceDetails(): void
    {
        $details = [
            'Website Development' => [
                'slug' => 'website-development',
                'hero_title_id' => 'Website yang terlihat premium dan menghasilkan konversi',
                'hero_title_en' => 'A premium-looking website that actually converts',
                'hero_subtitle_id' => 'Company profile, landing page, dan website commerce dengan desain modern dan struktur SEO dasar.',
                'hero_subtitle_en' => 'Company profiles, landing pages, and commerce sites with modern design and basic SEO structure.',
                'body_id' => "Kami merancang setiap halaman dengan alur konversi yang jelas — dari hero, value proposition, hingga call-to-action.\n\nSetiap website dibangun responsif, cepat, dan mudah dikelola lewat panel admin sehingga tim Anda bisa memperbarui konten sendiri kapan saja.",
                'body_en' => "We design every page with a clear conversion flow — from hero, value proposition, to call-to-action.\n\nEvery website is built responsive, fast, and easy to manage through an admin panel so your team can update content anytime.",
            ],
            'Aplikasi Web & Mobile' => [
                'slug' => 'aplikasi-web-mobile',
                'hero_title_id' => 'Aplikasi yang menyederhanakan operasional harian',
                'hero_title_en' => 'Apps that simplify your daily operations',
                'hero_subtitle_id' => 'Booking, order, member, dan layanan dengan dashboard multi-role yang rapi.',
                'hero_subtitle_en' => 'Booking, order, member, and service apps with clean multi-role dashboards.',
                'body_id' => "Kami membangun aplikasi web dan mobile-first yang fokus pada kemudahan penggunaan untuk pelanggan maupun tim internal.\n\nDashboard multi-role memungkinkan setiap pengguna — admin, staf, maupun pelanggan — mendapatkan akses sesuai kebutuhannya.",
                'body_en' => "We build web and mobile-first apps focused on ease of use for both customers and internal teams.\n\nMulti-role dashboards let every user — admin, staff, or customer — get access tailored to their needs.",
            ],
            'Sistem Custom & Internal Tools' => [
                'slug' => 'sistem-custom',
                'hero_title_id' => 'Sistem internal yang dirancang sesuai alur bisnis Anda',
                'hero_title_en' => 'Internal systems designed around your business flow',
                'hero_subtitle_id' => 'Inventory, keuangan, reporting, dan integrasi API dalam satu sistem terstruktur.',
                'hero_subtitle_en' => 'Inventory, finance, reporting, and API integration in one structured system.',
                'body_id' => "Setiap sistem custom kami mulai dari pemetaan proses bisnis nyata, bukan template generik.\n\nStruktur datanya dirancang scalable, sehingga mudah ditambah modul baru saat bisnis Anda berkembang.",
                'body_en' => "Every custom system starts from mapping your real business process, not a generic template.\n\nThe data structure is designed to scale, so new modules are easy to add as your business grows.",
            ],
            'AI & Otomatisasi' => [
                'slug' => 'ai-otomatisasi',
                'hero_title_id' => 'Otomatisasi yang memangkas pekerjaan manual',
                'hero_title_en' => 'Automation that cuts manual work',
                'hero_subtitle_id' => 'Chatbot, laporan otomatis, dan integrasi workflow berbasis AI.',
                'hero_subtitle_en' => 'AI-powered chatbots, automated reports, and workflow integration.',
                'body_id' => "Kami mengintegrasikan AI ke dalam proses yang berulang — balasan pelanggan, rekap laporan, hingga notifikasi otomatis.\n\nHasilnya, tim Anda bisa fokus ke pekerjaan strategis sementara tugas rutin berjalan sendiri.",
                'body_en' => "We integrate AI into repetitive processes — customer replies, report summaries, and automated notifications.\n\nThe result: your team can focus on strategic work while routine tasks run themselves.",
            ],
        ];

        foreach ($details as $title => $data) {
            Service::where('title_id', $title)->first()?->update($data);
        }
    }

    protected function seedTemplates(): void
    {
        WebTemplate::truncate();

        // Template asli ConWeb (thumbnail tersimpan di storage/app/public/templates).
        $templates = [
            [
                'slug' => 'smile-artistry',
                'name' => 'Smile Artistry',
                'category' => 'Kesehatan',
                'thumbnail' => 'templates/01KVSK6A5SP4XTGB545ZS13W2C.png',
                'primary_color' => '#14b8a6',
                'secondary_color' => '#0f172a',
                'is_featured' => true,
                'popularity' => 120,
                'price' => 0,
                'price_label' => 'Termasuk semua paket',
                'tagline_id' => 'Klinik gigi modern dengan booking perawatan via WhatsApp',
                'tagline_en' => 'A modern dental clinic with WhatsApp appointment booking',
                'preview_url' => null,
            ],
            [
                'slug' => 'geprek-bara',
                'name' => 'Geprek Bara',
                'category' => 'Kuliner',
                'thumbnail' => 'templates/01KVTENDB2MQHKJ1MJNTCB37T9.png',
                'primary_color' => '#dc2626',
                'secondary_color' => '#1c1917',
                'is_featured' => true,
                'popularity' => 145,
                'price' => 0,
                'price_label' => 'Termasuk semua paket',
                'tagline_id' => 'Brand ayam geprek dengan menu, galeri & order online',
                'tagline_en' => 'An ayam geprek brand with menu, gallery & online ordering',
                'preview_url' => null,
            ],
            [
                'slug' => 'dapur-beku',
                'name' => 'Dapur Beku',
                'category' => 'Kuliner',
                'thumbnail' => 'templates/01KVTF0YTT3J6GMM553HV0DEHS.png',
                'primary_color' => '#1d4ed8',
                'secondary_color' => '#0a1530',
                'is_featured' => false,
                'popularity' => 98,
                'price' => 0,
                'price_label' => 'Termasuk semua paket',
                'tagline_id' => 'Frozen food praktis dengan katalog produk & pemesanan',
                'tagline_en' => 'Practical frozen food with product catalog & ordering',
                'preview_url' => null,
            ],
            [
                'slug' => 'rasarumah-catering',
                'name' => 'RasaRumah Catering',
                'category' => 'Kuliner',
                'thumbnail' => 'templates/01KVTFKB3HNHM9DZ7H03H69TQ7.png',
                'primary_color' => '#92400e',
                'secondary_color' => '#1c1917',
                'is_featured' => false,
                'popularity' => 88,
                'price' => 0,
                'price_label' => 'Termasuk semua paket',
                'tagline_id' => 'Catering acara dengan paket lengkap & pemesanan WhatsApp',
                'tagline_en' => 'Event catering with full packages & WhatsApp ordering',
                'preview_url' => null,
            ],
            [
                'slug' => 'whip-whisk',
                'name' => 'Whip & Whisk',
                'category' => 'Kuliner',
                'thumbnail' => 'templates/01KVTGAWATVK4Q2XVBJDN5FJ9A.png',
                'primary_color' => '#15803d',
                'secondary_color' => '#1c1917',
                'is_featured' => true,
                'popularity' => 110,
                'price' => 0,
                'price_label' => 'Termasuk semua paket',
                'tagline_id' => 'Bakery & café dengan menu, best seller & pre-order',
                'tagline_en' => 'A bakery & café with menu, best sellers & pre-order',
                'preview_url' => null,
            ],
            [
                'slug' => 'bakso-ngebul',
                'name' => 'Bakso Ngebul',
                'category' => 'Kuliner',
                'thumbnail' => 'templates/01KVTGXCFHCAPVXQA3D0YX7SQB.png',
                'primary_color' => '#ea580c',
                'secondary_color' => '#1c1917',
                'is_featured' => false,
                'popularity' => 76,
                'price' => 0,
                'price_label' => 'Termasuk semua paket',
                'tagline_id' => 'Kedai bakso dengan menu signature & order online',
                'tagline_en' => 'A meatball shop with signature menu & online ordering',
                'preview_url' => null,
            ],
        ];

        foreach ($templates as $i => $tpl) {
            WebTemplate::create($tpl + ['sort' => $i, 'is_active' => true]);
        }
    }

    protected function seedPricing(): void
    {
        PricingPlan::truncate();

        // Domain + DNS sudah termasuk di dalam paket (lihat pricelist). Plan domain dipakai
        // wizard untuk memilih nama & TLD — harganya 0 karena sudah include di paket.
        $domains = [
            ['name' => '.com', 'price' => 0, 'original_price' => null, 'badge' => 'Populer', 'features' => ['Termasuk paket Launch', 'DNS terkelola', 'Email bisnis', 'Cocok untuk semua usaha']],
            ['name' => '.co.id', 'price' => 0, 'original_price' => null, 'badge' => null, 'features' => ['Termasuk paket Launch', 'DNS terkelola', 'Email bisnis', 'Cocok untuk badan usaha']],
            ['name' => '.id', 'price' => 0, 'original_price' => null, 'badge' => null, 'features' => ['Termasuk paket Launch', 'DNS terkelola', 'Email bisnis', 'Domain lokal Indonesia']],
        ];
        foreach ($domains as $i => $d) {
            PricingPlan::create($d + ['type' => 'domain', 'period' => '/tahun', 'sort' => $i, 'is_active' => true]);
        }

        // Paket utama — mengikuti pricelist resmi ConWeb.
        $packages = [
            [
                'name' => 'ConWeb Launch',
                'price' => 1500000,
                'original_price' => null,
                'period' => '/pembuatan',
                'badge' => 'Paling Lengkap',
                'features' => [
                    'Domain + DNS (1 tahun)',
                    'Hosting + SSL (1 tahun)',
                    'Setup template & UI profesional',
                    'Pengerjaan penuh oleh tim programmer',
                    'Optimasi dasar & marketing',
                    'Pendampingan project sampai live',
                ],
            ],
            [
                'name' => 'ConWeb Care',
                'price' => 1250000,
                'original_price' => null,
                'period' => '/tahun',
                'badge' => 'Perpanjangan',
                'features' => [
                    'Perpanjangan Domain + DNS',
                    'Perpanjangan Hosting + SSL',
                    'Pembaruan & perawatan template/UI',
                    'Dukungan teknis programmer',
                    'Maintenance rutin & monitoring',
                ],
            ],
            [
                'name' => 'ConWeb Signature',
                'price' => 0, // custom — dihitung modal / 0.53
                'original_price' => null,
                'period' => 'custom',
                'badge' => 'Custom',
                'features' => [
                    'Desain & fitur sepenuhnya custom',
                    'Konsultasi & riset mendalam',
                    'Skala bisnis menengah – enterprise',
                    'Tim khusus & timeline fleksibel',
                    'Harga menyesuaikan kebutuhan',
                ],
            ],
        ];
        foreach ($packages as $i => $p) {
            PricingPlan::create($p + ['type' => 'package', 'sort' => $i, 'is_active' => true]);
        }
    }

    protected function seedBlog(): void
    {
        BlogPost::truncate();
        BlogCategory::truncate();

        $digital = BlogCategory::create(['name_id' => 'Digitalisasi & Website', 'name_en' => 'Digitalization & Websites', 'slug' => 'digitalisasi-website', 'sort' => 0]);
        $market = BlogCategory::create(['name_id' => 'Tren & Analisis Pasar', 'name_en' => 'Market Trends & Analysis', 'slug' => 'tren-pasar', 'sort' => 1]);

        $posts = [
            [
                'blog_category_id' => $digital->id,
                'title_id' => '5 Alasan UMKM Wajib Punya Website di 2026',
                'title_en' => '5 Reasons SMEs Need a Website in 2026',
                'slug' => '5-alasan-umkm-wajib-punya-website-2026',
                'excerpt_id' => 'Website bukan lagi sekadar pelengkap — ini alasan kenapa UMKM yang punya website tumbuh lebih cepat.',
                'excerpt_en' => 'A website is no longer optional — here is why SMEs with a website grow faster.',
                'content_id' => "Pelanggan zaman sekarang mencari bisnis lewat Google sebelum datang langsung.\n\nWebsite memberi kesan profesional, memudahkan pelanggan menemukan info penting, dan membuka peluang penjualan online tanpa batas jam toko.\n\nDengan template siap pakai, UMKM tidak perlu menunggu lama atau mengeluarkan biaya besar untuk punya kehadiran digital yang layak.",
                'content_en' => "Today's customers search for businesses on Google before visiting in person.\n\nA website gives a professional impression, makes it easy for customers to find key information, and opens online sales opportunities beyond store hours.\n\nWith ready-made templates, SMEs no longer need to wait long or spend a lot to get a decent digital presence.",
                'author' => 'Tim ConWeb',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'blog_category_id' => $digital->id,
                'title_id' => 'Cara Memilih Template Website yang Tepat untuk Bisnis Anda',
                'title_en' => 'How to Choose the Right Website Template for Your Business',
                'slug' => 'cara-memilih-template-website-tepat',
                'excerpt_id' => 'Bingung pilih template? Ikuti panduan singkat ini sebelum memutuskan.',
                'excerpt_en' => 'Confused about which template to pick? Follow this short guide before deciding.',
                'content_id' => "Mulai dari mengenali kategori bisnis Anda: ekspor, UMKM, toko online, atau korporat.\n\nPerhatikan warna dan gaya yang mencerminkan brand Anda, lalu coba fitur preview untuk melihat bagaimana konten asli akan tampil.\n\nJangan lupa, template hanyalah titik awal — konten dan foto produk yang baik tetap kunci utama.",
                'content_en' => "Start by identifying your business category: export, SME, online store, or corporate.\n\nPay attention to colors and style that reflect your brand, then use the preview feature to see how real content will look.\n\nRemember, a template is just a starting point — good content and product photos remain the key.",
                'author' => 'Tim ConWeb',
                'published_at' => now()->subDays(6),
            ],
            [
                'blog_category_id' => $market->id,
                'title_id' => 'Tren Ekspor Produk Lokal Indonesia di Pasar Global',
                'title_en' => 'Trends in Indonesian Local Product Exports in the Global Market',
                'slug' => 'tren-ekspor-produk-lokal-indonesia',
                'excerpt_id' => 'Permintaan produk lokal Indonesia terus naik — bagaimana eksportir kecil bisa ambil bagian?',
                'excerpt_en' => 'Demand for Indonesian local products keeps rising — how can small exporters get in on it?',
                'content_id' => "Produk seperti kopi, rempah, dan kerajinan tangan semakin diminati pembeli internasional.\n\nNamun kepercayaan tetap jadi hambatan utama bagi eksportir kecil. Profil ekspor yang jelas, lengkap dengan HS Code dan dokumen, membantu membangun kepercayaan itu lebih cepat.\n\nDigitalisasi profil ekspor adalah langkah awal yang murah namun berdampak besar.",
                'content_en' => "Products like coffee, spices, and handicrafts are increasingly sought after by international buyers.\n\nHowever, trust remains the main barrier for small exporters. A clear export profile, complete with HS Code and documents, helps build that trust faster.\n\nDigitalizing your export profile is a cheap yet high-impact first step.",
                'author' => 'Tim ConWeb',
                'published_at' => now()->subDays(10),
            ],
            [
                'blog_category_id' => $market->id,
                'title_id' => 'Mengapa Toko Online Kecil Perlu Sistem Pembayaran Terintegrasi',
                'title_en' => 'Why Small Online Stores Need Integrated Payment Systems',
                'slug' => 'toko-online-kecil-sistem-pembayaran',
                'excerpt_id' => 'Transaksi manual lewat chat bikin lambat dan rawan salah catat. Ini solusinya.',
                'excerpt_en' => 'Manual transactions via chat are slow and error-prone. Here is the fix.',
                'content_id' => "Mencatat pesanan secara manual mudah keliru dan menyita waktu.\n\nDengan keranjang belanja dan pembayaran terintegrasi, pelanggan bisa checkout sendiri tanpa menunggu balasan chat, dan pemilik toko punya catatan transaksi yang rapi secara otomatis.",
                'content_en' => "Recording orders manually is error-prone and time-consuming.\n\nWith an integrated cart and payment system, customers can check out themselves without waiting for a chat reply, and store owners automatically get clean transaction records.",
                'author' => 'Tim ConWeb',
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($posts as $i => $p) {
            BlogPost::create($p + ['sort' => $i, 'is_active' => true]);
        }
    }
}
