<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SeoBlogSeeder extends Seeder
{
    public function run(): void
    {
        $cat = BlogCategory::firstOrCreate(
            ['slug' => 'digitalisasi-website'],
            ['name_id' => 'Digitalisasi & Website', 'name_en' => 'Digitalization & Websites', 'sort' => 0]
        );

        $posts = [
            [
                'slug' => 'jasa-pembuatan-website-umkm',
                'title_id' => 'Jasa Pembuatan Website UMKM: Panduan & Tips Memilih (2026)',
                'title_en' => 'SME Website Development Services: A 2026 Guide',
                'excerpt_id' => 'Mau pakai jasa pembuatan website untuk UMKM? Pahami dulu jenis website, biaya, dan cara memilih partner yang tepat di panduan ini.',
                'excerpt_en' => 'Looking for SME website development services? Learn the website types, costs, and how to pick the right partner.',
                'content_id' => "Memiliki website kini jadi kebutuhan dasar bagi UMKM dan local brand. Di tengah biaya iklan dan potongan platform yang terus naik, website membuat bisnis Anda terlihat kredibel, mudah ditemukan di Google, dan tidak sepenuhnya bergantung pada marketplace.\n\nNamun banyak pelaku usaha bingung memilih jasa pembuatan website. Pertama, kenali dulu jenisnya: landing page (1 halaman untuk promosi/iklan), company profile (profil bisnis lengkap), katalog produk, hingga toko online dengan sistem pemesanan.\n\nKedua, perhatikan apa yang sudah termasuk. Jasa yang baik biasanya sudah mencakup domain, hosting, SSL, desain responsif, dan SEO dasar agar website siap di-index Google. Pastikan tidak ada biaya tersembunyi.\n\nKetiga, pilih partner yang memberi pendampingan setelah website tayang — bukan sekadar membuat lalu ditinggal. Dukungan teknis, update konten, dan maintenance penting agar website tetap berjalan optimal.\n\nDi ConWeb ID, kami membantu UMKM punya website profesional yang lengkap dan mudah dikelola, dengan harga transparan dan proses yang jelas. Konsultasikan kebutuhan bisnis Anda dan mulai bangun kehadiran digital yang benar-benar bekerja.",
                'content_en' => "Having a website is now a basic need for SMEs and local brands. As ad costs and platform fees keep rising, a website makes your business look credible, easy to find on Google, and less dependent on marketplaces.\n\nFirst, know the types: landing page, company profile, product catalog, and online store. Second, check what's included — good services bundle domain, hosting, SSL, responsive design, and basic SEO. Third, choose a partner that supports you after launch.\n\nAt ConWeb ID, we help SMEs get a complete, easy-to-manage professional website with transparent pricing. Reach out and start building a digital presence that actually works.",
                'is_featured' => true,
            ],
            [
                'slug' => 'harga-pembuatan-website-company-profile',
                'title_id' => 'Harga Pembuatan Website Company Profile 2026: Ini Rinciannya',
                'title_en' => 'Company Profile Website Pricing in 2026',
                'excerpt_id' => 'Berapa biaya bikin website company profile? Simak komponen harga, faktor yang memengaruhi, dan cara dapat harga transparan tanpa biaya tersembunyi.',
                'excerpt_en' => 'How much does a company profile website cost? See the price components and how to get transparent pricing.',
                'content_id' => "Pertanyaan paling sering dari pelaku usaha adalah: berapa harga pembuatan website company profile? Jawabannya tergantung beberapa komponen.\n\nKomponen utama meliputi domain (alamat website), hosting dan SSL (rumah dan keamanan website), desain serta jumlah halaman, dan pengerjaan oleh tim. Semakin banyak halaman dan fitur custom, semakin tinggi biayanya.\n\nYang sering luput diperhatikan adalah biaya tahunan. Domain dan hosting perlu diperpanjang setiap tahun, jadi pastikan partner Anda transparan soal biaya perpanjangan sejak awal.\n\nTips memilih: cari paket yang sudah all-in (domain, hosting, SSL, desain, dan pembuatan dalam satu harga) agar mudah dihitung dan tanpa kejutan. Hindari penawaran yang terlalu murah tapi banyak biaya tambahan tersembunyi.\n\nConWeb ID menawarkan paket pembuatan website dengan harga transparan — semua kebutuhan dasar sudah termasuk hingga website siap tayang. Hubungi kami untuk penawaran yang sesuai skala bisnis Anda.",
                'content_en' => "The most common question is: how much does a company profile website cost? It depends on several components: domain, hosting and SSL, design and number of pages, and the team's work.\n\nDon't forget annual costs — domain and hosting renew yearly, so make sure pricing is transparent upfront. Choose an all-in package to avoid hidden fees.\n\nConWeb ID offers website packages with transparent pricing — everything essential is included until your site is live. Contact us for a quote that fits your business.",
                'is_featured' => false,
            ],
            [
                'slug' => 'website-sendiri-vs-marketplace',
                'title_id' => 'Website Sendiri vs Marketplace: Mana Lebih Untung untuk Bisnis?',
                'title_en' => 'Own Website vs Marketplace: Which Is Better for Business?',
                'excerpt_id' => 'Cukup jualan di marketplace, atau perlu website sendiri? Bandingkan biaya, kepemilikan data, dan branding agar bisnis Anda lebih mandiri.',
                'excerpt_en' => 'Is a marketplace enough, or do you need your own website? Compare costs, data ownership, and branding.',
                'content_id' => "Banyak bisnis memulai dari marketplace karena praktis. Tapi seiring tumbuh, potongan komisi, persaingan harga, dan ketergantungan pada platform mulai terasa membebani.\n\nWebsite sendiri memberi keuntungan yang tidak dimiliki marketplace. Pertama, branding penuh — tampilan, cerita, dan identitas bisnis sepenuhnya milik Anda. Kedua, kepemilikan data pelanggan, sehingga Anda bisa membangun hubungan jangka panjang. Ketiga, margin lebih sehat karena tanpa potongan platform.\n\nStrategi terbaik bukan memilih salah satu, melainkan menggabungkan keduanya: gunakan marketplace untuk jangkauan, dan website sebagai 'rumah digital' yang membangun kepercayaan serta mengarahkan pelanggan ke katalog, WhatsApp, atau pemesanan langsung.\n\nDengan sosial media membawa perhatian dan website membangun kepercayaan, konten Anda bisa berubah menjadi konversi nyata. ConWeb ID siap membantu Anda membangun website yang melengkapi strategi digital bisnis Anda.",
                'content_en' => "Many businesses start on marketplaces for convenience. But as you grow, commissions, price competition, and platform dependence start to weigh you down.\n\nYour own website gives full branding, customer data ownership, and healthier margins. The best strategy is to combine both: use marketplaces for reach and your website as the 'digital home' that builds trust.\n\nConWeb ID helps you build a website that completes your digital strategy.",
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $i => $p) {
            if (BlogPost::where('slug', $p['slug'])->exists()) {
                continue;
            }
            BlogPost::create($p + [
                'blog_category_id' => $cat->id,
                'cover_image' => null,
                'author' => 'Tim ConWeb',
                'published_at' => Carbon::now()->subDays(($i + 1) * 2),
                'sort' => $i,
                'is_active' => true,
            ]);
        }
    }
}
