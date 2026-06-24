<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PricingPlanResource\Pages;
use App\Models\PricingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Paket & Harga';
    protected static ?string $navigationLabel = 'Paket & Harga';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('type')->label('Tipe')->options([
                    'domain' => 'Domain',
                    'package' => 'Paket Layanan',
                ])->default('package')->required(),
                Forms\Components\TextInput::make('name')->label('Nama Paket')->required()->placeholder('.com / Paket Bisnis'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('price')->label('Harga (Rp)')->numeric()->required(),
                Forms\Components\TextInput::make('original_price')->label('Harga Coret (opsional)')->numeric(),
                Forms\Components\TextInput::make('period')->label('Periode')->default('/tahun')->required(),
            ]),
            Forms\Components\TextInput::make('badge')->label('Badge (opsional)')->placeholder('Populer'),
            Forms\Components\TagsInput::make('features')->label('Fitur')->placeholder('Tambah fitur'),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR', divideBy: 1),
                Tables\Columns\TextColumn::make('badge')->label('Badge'),
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
            'index' => Pages\ListPricingPlans::route('/'),
            'create' => Pages\CreatePricingPlan::route('/create'),
            'edit' => Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }
}
