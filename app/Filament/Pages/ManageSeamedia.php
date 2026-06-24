<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSeamedia extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Seamedia ConWeb';
    protected static ?string $navigationLabel = 'Konten & Teks';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Konten Seamedia ConWeb';

    protected static string $view = 'filament.pages.manage-seamedia';

    public ?array $data = [];

    public static function k(string $key): string
    {
        return str_replace('.', '__', $key);
    }

    /** Daftar field: [tab => [ [key, label, type] ]] */
    protected function fieldMap(): array
    {
        $t = fn ($key, $label, $type = 'text') => compact('key', 'label', 'type');

        return [
            'Hero' => [
                $t('seamedia.hero_eyebrow', 'Eyebrow (label kecil atas)'),
                $t('seamedia.hero_title', 'Judul Hero', 'area'),
                $t('seamedia.hero_desc', 'Deskripsi Hero', 'area'),
            ],
            'Statistik' => [
                $t('seamedia.stat1_value', 'Statistik 1 — Angka'),
                $t('seamedia.stat1_label', 'Statistik 1 — Label'),
                $t('seamedia.stat2_value', 'Statistik 2 — Angka'),
                $t('seamedia.stat2_label', 'Statistik 2 — Label'),
                $t('seamedia.stat3_value', 'Statistik 3 — Angka'),
                $t('seamedia.stat3_label', 'Statistik 3 — Label'),
            ],
            'CTA & Quote' => [
                $t('seamedia.quote', 'Kutipan (quote band)', 'area'),
                $t('seamedia.cta_title', 'CTA — Judul', 'area'),
                $t('seamedia.cta_desc', 'CTA — Deskripsi', 'area'),
            ],
            'Kontak' => [
                $t('seamedia.contact_name', 'Nama Kontak'),
                $t('seamedia.contact_email', 'Email'),
                $t('seamedia.contact_wa', 'Link WhatsApp (https://wa.me/62...)'),
                $t('seamedia.contact_location', 'Lokasi'),
            ],
        ];
    }

    public function mount(): void
    {
        $all = Setting::all_cached();
        $state = [];
        foreach ($this->fieldMap() as $fields) {
            foreach ($fields as $f) {
                $state[self::k($f['key'])] = $all[$f['key']] ?? null;
            }
        }
        $this->form->fill($state);
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach ($this->fieldMap() as $label => $fields) {
            $components = [];
            foreach ($fields as $f) {
                $name = self::k($f['key']);
                $components[] = $f['type'] === 'area'
                    ? Textarea::make($name)->label($f['label'])->rows(2)
                    : TextInput::make($name)->label($f['label']);
            }
            $tabs[] = Tabs\Tab::make($label)->schema($components);
        }

        return $form->schema([Tabs::make('Seamedia')->tabs($tabs)])->statePath('data');
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $name => $value) {
            $key = str_replace('__', '.', $name);
            Setting::put($key, $value, 'seamedia');
        }
        Notification::make()->title('Konten Seamedia tersimpan')->success()->send();
    }
}
