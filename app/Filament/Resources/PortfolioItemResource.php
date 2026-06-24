<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioItemResource\Pages;
use App\Models\PortfolioItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PortfolioItemResource extends Resource
{
    protected static ?string $model = PortfolioItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Portofolio';
    protected static ?string $navigationLabel = 'Semua Portofolio';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Nama Proyek')->required(),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Select::make('icon')->label('Ikon Kategori')->options(\App\Support\Icons::options())->required(),
                Forms\Components\Select::make('size')->label('Ukuran Kartu')->options(['xl'=>'Besar (xl)','md'=>'Sedang (md)','sm'=>'Kecil (sm)'])->default('md')->required(),
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('category_id')->label('Kategori (ID)')->required(),
                Forms\Components\TextInput::make('category_en')->label('Kategori (EN)')->required(),
                Forms\Components\Textarea::make('desc_id')->label('Deskripsi (ID)')->required()->rows(3),
                Forms\Components\Textarea::make('desc_en')->label('Deskripsi (EN)')->required()->rows(3),
            ]),
            Forms\Components\TagsInput::make('tags')->label('Tags')->placeholder('Tambah tag'),
            Forms\Components\TextInput::make('gradient')->label('Gradient Background (CSS)')
                ->default('linear-gradient(135deg,#1d4ed8,#0a1530)')
                ->helperText('Contoh: linear-gradient(135deg,#1d4ed8,#0a1530)'),
            Forms\Components\FileUpload::make('image')->label('Gambar Background (opsional)')->image()->directory('portfolio')->imageEditor(),
            Forms\Components\TextInput::make('link')->label('Link Proyek (URL)')->url(),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')->reorderable('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('title')->label('Proyek')->searchable(),
                Tables\Columns\TextColumn::make('category_id')->label('Kategori'),
                Tables\Columns\TextColumn::make('size')->label('Ukuran')->badge(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
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
            'index' => Pages\ListPortfolioItems::route('/'),
            'create' => Pages\CreatePortfolioItem::route('/create'),
            'edit' => Pages\EditPortfolioItem::route('/{record}/edit'),
        ];
    }
}
