<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Konten Lainnya';
    protected static ?string $navigationLabel = 'Testimoni';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('quote_id')->label('Testimoni (ID)')->required()->rows(3),
            Forms\Components\Textarea::make('quote_en')->label('Testimoni (EN)')->required()->rows(3),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama')->required(),
                Forms\Components\TextInput::make('avatar_letter')->label('Huruf Avatar')->maxLength(2)->required(),
                Forms\Components\TextInput::make('role_id')->label('Peran (ID)')->required(),
                Forms\Components\TextInput::make('role_en')->label('Peran (EN)')->required(),
            ]),
            Forms\Components\TextInput::make('gradient')->label('Gradient Avatar (CSS)')->default('linear-gradient(135deg,#3b82f6,#1d4ed8)'),
            Forms\Components\TextInput::make('rating')->label('Rating (1-5)')->numeric()->minValue(1)->maxValue(5)->default(5),
            Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('role_id')->label('Peran'),
                Tables\Columns\TextColumn::make('rating')->label('Rating'),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
