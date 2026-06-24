<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeamediaAddonResource\Pages;
use App\Models\SeamediaAddon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeamediaAddonResource extends Resource
{
    protected static ?string $model = SeamediaAddon::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationGroup = 'Seamedia ConWeb';
    protected static ?string $navigationLabel = 'Layanan Tambahan';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nama Layanan Tambahan')->required(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
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
            'index' => Pages\ListSeamediaAddons::route('/'),
            'create' => Pages\CreateSeamediaAddon::route('/create'),
            'edit' => Pages\EditSeamediaAddon::route('/{record}/edit'),
        ];
    }
}
