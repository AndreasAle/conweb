<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebTemplateResource\Pages;
use App\Models\WebTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WebTemplateResource extends Resource
{
    protected static ?string $model = WebTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $navigationGroup = 'Template Website';
    protected static ?string $navigationLabel = 'Semua Template';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama Template')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                Forms\Components\TextInput::make('slug')->label('Slug (URL)')->required()->unique(ignoreRecord: true),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('category')->label('Kategori')->required()->placeholder('Ekspor, UMKM, Toko Online, dst'),
                Forms\Components\TextInput::make('price')->label('Harga Template (Rp)')->numeric()->default(0)
                    ->helperText('Dipakai untuk hitung total di checkout.'),
                Forms\Components\TextInput::make('price_label')->label('Label Harga (opsional, untuk kartu galeri)')->placeholder('Mulai Rp97.000/tahun'),
            ]),
            Forms\Components\TextInput::make('preview_url')->label('Link Preview (subdomain website asli)')
                ->url()->required()
                ->placeholder('https://nama-klien.conweb.id')
                ->helperText('Link website yang sudah Anda buat & deploy (subdomain ConWeb). Halaman preview di situs publik akan menampilkan link ini.'),
            Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail (untuk kartu di galeri)')->image()->directory('templates')->imageEditor(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('tagline_id')->label('Tagline (ID)')->required(),
                Forms\Components\TextInput::make('tagline_en')->label('Tagline (EN)')->required(),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\ColorPicker::make('primary_color')->label('Warna Aksen (fallback kalau thumbnail kosong)')->default('#2563eb'),
                Forms\Components\ColorPicker::make('secondary_color')->label('Warna Aksen 2')->default('#0a1530'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Toggle::make('is_featured')->label('Unggulan'),
                Forms\Components\TextInput::make('popularity')->label('Jumlah Pemilih')->numeric()->default(0),
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
            ]),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')->reorderable('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('Thumbnail'),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge(),
                Tables\Columns\TextColumn::make('preview_url')->label('Link Preview')->limit(30)->url(fn (WebTemplate $record) => $record->preview_url)->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('is_featured')->label('Unggulan')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')->label('Preview di Situs')->icon('heroicon-o-eye')
                    ->url(fn (WebTemplate $record) => route('templates.show', $record->slug))->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebTemplates::route('/'),
            'create' => Pages\CreateWebTemplate::route('/create'),
            'edit' => Pages\EditWebTemplate::route('/{record}/edit'),
        ];
    }
}
