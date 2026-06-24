<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Hero Carousel';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('badge_id')->label('Badge / Eyebrow (ID)')->placeholder('Khusus Eksportir Indonesia'),
                Forms\Components\TextInput::make('badge_en')->label('Badge / Eyebrow (EN)'),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title_id')->label('Judul (ID) — boleh tag <em>...</em> untuk highlight')->required(),
                Forms\Components\TextInput::make('title_en')->label('Judul (EN) — boleh tag <em>...</em>')->required(),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Textarea::make('desc_id')->label('Deskripsi (ID)')->rows(2),
                Forms\Components\Textarea::make('desc_en')->label('Deskripsi (EN)')->rows(2),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('discount_text_id')->label('Teks Diskon (ID, opsional)')->placeholder('Diskon Rp500.000'),
                Forms\Components\TextInput::make('discount_text_en')->label('Teks Diskon (EN, opsional)'),
                Forms\Components\TextInput::make('promo_code')->label('Kode Promo (opsional)')->placeholder('WEBSITEJUARA'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('button1_label_id')->label('Tombol 1 (ID)'),
                Forms\Components\TextInput::make('button1_label_en')->label('Tombol 1 (EN)'),
                Forms\Components\TextInput::make('button1_url')->label('Link Tombol 1'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('button2_label_id')->label('Tombol 2 (ID, opsional)'),
                Forms\Components\TextInput::make('button2_label_en')->label('Tombol 2 (EN, opsional)'),
                Forms\Components\TextInput::make('button2_url')->label('Link Tombol 2'),
            ]),
            Forms\Components\FileUpload::make('image')->label('Gambar Samping')->image()->directory('hero')->imageEditor(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('float1_text_id')->label('Floating Badge 1 (ID, opsional)')->placeholder('10k+ Eksportir Indonesia'),
                Forms\Components\TextInput::make('float1_text_en')->label('Floating Badge 1 (EN, opsional)'),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('float2_text_id')->label('Floating Badge 2 (ID, opsional)')->placeholder('Ekspor Bulan Ini: 10+ Kontainer'),
                Forms\Components\TextInput::make('float2_text_en')->label('Floating Badge 2 (EN, opsional)'),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')->reorderable('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('title_id')->label('Judul')->limit(50),
                Tables\Columns\TextColumn::make('promo_code')->label('Kode Promo'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort')->label('Urutan')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
