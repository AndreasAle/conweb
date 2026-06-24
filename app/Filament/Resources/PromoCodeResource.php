<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Pesanan & Leads';
    protected static ?string $navigationLabel = 'Kode Promo';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('code')->label('Kode')->required()->unique(ignoreRecord: true)
                    ->formatStateUsing(fn ($state) => $state ? strtoupper($state) : $state)
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                Forms\Components\Select::make('discount_type')->label('Tipe Diskon')->options([
                    'fixed' => 'Potongan Tetap (Rp)',
                    'percent' => 'Persentase (%)',
                ])->default('fixed')->required(),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('discount_value')->label('Nilai Diskon')->numeric()->required(),
                Forms\Components\TextInput::make('max_uses')->label('Maks. Pemakaian (opsional)')->numeric(),
                Forms\Components\DateTimePicker::make('expires_at')->label('Berlaku Sampai (opsional)'),
            ]),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Kode')->searchable(),
                Tables\Columns\TextColumn::make('discount_type')->label('Tipe')->badge(),
                Tables\Columns\TextColumn::make('discount_value')->label('Nilai'),
                Tables\Columns\TextColumn::make('used_count')->label('Terpakai'),
                Tables\Columns\TextColumn::make('expires_at')->label('Berlaku Sampai')->date('d M Y'),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
