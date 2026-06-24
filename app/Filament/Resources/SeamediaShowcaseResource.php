<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeamediaShowcaseResource\Pages;
use App\Models\SeamediaShowcase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeamediaShowcaseResource extends Resource
{
    protected static ?string $model = SeamediaShowcase::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Seamedia ConWeb';
    protected static ?string $navigationLabel = 'Showcase Website';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title')->label('Nama Website/Brand')->required(),
                Forms\Components\TextInput::make('category')->label('Kategori (mis. Kuliner, Kesehatan)'),
            ]),
            Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail (screenshot)')->image()->directory('seamedia')->imageEditor(),
            Forms\Components\TextInput::make('preview_url')->label('Link Preview/Demo ("Lihat")')->url()->placeholder('https://...'),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Toggle::make('is_featured')->label('Unggulan'),
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\ImageColumn::make('thumbnail')->label('Thumbnail'),
            Tables\Columns\TextColumn::make('title')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('category')->label('Kategori')->badge(),
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
            'index' => Pages\ListSeamediaShowcases::route('/'),
            'create' => Pages\CreateSeamediaShowcase::route('/create'),
            'edit' => Pages\EditSeamediaShowcase::route('/{record}/edit'),
        ];
    }
}
