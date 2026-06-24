<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechCategoryResource\Pages;
use App\Models\TechCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TechCategoryResource extends Resource
{
    protected static ?string $model = TechCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'Konten Lainnya';
    protected static ?string $navigationLabel = 'Tech Stack';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('icon')->label('Ikon')->options(\App\Support\Icons::options())->required(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title_id')->label('Judul (ID)')->required(),
                Forms\Components\TextInput::make('title_en')->label('Judul (EN)')->required(),
            ]),
            Forms\Components\TagsInput::make('pills')->label('Daftar Teknologi')->placeholder('Tambah teknologi'),
            Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('title_id')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('icon')->label('Ikon')->badge(),
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
            'index' => Pages\ListTechCategories::route('/'),
            'create' => Pages\CreateTechCategory::route('/create'),
            'edit' => Pages\EditTechCategory::route('/{record}/edit'),
        ];
    }
}
