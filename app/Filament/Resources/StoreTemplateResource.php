<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreTemplateResource\Pages;
use App\Models\StoreTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StoreTemplateResource extends Resource
{
    protected static ?string $model = StoreTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationGroup = 'E-commerce by Conweb';

    protected static ?string $navigationLabel = 'Template Toko';

    protected static ?string $modelLabel = 'Template Toko';

    protected static ?string $pluralModelLabel = 'Template Toko';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama Template')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set, $context) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
            ]),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
            Forms\Components\FileUpload::make('preview_image')->label('Gambar Preview')->image()
                ->directory('store-templates')->imageEditor(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('preview_image')->label('Preview'),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('stores_count')->label('Dipakai')->counts('stores')->badge(),
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
            'index' => Pages\ListStoreTemplates::route('/'),
            'create' => Pages\CreateStoreTemplate::route('/create'),
            'edit' => Pages\EditStoreTemplate::route('/{record}/edit'),
        ];
    }
}
