<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreOrderResource\Pages;
use App\Models\StoreOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoreOrderResource extends Resource
{
    protected static ?string $model = StoreOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'E-commerce by Conweb';

    protected static ?string $navigationLabel = 'Pesanan Toko';

    protected static ?string $modelLabel = 'Pesanan Toko';

    protected static ?string $pluralModelLabel = 'Pesanan Toko';

    protected static ?int $navigationSort = 2;

    /** Admin tidak membuat order manual dari panel. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Pesanan')->schema([
                Forms\Components\Placeholder::make('order_code')->label('Kode Order')
                    ->content(fn (?StoreOrder $r) => $r?->order_code),
                Forms\Components\Placeholder::make('store')->label('Toko')
                    ->content(fn (?StoreOrder $r) => $r?->store?->name),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('status')->label('Status Pesanan')
                        ->options(array_combine(StoreOrder::STATUSES, array_map('ucfirst', StoreOrder::STATUSES)))
                        ->required(),
                    Forms\Components\Select::make('payment_status')->label('Status Pembayaran')
                        ->options(array_combine(StoreOrder::PAYMENT_STATUSES, array_map(fn ($s) => ucfirst(str_replace('_', ' ', $s)), StoreOrder::PAYMENT_STATUSES)))
                        ->required(),
                ]),
            ]),
            Forms\Components\Section::make('Customer')->schema([
                Forms\Components\Placeholder::make('customer')->label('')
                    ->content(fn (?StoreOrder $r) => $r ? "{$r->customer_name} • {$r->customer_phone}" : ''),
                Forms\Components\Placeholder::make('addr')->label('Alamat')
                    ->content(fn (?StoreOrder $r) => $r?->customer_address ?: '—'),
                Forms\Components\Placeholder::make('note')->label('Catatan')
                    ->content(fn (?StoreOrder $r) => $r?->customer_note ?: '—'),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('order_code')->label('Kode')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('store.name')->label('Toko')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Customer')->searchable()
                    ->description(fn (StoreOrder $r) => $r->customer_phone),
                Tables\Columns\TextColumn::make('items_count')->label('Item')->counts('items')->badge(),
                Tables\Columns\TextColumn::make('total')->label('Total')->money('IDR', divideBy: 1)->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'pending' => 'warning',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('store')->relationship('store', 'name')->label('Toko')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('status')->label('Status')
                    ->options(array_combine(StoreOrder::STATUSES, array_map('ucfirst', StoreOrder::STATUSES))),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Kelola'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreOrders::route('/'),
            'edit' => Pages\EditStoreOrder::route('/{record}/edit'),
        ];
    }
}
