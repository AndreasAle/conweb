<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeamediaServiceResource\Pages;
use App\Models\SeamediaService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeamediaServiceResource extends Resource
{
    protected static ?string $model = SeamediaService::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Seamedia ConWeb';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('icon')->label('Ikon')->options([
                'web' => 'Website', 'cart' => 'Katalog/Belanja', 'wa' => 'WhatsApp',
                'panel' => 'Dashboard', 'seo' => 'SEO/Pencarian', 'care' => 'Maintenance/Support',
            ])->default('web')->required(),
            Forms\Components\TextInput::make('title')->label('Judul')->required(),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\TextColumn::make('icon')->label('Ikon')->badge(),
            Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
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
            'index' => Pages\ListSeamediaServices::route('/'),
            'create' => Pages\CreateSeamediaService::route('/create'),
            'edit' => Pages\EditSeamediaService::route('/{record}/edit'),
        ];
    }
}
