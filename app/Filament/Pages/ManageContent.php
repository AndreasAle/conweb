<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Konten Website';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Konten Website (Teks & Brand)';

    protected static string $view = 'filament.pages.manage-content';

    public ?array $data = [];

    /** Map sanitized field name <-> setting key (dots not allowed in field names). */
    public static function k(string $key): string
    {
        return str_replace('.', '__', $key);
    }

    public function mount(): void
    {
        $all = Setting::all_cached();
        $state = [];
        foreach ($all as $key => $value) {
            $state[self::k($key)] = $value;
        }
        $this->form->fill($state);
    }

    /** [tabLabel => [ [key, label, type], ... ]] */
    protected function fieldMap(): array
    {
        $t = fn ($key, $label, $type = 'text') => compact('key', 'label', 'type');

        return [
            'Brand & SEO' => [
                $t('site.title', 'Judul / Title SEO'),
                $t('site.description', 'Meta Description', 'area'),
                $t('brand.name', 'Nama Brand'),
                $t('brand.suffix', 'Suffix Brand (mis. ID)'),
                $t('site.logo', 'Logo (gambar)', 'image'),
                $t('site.favicon', 'Favicon (.ico / .png, persegi)', 'image'),
                $t('site.email', 'Email Kontak'),
                $t('site.whatsapp', 'Link WhatsApp'),
            ],
            'Navbar' => [
                $t('nav.services.id', 'Menu Layanan (ID)'), $t('nav.services.en', 'Menu Layanan (EN)'),
                $t('nav.why.id', 'Menu Keunggulan (ID)'), $t('nav.why.en', 'Menu Keunggulan (EN)'),
                $t('nav.process.id', 'Menu Proses (ID)'), $t('nav.process.en', 'Menu Proses (EN)'),
                $t('nav.portfolio.id', 'Menu Portofolio (ID)'), $t('nav.portfolio.en', 'Menu Portofolio (EN)'),
                $t('nav.faq.id', 'Menu FAQ (ID)'), $t('nav.faq.en', 'Menu FAQ (EN)'),
                $t('nav.cta.id', 'Tombol CTA (ID)'), $t('nav.cta.en', 'Tombol CTA (EN)'),
            ],
            'Hero (Fallback)' => [
                $t('hero.eyebrow.id', 'Eyebrow (ID)'), $t('hero.eyebrow.en', 'Eyebrow (EN)'),
                $t('hero.title.id', 'Judul (ID) — boleh HTML', 'area'), $t('hero.title.en', 'Judul (EN) — boleh HTML', 'area'),
                $t('hero.desc.id', 'Deskripsi (ID)', 'area'), $t('hero.desc.en', 'Deskripsi (EN)', 'area'),
                $t('hero.cta1.id', 'Tombol 1 (ID)'), $t('hero.cta1.en', 'Tombol 1 (EN)'),
                $t('hero.cta2.id', 'Tombol 2 (ID)'), $t('hero.cta2.en', 'Tombol 2 (EN)'),
            ],
            'Heading Seksi' => [
                $t('designs.eyebrow.id', 'Koleksi Desain Eyebrow (ID)'), $t('designs.eyebrow.en', 'Koleksi Desain Eyebrow (EN)'),
                $t('designs.title.id', 'Koleksi Desain Judul (ID) — boleh tag <em>', 'area'), $t('designs.title.en', 'Koleksi Desain Judul (EN) — boleh tag <em>', 'area'),
                $t('designs.lead.id', 'Koleksi Desain Lead (ID)', 'area'), $t('designs.lead.en', 'Koleksi Desain Lead (EN)', 'area'),
                $t('pricing.eyebrow.id', 'Paket Domain Eyebrow (ID)'), $t('pricing.eyebrow.en', 'Paket Domain Eyebrow (EN)'),
                $t('pricing.title.id', 'Paket Domain Judul (ID) — boleh tag <em>', 'area'), $t('pricing.title.en', 'Paket Domain Judul (EN) — boleh tag <em>', 'area'),
                $t('pricing.lead.id', 'Paket Domain Lead (ID)', 'area'), $t('pricing.lead.en', 'Paket Domain Lead (EN)', 'area'),
                $t('pricing.other_tlds', 'TLD Lain (pisah koma)'),
                $t('logos.title.id', 'Logo Strip Judul (ID)'), $t('logos.title.en', 'Logo Strip Judul (EN)'),
                $t('services.eyebrow.id', 'Services Eyebrow (ID)'), $t('services.eyebrow.en', 'Services Eyebrow (EN)'),
                $t('services.title.id', 'Services Judul (ID)'), $t('services.title.en', 'Services Judul (EN)'),
                $t('services.lead.id', 'Services Lead (ID)', 'area'), $t('services.lead.en', 'Services Lead (EN)', 'area'),
                $t('process.eyebrow.id', 'Process Eyebrow (ID)'), $t('process.eyebrow.en', 'Process Eyebrow (EN)'),
                $t('process.title.id', 'Process Judul (ID)'), $t('process.title.en', 'Process Judul (EN)'),
                $t('process.lead.id', 'Process Lead (ID)', 'area'), $t('process.lead.en', 'Process Lead (EN)', 'area'),
                $t('pf.eyebrow.id', 'Portfolio Eyebrow (ID)'), $t('pf.eyebrow.en', 'Portfolio Eyebrow (EN)'),
                $t('pf.title.id', 'Portfolio Judul (ID)'), $t('pf.title.en', 'Portfolio Judul (EN)'),
                $t('pf.lead.id', 'Portfolio Lead (ID)', 'area'), $t('pf.lead.en', 'Portfolio Lead (EN)', 'area'),
                $t('tech.eyebrow.id', 'Tech Eyebrow (ID)'), $t('tech.eyebrow.en', 'Tech Eyebrow (EN)'),
                $t('tech.title.id', 'Tech Judul (ID)'), $t('tech.title.en', 'Tech Judul (EN)'),
                $t('tech.lead.id', 'Tech Lead (ID)', 'area'), $t('tech.lead.en', 'Tech Lead (EN)', 'area'),
                $t('testi.eyebrow.id', 'Testimoni Eyebrow (ID)'), $t('testi.eyebrow.en', 'Testimoni Eyebrow (EN)'),
                $t('testi.title.id', 'Testimoni Judul (ID)'), $t('testi.title.en', 'Testimoni Judul (EN)'),
                $t('testi.lead.id', 'Testimoni Lead (ID)', 'area'), $t('testi.lead.en', 'Testimoni Lead (EN)', 'area'),
                $t('faq.title.id', 'FAQ Judul (ID)'), $t('faq.title.en', 'FAQ Judul (EN)'),
                $t('faq.lead.id', 'FAQ Lead (ID)', 'area'), $t('faq.lead.en', 'FAQ Lead (EN)', 'area'),
            ],
            'Why / Keunggulan' => [
                $t('why.eyebrow.id', 'Eyebrow (ID)'), $t('why.eyebrow.en', 'Eyebrow (EN)'),
                $t('why.title.id', 'Judul (ID)', 'area'), $t('why.title.en', 'Judul (EN)', 'area'),
                $t('why.lead.id', 'Lead (ID)', 'area'), $t('why.lead.en', 'Lead (EN)', 'area'),
                $t('why.p1t.id', 'Poin 1 Judul (ID)'), $t('why.p1t.en', 'Poin 1 Judul (EN)'),
                $t('why.p1d.id', 'Poin 1 Desk (ID)', 'area'), $t('why.p1d.en', 'Poin 1 Desk (EN)', 'area'),
                $t('why.p2t.id', 'Poin 2 Judul (ID)'), $t('why.p2t.en', 'Poin 2 Judul (EN)'),
                $t('why.p2d.id', 'Poin 2 Desk (ID)', 'area'), $t('why.p2d.en', 'Poin 2 Desk (EN)', 'area'),
                $t('why.p3t.id', 'Poin 3 Judul (ID)'), $t('why.p3t.en', 'Poin 3 Judul (EN)'),
                $t('why.p3d.id', 'Poin 3 Desk (ID)', 'area'), $t('why.p3d.en', 'Poin 3 Desk (EN)', 'area'),
                $t('why.p4t.id', 'Poin 4 Judul (ID)'), $t('why.p4t.en', 'Poin 4 Judul (EN)'),
                $t('why.p4d.id', 'Poin 4 Desk (ID)', 'area'), $t('why.p4d.en', 'Poin 4 Desk (EN)', 'area'),
                $t('why.quote.id', 'Quote (ID)', 'area'), $t('why.quote.en', 'Quote (EN)', 'area'),
                $t('why.authorName', 'Nama Penulis Quote'),
                $t('why.author.id', 'Peran Penulis (ID)'), $t('why.author.en', 'Peran Penulis (EN)'),
                $t('why.mini1v', 'Mini Stat 1 Angka'), $t('why.mini1.id', 'Mini Stat 1 Label (ID)'), $t('why.mini1.en', 'Mini Stat 1 Label (EN)'),
                $t('why.mini2v', 'Mini Stat 2 Angka'), $t('why.mini2.id', 'Mini Stat 2 Label (ID)'), $t('why.mini2.en', 'Mini Stat 2 Label (EN)'),
            ],
            'CTA / Kontak' => [
                $t('contact.eyebrow.id', 'Eyebrow (ID)'), $t('contact.eyebrow.en', 'Eyebrow (EN)'),
                $t('contact.title.id', 'Judul (ID)'), $t('contact.title.en', 'Judul (EN)'),
                $t('contact.desc.id', 'Deskripsi (ID)', 'area'), $t('contact.desc.en', 'Deskripsi (EN)', 'area'),
                $t('contact.cta1.id', 'Tombol 1 (ID)'), $t('contact.cta1.en', 'Tombol 1 (EN)'),
                $t('contact.cta2.id', 'Tombol 2 (ID)'), $t('contact.cta2.en', 'Tombol 2 (EN)'),
            ],
            'Footer' => [
                $t('foot.desc.id', 'Deskripsi (ID)', 'area'), $t('foot.desc.en', 'Deskripsi (EN)', 'area'),
                $t('foot.c1.id', 'Kolom 1 Judul (ID)'), $t('foot.c1.en', 'Kolom 1 Judul (EN)'),
                $t('foot.c1a.id', 'Kolom 1 Link A (ID)'), $t('foot.c1a.en', 'Kolom 1 Link A (EN)'),
                $t('foot.c1b.id', 'Kolom 1 Link B (ID)'), $t('foot.c1b.en', 'Kolom 1 Link B (EN)'),
                $t('foot.c1c.id', 'Kolom 1 Link C (ID)'), $t('foot.c1c.en', 'Kolom 1 Link C (EN)'),
                $t('foot.c1d.id', 'Kolom 1 Link D (ID)'), $t('foot.c1d.en', 'Kolom 1 Link D (EN)'),
                $t('foot.c2.id', 'Kolom 2 Judul (ID)'), $t('foot.c2.en', 'Kolom 2 Judul (EN)'),
                $t('foot.c2a.id', 'Kolom 2 Link A (ID)'), $t('foot.c2a.en', 'Kolom 2 Link A (EN)'),
                $t('foot.c2b.id', 'Kolom 2 Link B (ID)'), $t('foot.c2b.en', 'Kolom 2 Link B (EN)'),
                $t('foot.c2c.id', 'Kolom 2 Link C (ID)'), $t('foot.c2c.en', 'Kolom 2 Link C (EN)'),
                $t('foot.c2d.id', 'Kolom 2 Link D (ID)'), $t('foot.c2d.en', 'Kolom 2 Link D (EN)'),
                $t('foot.c3.id', 'Kolom 3 Judul (ID)'), $t('foot.c3.en', 'Kolom 3 Judul (EN)'),
                $t('foot.c3c.id', 'Kolom 3 Lokasi (ID)'), $t('foot.c3c.en', 'Kolom 3 Lokasi (EN)'),
                $t('foot.rights.id', 'Hak Cipta (ID)'), $t('foot.rights.en', 'Hak Cipta (EN)'),
                $t('foot.made.id', 'Made With (ID)'), $t('foot.made.en', 'Made With (EN)'),
                $t('foot.copyrightYear', 'Tahun Copyright'),
                $t('social.github', 'URL GitHub'),
                $t('social.linkedin', 'URL LinkedIn'),
                $t('social.instagram', 'URL Instagram'),
            ],
            'Order & Harga Paket' => [
                $t('order.launch_price', 'ConWeb Launch — Web Baru (Rp)'),
                $t('order.care_price', 'ConWeb Care — Perpanjangan / Tahun (Rp)'),
                $t('order.signature_divisor', 'Signature — Pembagi Harga (modal ÷ ?)'),
                $t('order.hosting_per_year', 'Komponen Hosting + SSL / Tahun (Rp)'),
                $t('order.admin_fee', 'Biaya Admin Sekali Bayar (Rp)'),
            ],
        ];
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach ($this->fieldMap() as $label => $fields) {
            $components = [];
            foreach ($fields as $f) {
                $name = self::k($f['key']);
                $components[] = match ($f['type']) {
                    'area'  => Textarea::make($name)->label($f['label'])->rows(2),
                    'image' => FileUpload::make($name)->label($f['label'])->image()->directory('brand')->imageEditor(),
                    default => TextInput::make($name)->label($f['label']),
                };
            }
            $tabs[] = Tabs\Tab::make($label)->schema($components)->columns(2);
        }

        return $form->schema([Tabs::make('Konten')->tabs($tabs)])->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        foreach ($state as $name => $value) {
            $key = str_replace('__', '.', $name);
            Setting::put($key, is_array($value) ? json_encode($value) : $value);
        }

        Notification::make()->title('Konten berhasil disimpan')->success()->send();
    }
}
