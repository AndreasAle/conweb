<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeamediaPackageResource\Pages;
use App\Models\SeamediaPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeamediaPackageResource extends Resource
{
    protected static ?string $model = SeamediaPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Seamedia ConWeb';
    protected static ?string $navigationLabel = 'Paket';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama Paket (Care/Launch/Signature)')->required(),
                Forms\Components\TextInput::make('title')->label('Judul')->required(),
            ]),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
            Forms\Components\TagsInput::make('features')->label('Fitur (tekan Enter tiap poin)')->placeholder('Tambah fitur'),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('badge')->label('Badge (mis. Paling Populer)'),
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_featured')->label('Unggulan'),
            ]),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->badge(),
            Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
            Tables\Columns\IconColumn::make('is_featured')->label('Unggulan')->boolean(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            Tables\Columns\TextColumn::make('sort')->label('Urutan')->sortable(),
        ])->reorderable('sort')->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeamediaPackages::route('/'),
            'create' => Pages\CreateSeamediaPackage::route('/create'),
            'edit' => Pages\EditSeamediaPackage::route('/{record}/edit'),
        ];
    }
}
