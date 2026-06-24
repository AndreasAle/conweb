<?php

namespace Database\Seeders;

use App\Models\{Setting, Service, ProcessStep, PortfolioItem, TechCategory, Testimonial, Faq, Stat, Logo};
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // site / meta
            'site.title'        => ['general', 'ConWeb ID — Jasa Website, Aplikasi & Sistem Custom Indonesia'],
            'site.description'  => ['general', 'ConWeb ID membantu bisnis, startup, dan UMKM membuat website, aplikasi, landing page, dashboard, sistem custom, dan otomatisasi digital yang profesional.'],
            'site.logo'         => ['general', null],
            'site.email'        => ['general', 'hello@conweb.id'],
            'site.whatsapp'     => ['general', 'https://wa.me/6280000000000'],
            'brand.name'        => ['general', 'ConWeb'],
            'brand.suffix'      => ['general', 'ID'],

            // nav
            'nav.services.id' => ['nav','Layanan'],   'nav.services.en' => ['nav','Services'],
            'nav.why.id'      => ['nav','Keunggulan'],'nav.why.en'      => ['nav','Why Us'],
            'nav.process.id'  => ['nav','Proses'],    'nav.process.en'  => ['nav','Process'],
            'nav.portfolio.id'=> ['nav','Portofolio'],'nav.portfolio.en'=> ['nav','Portfolio'],
            'nav.faq.id'      => ['nav','FAQ'],        'nav.faq.en'      => ['nav','FAQ'],
            'nav.cta.id'      => ['nav','Konsultasi Gratis'], 'nav.cta.en' => ['nav','Free Consultation'],

            // hero
            'hero.eyebrow.id' => ['hero','Penyedia Jasa Digital Solution'], 'hero.eyebrow.en' => ['hero','Digital Solution Service Provider'],
            'hero.title.id'   => ['hero',"Bangun kehadiran digital yang <span class='grad'>profesional</span> dan benar-benar bekerja."], 'hero.title.en' => ['hero',"Build a digital presence that's <span class='grad'>professional</span> and actually works."],
            'hero.desc.id'    => ['hero','ConWeb ID membantu bisnis, startup, dan UMKM membangun website, aplikasi, dashboard, dan sistem custom yang terlihat premium, berjalan cepat, dan menyelesaikan masalah operasional nyata.'], 'hero.desc.en' => ['hero','ConWeb ID helps businesses, startups, and SMEs build websites, apps, dashboards, and custom systems that look premium, run fast, and solve real operational problems.'],
            'hero.cta1.id'    => ['hero','Mulai Proyek Anda'], 'hero.cta1.en' => ['hero','Start Your Project'],
            'hero.cta2.id'    => ['hero','Lihat Portofolio'], 'hero.cta2.en' => ['hero','View Portfolio'],
            'hero.trust1.id'  => ['hero','Dipercaya 40+ klien'], 'hero.trust1.en' => ['hero','Trusted by 40+ clients'],
            'hero.trust2.id'  => ['hero','Bisnis, startup & instansi'], 'hero.trust2.en' => ['hero','Businesses, startups & institutions'],
            'hero.win.title.id'=> ['hero','Ringkasan Bisnis'], 'hero.win.title.en' => ['hero','Business Overview'],
            'hero.win.s1.id'  => ['hero','Pengunjung'], 'hero.win.s1.en' => ['hero','Visitors'],
            'hero.win.s2.id'  => ['hero','Transaksi'], 'hero.win.s2.en' => ['hero','Transactions'],
            'hero.win.s3.id'  => ['hero','Konversi'], 'hero.win.s3.en' => ['hero','Conversion'],
            'hero.float1t.id' => ['hero','Clean Code'], 'hero.float1t.en' => ['hero','Clean Code'],
            'hero.float1s.id' => ['hero','Rapi & terstruktur'], 'hero.float1s.en' => ['hero','Neat & structured'],
            'hero.float2t.id' => ['hero','Tepat Waktu'], 'hero.float2t.en' => ['hero','On Time'],
            'hero.float2s.id' => ['hero','Delivery sesuai jadwal'], 'hero.float2s.en' => ['hero','Delivery on schedule'],

            // logos title
            'logos.title.id'  => ['logos','Teknologi modern yang kami gunakan setiap hari'], 'logos.title.en' => ['logos','Modern technologies we use every day'],

            // services head
            'services.eyebrow.id' => ['services','Layanan Kami'], 'services.eyebrow.en' => ['services','Our Services'],
            'services.title.id'   => ['services','Satu partner untuk semua kebutuhan digital Anda'], 'services.title.en' => ['services','One partner for all your digital needs'],
            'services.lead.id'    => ['services','Dari website hingga sistem internal yang kompleks, kami menangani desain, pengembangan, hingga integrasi dengan pendekatan yang terstruktur dan scalable.'], 'services.lead.en' => ['services','From websites to complex internal systems, we handle design, development, and integration with a structured and scalable approach.'],

            // why head + visual
            'why.eyebrow.id' => ['why','Kenapa ConWeb ID'], 'why.eyebrow.en' => ['why','Why ConWeb ID'],
            'why.title.id'   => ['why','Kami tidak sekadar membuat tampilan, kami membangun sistem yang bekerja'], 'why.title.en' => ['why',"We don't just build interfaces, we build systems that work"],
            'why.lead.id'    => ['why','Setiap proyek kami garap dengan menggabungkan eksekusi teknis, cara pikir bisnis, dan sensitivitas desain — agar hasilnya bukan hanya indah, tapi benar-benar berguna.'], 'why.lead.en' => ['why','Every project combines technical execution, business thinking, and design sensitivity — so the result isn\'t just beautiful, but truly useful.'],
            'why.p1t.id'=>['why','Desain Premium'], 'why.p1t.en'=>['why','Premium Design'],
            'why.p1d.id'=>['why','Layout modern, responsif, dan identitas visual yang kuat untuk meningkatkan kepercayaan brand Anda.'], 'why.p1d.en'=>['why','Modern, responsive layouts and a strong visual identity to build trust in your brand.'],
            'why.p2t.id'=>['why','Struktur Backend Solid'], 'why.p2t.en'=>['why','Solid Backend Structure'],
            'why.p2d.id'=>['why','Alur auth, CRUD, API, dan reporting yang rapi serta mudah dipelihara dan dikembangkan.'], 'why.p2d.en'=>['why','Clean auth, CRUD, API, and reporting flows that are easy to maintain and scale.'],
            'why.p3t.id'=>['why','Berorientasi Bisnis'], 'why.p3t.en'=>['why','Business-Oriented'],
            'why.p3d.id'=>['why','Fitur dirancang berdasarkan alur pengguna, efisiensi, dan konversi — bukan sekadar fitur acak.'], 'why.p3d.en'=>['why','Features designed around user flow, efficiency, and conversion — not random functionality.'],
            'why.p4t.id'=>['why','Support & Maintenance'], 'why.p4t.en'=>['why','Support & Maintenance'],
            'why.p4d.id'=>['why','Pendampingan setelah rilis: perbaikan, optimasi, dan penambahan fitur saat bisnis Anda tumbuh.'], 'why.p4d.en'=>['why','Post-launch support: fixes, optimization, and new features as your business grows.'],
            'why.quote.id'=>['why','ConWeb mampu mengubah ide bisnis yang masih kasar menjadi sistem digital yang rapi dan nyaman dipakai. Hasilnya terasa jauh lebih premium dari yang kami bayangkan.'], 'why.quote.en'=>['why','ConWeb turned our rough business idea into a clean, easy-to-use digital system. The result felt far more premium than we imagined.'],
            'why.authorName'=>['why','Rizky Pratama'],
            'why.author.id'=>['why','Founder · Retail Business'], 'why.author.en'=>['why','Founder · Retail Business'],
            'why.mini1v'=>['why','98%'], 'why.mini1.id'=>['why','Klien kembali lagi'], 'why.mini1.en'=>['why','Clients who return'],
            'why.mini2v'=>['why','2 mgg'], 'why.mini2.id'=>['why','Rata-rata mulai proyek'], 'why.mini2.en'=>['why','Avg. time to kick off'],

            // process head
            'process.eyebrow.id'=>['process','Cara Kerja Kami'], 'process.eyebrow.en'=>['process','How We Work'],
            'process.title.id'=>['process','Proses yang jelas, terstruktur, dan fokus pada hasil'], 'process.title.en'=>['process',"A process that's clear, structured, and results-focused"],
            'process.lead.id'=>['process','Setiap tahap punya tujuan, sehingga produk akhir lebih mudah diuji, ditingkatkan, dan dikembangkan.'], 'process.lead.en'=>['process','Every stage has a purpose, making the final product easier to test, improve, and grow.'],

            // portfolio head
            'pf.eyebrow.id'=>['portfolio','Portofolio'], 'pf.eyebrow.en'=>['portfolio','Portfolio'],
            'pf.title.id'=>['portfolio','Karya yang menyelesaikan tantangan bisnis nyata'], 'pf.title.en'=>['portfolio','Work that solves real business challenges'],
            'pf.lead.id'=>['portfolio','Kombinasi kualitas UI, logika, otomatisasi, dan fungsi yang benar-benar siap dipakai sehari-hari.'], 'pf.lead.en'=>['portfolio',"A mix of UI quality, logic, automation, and functionality that's truly ready for daily use."],

            // tech head
            'tech.eyebrow.id'=>['tech','Tech Stack'], 'tech.eyebrow.en'=>['tech','Tech Stack'],
            'tech.title.id'=>['tech','Teknologi modern untuk hasil yang cepat & terukur'], 'tech.title.en'=>['tech','Modern technology for fast, measurable results'],
            'tech.lead.id'=>['tech','Kami memilih tools yang membantu bergerak cepat tanpa mengorbankan struktur dan kualitas produk.'], 'tech.lead.en'=>['tech','We choose tools that help us move fast without sacrificing structure or product quality.'],

            // testimonials head
            'testi.eyebrow.id'=>['testimonials','Testimoni'], 'testi.eyebrow.en'=>['testimonials','Testimonials'],
            'testi.title.id'=>['testimonials','Apa kata klien tentang kami'], 'testi.title.en'=>['testimonials','What our clients say'],
            'testi.lead.id'=>['testimonials','Kepercayaan klien adalah hasil dari komunikasi yang jelas dan produk yang benar-benar bekerja.'], 'testi.lead.en'=>['testimonials','Client trust comes from clear communication and products that genuinely work.'],

            // faq head
            'faq.title.id'=>['faq','Pertanyaan yang sering ditanyakan'], 'faq.title.en'=>['faq','Frequently asked questions'],
            'faq.lead.id'=>['faq','Belum menemukan jawabannya? Hubungi kami langsung dan tim kami siap membantu.'], 'faq.lead.en'=>['faq',"Can't find your answer? Reach out and our team is ready to help."],

            // contact / cta
            'contact.eyebrow.id'=>['contact','Mulai Sekarang'], 'contact.eyebrow.en'=>['contact','Get Started'],
            'contact.title.id'=>['contact','Siap membangun sesuatu yang powerful?'], 'contact.title.en'=>['contact','Ready to build something powerful?'],
            'contact.desc.id'=>['contact','Ceritakan kebutuhan digital Anda. Kami siap membantu mewujudkan website, aplikasi, dashboard, atau sistem custom untuk brand, startup, dan UMKM.'], 'contact.desc.en'=>['contact','Tell us your digital needs. We\'re ready to help build the website, app, dashboard, or custom system for your brand, startup, or SME.'],
            'contact.cta1.id'=>['contact','Konsultasi via Email'], 'contact.cta1.en'=>['contact','Email Consultation'],
            'contact.cta2.id'=>['contact','Chat via WhatsApp'], 'contact.cta2.en'=>['contact','Chat on WhatsApp'],

            // footer
            'foot.desc.id'=>['footer','Partner solusi digital untuk bisnis yang ingin tumbuh — website, aplikasi, sistem custom, dan otomatisasi.'], 'foot.desc.en'=>['footer','Digital solutions partner for growing businesses — websites, apps, custom systems, and automation.'],
            'foot.c1.id'=>['footer','Layanan'], 'foot.c1.en'=>['footer','Services'],
            'foot.c1a.id'=>['footer','Website Development'], 'foot.c1a.en'=>['footer','Website Development'],
            'foot.c1b.id'=>['footer','Aplikasi Web & Mobile'], 'foot.c1b.en'=>['footer','Web & Mobile Apps'],
            'foot.c1c.id'=>['footer','Sistem Custom'], 'foot.c1c.en'=>['footer','Custom Systems'],
            'foot.c1d.id'=>['footer','AI & Otomatisasi'], 'foot.c1d.en'=>['footer','AI & Automation'],
            'foot.c2.id'=>['footer','Perusahaan'], 'foot.c2.en'=>['footer','Company'],
            'foot.c2a.id'=>['footer','Keunggulan'], 'foot.c2a.en'=>['footer','Why Us'],
            'foot.c2b.id'=>['footer','Proses Kerja'], 'foot.c2b.en'=>['footer','Our Process'],
            'foot.c2c.id'=>['footer','Portofolio'], 'foot.c2c.en'=>['footer','Portfolio'],
            'foot.c2d.id'=>['footer','FAQ'], 'foot.c2d.en'=>['footer','FAQ'],
            'foot.c3.id'=>['footer','Kontak'], 'foot.c3.en'=>['footer','Contact'],
            'foot.c3c.id'=>['footer','Jakarta, Indonesia'], 'foot.c3c.en'=>['footer','Jakarta, Indonesia'],
            'foot.rights.id'=>['footer','Semua hak dilindungi.'], 'foot.rights.en'=>['footer','All rights reserved.'],
            'foot.made.id'=>['footer','Dibangun dengan presisi'], 'foot.made.en'=>['footer','Built with precision'],
            'foot.copyrightYear'=>['footer','2026'],
            'social.github'=>['footer','#'],
            'social.linkedin'=>['footer','#'],
            'social.instagram'=>['footer','#'],
        ];

        foreach ($settings as $key => [$group, $value]) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }

        // ---- Collections ----
        Service::truncate();
        $services = [
            ['icon'=>'web','title_id'=>'Website Development','title_en'=>'Website Development','desc_id'=>'Company profile, landing page, dan website commerce yang dirancang agar bisnis terlihat kredibel dan mudah menghasilkan konversi.','desc_en'=>'Company profiles, landing pages, and commerce sites designed to make your business look credible and convert better.','features'=>[
                ['id'=>'Landing page dengan alur konversi yang kuat','en'=>'Landing pages with strong conversion flow'],
                ['id'=>'Company profile & website brand yang elegan','en'=>'Elegant company profile & brand websites'],
                ['id'=>'Optimasi performa & SEO dasar','en'=>'Performance optimization & basic SEO'],
            ]],
            ['icon'=>'app','title_id'=>'Aplikasi Web & Mobile','title_en'=>'Web & Mobile Apps','desc_id'=>'Aplikasi dan sistem mobile-friendly yang menyederhanakan alur kerja, mempermudah akses, dan membantu pengguna menyelesaikan tugas lebih cepat.','desc_en'=>'Mobile-friendly apps and systems built to simplify workflows, improve access, and help users complete tasks faster.','features'=>[
                ['id'=>'Aplikasi booking, order, member & layanan','en'=>'Booking, order, member & service apps'],
                ['id'=>'Dashboard multi-role & manajemen pengguna','en'=>'Multi-role dashboards & user management'],
                ['id'=>'Tampilan mobile-first untuk jangkauan luas','en'=>'Mobile-first interface for wider reach'],
            ]],
            ['icon'=>'system','title_id'=>'Sistem Custom & Internal Tools','title_en'=>'Custom Systems & Internal Tools','desc_id'=>'Sistem internal custom untuk mengelola data, operasional, laporan, dan logika bisnis secara lebih efisien dan terukur.','desc_en'=>'Tailor-made internal systems to manage data, operations, reports, and business logic more efficiently.','features'=>[
                ['id'=>'Inventory, keuangan, reporting & operasional','en'=>'Inventory, finance, reporting & operations'],
                ['id'=>'Integrasi API & sinkronisasi spreadsheet','en'=>'API integration & spreadsheet sync'],
                ['id'=>'Struktur scalable untuk penambahan fitur','en'=>'Scalable structure for future features'],
            ]],
            ['icon'=>'ai','title_id'=>'AI & Otomatisasi','title_en'=>'AI & Automation','desc_id'=>'Integrasi AI dan otomatisasi workflow untuk memangkas pekerjaan manual, mempercepat proses, dan meningkatkan akurasi operasional.','desc_en'=>'AI integration and workflow automation to cut manual work, speed up processes, and improve operational accuracy.','features'=>[
                ['id'=>'Chatbot & asisten berbasis AI','en'=>'AI-powered chatbots & assistants'],
                ['id'=>'Otomatisasi laporan & notifikasi','en'=>'Automated reports & notifications'],
                ['id'=>'Integrasi tools & workflow bisnis','en'=>'Tools & business workflow integration'],
            ]],
        ];
        foreach ($services as $i => $s) { Service::create($s + ['sort' => $i]); }

        ProcessStep::truncate();
        $steps = [
            ['number'=>'01','title_id'=>'Discovery','title_en'=>'Discovery','desc_id'=>'Memahami masalah bisnis, target pengguna, dan hasil apa yang benar-benar penting bagi Anda.','desc_en'=>'Understand the business problem, target users, and what outcome truly matters to you.'],
            ['number'=>'02','title_id'=>'Desain & Struktur','title_en'=>'Design & Structure','desc_id'=>'Menyusun flow, logika data, dan tampilan sebelum masuk ke tahap pengembangan.','desc_en'=>'Map out flow, data logic, and layout before moving into development.'],
            ['number'=>'03','title_id'=>'Development','title_en'=>'Development','desc_id'=>'Membangun UI responsif, logika backend, fitur, validasi, dan integrasi dalam struktur rapi.','desc_en'=>'Build responsive UI, backend logic, features, validation, and integrations cleanly.'],
            ['number'=>'04','title_id'=>'Launch & Support','title_en'=>'Launch & Support','desc_id'=>'Memoles UX & performa, peluncuran, lalu pendampingan agar produk terus berkembang.','desc_en'=>'Polish UX & performance, launch, then support so the product keeps evolving.'],
        ];
        foreach ($steps as $i => $s) { ProcessStep::create($s + ['sort' => $i]); }

        PortfolioItem::truncate();
        $pf = [
            ['icon'=>'grid','size'=>'xl','category_id'=>'SaaS / Platform Produktivitas','category_en'=>'SaaS / Productivity Platform','title'=>'TrackerTask','desc_id'=>'Platform manajemen task & performa dengan akses multi-role, struktur proyek, logika dashboard, dan arsitektur scalable untuk tim dan operasional bisnis.','desc_en'=>'Task & performance management platform with multi-role access, project structure, dashboard logic, and scalable architecture for teams and operations.','tags'=>['Laravel','Next.js','Realtime','Role Permission'],'gradient'=>'linear-gradient(135deg,#1d4ed8,#0a1530)'],
            ['icon'=>'cart','size'=>'md','category_id'=>'Digital Commerce','category_en'=>'Digital Commerce','title'=>'GORShop','desc_id'=>'Platform commerce dengan sistem deposit, alur invoice, dan integrasi pembayaran.','desc_en'=>'Commerce platform with deposit system, invoice flow, and payment integration.','tags'=>['Laravel','Payments','UX'],'gradient'=>'linear-gradient(135deg,#0ea5e9,#0a1530)'],
            ['icon'=>'chart','size'=>'sm','category_id'=>'Inventory & Laporan','category_en'=>'Inventory & Reporting','title'=>'Stock Management','desc_id'=>'Sistem inventory & laporan pajak dengan validasi stok dan generate laporan.','desc_en'=>'Inventory & tax reporting system with stock validation and report generation.','tags'=>['CodeIgniter','MySQL'],'gradient'=>'linear-gradient(135deg,#28406e,#0a1530)'],
            ['icon'=>'award','size'=>'sm','category_id'=>'Penjurian & Sertifikat','category_en'=>'Judging & Certificates','title'=>'Bonsai Competition','desc_id'=>'Sistem penjurian berbasis web: scoring, rekap, ranking, lookup QR, dan sertifikat cetak.','desc_en'=>'Web-based judging system: scoring, recap, ranking, QR lookup, and printable certificates.','tags'=>['CodeIgniter','PDF','QR'],'gradient'=>'linear-gradient(135deg,#1d4ed8,#0a1530)'],
            ['icon'=>'check-sq','size'=>'md','category_id'=>'Secure Voting','category_en'=>'Secure Voting','title'=>'E-Voting System','desc_id'=>'Sistem voting berbasis voucher dengan validasi, sinkron spreadsheet, dan hasil realtime.','desc_en'=>'Voucher-based voting system with validation, spreadsheet sync, and realtime results.','tags'=>['Next.js','Apps Script','Realtime'],'gradient'=>'linear-gradient(135deg,#0ea5e9,#0a1530)'],
        ];
        foreach ($pf as $i => $p) { PortfolioItem::create($p + ['sort' => $i]); }

        TechCategory::truncate();
        $tech = [
            ['icon'=>'frontend','title_id'=>'Frontend','title_en'=>'Frontend','pills'=>['React','Next.js','TypeScript','Tailwind','HTML/CSS']],
            ['icon'=>'backend','title_id'=>'Backend','title_en'=>'Backend','pills'=>['Laravel','Node.js','Express','PHP','REST API']],
            ['icon'=>'database','title_id'=>'Database & Tools','title_en'=>'Database & Tools','pills'=>['MySQL','PostgreSQL','Git','GitHub','Figma']],
            ['icon'=>'deploy','title_id'=>'Deployment','title_en'=>'Deployment','pills'=>['Ubuntu VPS','Nginx','PM2','Cloud','CI/CD']],
        ];
        foreach ($tech as $i => $t) { TechCategory::create($t + ['sort' => $i]); }

        Testimonial::truncate();
        $testi = [
            ['quote_id'=>'"Andreas dan tim mampu mengubah ide bisnis kasar menjadi sistem digital yang rapi dan mudah dipakai. Hasilnya terasa jauh lebih premium dari ekspektasi kami."','quote_en'=>'"Andreas and the team turned a rough business idea into a clean, easy-to-use digital system. It felt far more premium than we expected."','name'=>'Rizky','role_id'=>'Business Owner','role_en'=>'Business Owner','avatar_letter'=>'R','gradient'=>'linear-gradient(135deg,#3b82f6,#1d4ed8)'],
            ['quote_id'=>'"Cepat dalam eksekusi, enak diajak diskusi, dan sangat solution-oriented. Bukan cuma coding, tapi benar-benar memikirkan alur kerja kami."','quote_en'=>'"Fast execution, easy to discuss with, and very solution-oriented. Not just coding, but really thinking through our workflow."','name'=>'Dina','role_id'=>'Project Client','role_en'=>'Project Client','avatar_letter'=>'D','gradient'=>'linear-gradient(135deg,#38bdf8,#0ea5e9)'],
            ['quote_id'=>'"Interface-nya modern dan logika backend-nya terstruktur. Sistemnya nyaman dipakai untuk operasional harian tim kami."','quote_en'=>'"The interface looked modern and the backend logic was structured. The system is comfortable for our daily operations."','name'=>'Aditya','role_id'=>'Operations Team','role_en'=>'Operations Team','avatar_letter'=>'A','gradient'=>'linear-gradient(135deg,#6366f1,#4338ca)'],
        ];
        foreach ($testi as $i => $t) { Testimonial::create($t + ['sort' => $i]); }

        Faq::truncate();
        $faqs = [
            ['question_id'=>'Jenis proyek apa saja yang biasa dikerjakan?','question_en'=>'What kind of projects do you usually handle?','answer_id'=>'Mulai dari website company profile, dashboard admin, sistem bisnis, internal tools, e-commerce, sistem reporting, hingga platform custom yang butuh kualitas frontend sekaligus logika backend.','answer_en'=>'From company profile websites, admin dashboards, business systems, internal tools, e-commerce, and reporting systems to custom platforms needing both frontend quality and backend logic.'],
            ['question_id'=>'Apakah desain dan teknis dikerjakan sekaligus?','question_en'=>'Do you handle both design and technical work?','answer_id'=>'Ya. Kekuatan kami adalah menggabungkan presentasi visual premium dengan struktur teknis yang nyata, sehingga hasilnya menarik sekaligus praktis dan mudah dipelihara.','answer_en'=>'Yes. Our strength is combining premium visual presentation with real technical structure, so the result is attractive yet practical and maintainable.'],
            ['question_id'=>'Bisa lanjutkan proyek yang sudah ada?','question_en'=>'Can you continue an existing project?','answer_id'=>'Bisa. Kami dapat meningkatkan proyek yang sudah ada, redesign interface, menambah fitur, memperbaiki logika, mengoptimalkan workflow, atau membangun produk penuh dari nol.','answer_en'=>'Yes. We can improve existing projects, redesign interfaces, add features, fix logic, optimize workflows, or build a full product from scratch.'],
            ['question_id'=>'Berapa lama waktu pengerjaan sebuah proyek?','question_en'=>'How long does a project take?','answer_id'=>'Tergantung kompleksitas. Landing page bisa 1–2 minggu, sementara sistem custom membutuhkan beberapa minggu. Estimasi pasti kami berikan setelah sesi discovery awal.','answer_en'=>'It depends on complexity. A landing page can take 1–2 weeks, while custom systems take several weeks. We give a firm estimate after the initial discovery session.'],
            ['question_id'=>'Apakah hasilnya responsif di mobile & tablet?','question_en'=>'Is the result responsive on mobile & tablet?','answer_id'=>'Ya. Struktur responsif selalu menjadi bagian dari setiap build, sehingga produk tetap nyaman digunakan di desktop, tablet, maupun mobile.','answer_en'=>'Yes. Responsive structure is always part of every build, so the product stays comfortable on desktop, tablet, and mobile.'],
        ];
        foreach ($faqs as $i => $f) { Faq::create($f + ['sort' => $i]); }

        Stat::truncate();
        $stats = [
            ['value'=>'120','suffix'=>'+','label_id'=>'Proyek selesai','label_en'=>'Projects delivered'],
            ['value'=>'40','suffix'=>'+','label_id'=>'Klien dilayani','label_en'=>'Clients served'],
            ['value'=>'5','suffix'=>'+','label_id'=>'Tahun pengalaman','label_en'=>'Years experience'],
            ['value'=>'4.9','suffix'=>'/5','label_id'=>'Rating kepuasan','label_en'=>'Satisfaction rating'],
        ];
        foreach ($stats as $i => $s) { Stat::create($s + ['sort' => $i]); }

        Logo::truncate();
        foreach (['Next.js','React','Laravel','Node.js','TypeScript','MySQL','Tailwind','PostgreSQL'] as $i => $name) {
            Logo::create(['name' => $name, 'sort' => $i]);
        }
    }
}
