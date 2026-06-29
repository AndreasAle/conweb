<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorePackageResource\Pages;
use App\Models\StorePackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StorePackageResource extends Resource
{
    protected static ?string $model = StorePackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'E-commerce by Conweb';

    protected static ?string $navigationLabel = 'Paket Layanan';

    protected static ?string $modelLabel = 'Paket';

    protected static ?string $pluralModelLabel = 'Paket Layanan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama Paket')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set, $context) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
            ]),
            Forms\Components\TextInput::make('tagline')->label('Tagline'),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('price')->label('Harga (Rp)')->numeric()->default(0),
                Forms\Components\TextInput::make('price_period')->label('Periode')->placeholder('/bulan'),
                Forms\Components\TextInput::make('product_limit')->label('Batas Produk')->numeric()
                    ->helperText('Kosongkan = tanpa batas.'),
            ]),
            Forms\Components\TagsInput::make('features')->label('Fitur')->placeholder('Tambah fitur')
                ->helperText('Tekan Enter untuk tiap poin fitur.'),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\Toggle::make('is_featured')->label('Unggulan'),
                Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR', divideBy: 1)->sortable(),
                Tables\Columns\TextColumn::make('price_period')->label('Periode')->placeholder('—'),
                Tables\Columns\TextColumn::make('stores_count')->label('Toko')->counts('stores')->badge(),
                Tables\Columns\IconColumn::make('is_featured')->label('Unggulan')->boolean(),
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
            'index' => Pages\ListStorePackages::route('/'),
            'create' => Pages\CreateStorePackage::route('/create'),
            'edit' => Pages\EditStorePackage::route('/{record}/edit'),
        ];
    }
}
