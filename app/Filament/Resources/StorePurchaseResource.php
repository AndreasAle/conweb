<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorePurchaseResource\Pages;
use App\Models\StorePurchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StorePurchaseResource extends Resource
{
    protected static ?string $model = StorePurchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'E-commerce by Conweb';

    protected static ?string $navigationLabel = 'Pembelian Paket';

    protected static ?string $modelLabel = 'Pembelian Paket';

    protected static ?string $pluralModelLabel = 'Pembelian Paket';

    protected static ?int $navigationSort = 3;

    /** @var array<string,string> */
    public const PAYMENT_STATUSES = [
        'pending' => 'Menunggu Pembayaran',
        'paid' => 'Lunas',
        'expired' => 'Kedaluwarsa',
        'failed' => 'Gagal',
    ];

    /** Pembelian dibuat oleh user (self-service), bukan admin. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        // Tampilkan jumlah pembelian lunas yang belum di-setup (perlu perhatian).
        $count = StorePurchase::where('payment_status', 'paid')->whereNull('store_id')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Pembelian Paket')->schema([
                Forms\Components\Placeholder::make('order_code')->label('Kode')
                    ->content(fn (?StorePurchase $r) => $r?->order_code),
                Forms\Components\Placeholder::make('package_name')->label('Paket')
                    ->content(fn (?StorePurchase $r) => $r?->package_name),
                Forms\Components\Placeholder::make('amount')->label('Nominal')
                    ->content(fn (?StorePurchase $r) => $r ? formatRupiah($r->amount) : '—'),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('payment_status')->label('Status Pembayaran')
                        ->options(self::PAYMENT_STATUSES)
                        ->helperText('Ubah manual hanya bila konfirmasi pembayaran di luar DOKU.')
                        ->required(),
                    Forms\Components\Placeholder::make('payment_channel')->label('Metode')
                        ->content(fn (?StorePurchase $r) => $r?->payment_channel ?: '—'),
                ]),
            ]),
            Forms\Components\Section::make('Pembeli & Toko')->schema([
                Forms\Components\Placeholder::make('user')->label('Pembeli')
                    ->content(fn (?StorePurchase $r) => $r ? "{$r->customer_name} • {$r->customer_phone} • {$r->customer_email}" : ''),
                Forms\Components\Placeholder::make('store')->label('Status Toko')
                    ->content(fn (?StorePurchase $r) => match (true) {
                        $r && $r->store_id => 'Aktif — '.$r->store?->name,
                        $r && $r->isPaid() => 'Lunas, menunggu user melengkapi data toko',
                        default => 'Belum aktif (menunggu pembayaran)',
                    }),
                Forms\Components\Placeholder::make('paid_at')->label('Dibayar pada')
                    ->content(fn (?StorePurchase $r) => $r?->paid_at?->format('d M Y H:i') ?: '—'),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('order_code')->label('Kode')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Pembeli')->searchable()
                    ->description(fn (StorePurchase $r) => $r->customer_email),
                Tables\Columns\TextColumn::make('package_name')->label('Paket')->searchable()->badge()->color('info'),
                Tables\Columns\TextColumn::make('amount')->label('Nominal')->money('IDR', divideBy: 1)->sortable(),
                Tables\Columns\TextColumn::make('payment_status')->label('Pembayaran')->badge()
                    ->formatStateUsing(fn (string $state) => self::PAYMENT_STATUSES[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'paid' => 'success',
                        'failed', 'expired' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('store_id')->label('Toko')->badge()
                    ->getStateUsing(fn (StorePurchase $r) => match (true) {
                        (bool) $r->store_id => 'Aktif',
                        $r->isPaid() => 'Pending Setup',
                        default => '—',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'Aktif' => 'success',
                        'Pending Setup' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')->label('Status Pembayaran')
                    ->options(self::PAYMENT_STATUSES),
                Tables\Filters\SelectFilter::make('stage')->label('Tahap')
                    ->options([
                        'menunggu' => 'Menunggu Pembayaran',
                        'pending_setup' => 'Lunas — Pending Setup',
                        'aktif' => 'Toko Aktif',
                    ])
                    ->query(fn ($query, array $data) => match ($data['value'] ?? null) {
                        'menunggu' => $query->where('payment_status', '!=', 'paid'),
                        'pending_setup' => $query->where('payment_status', 'paid')->whereNull('store_id'),
                        'aktif' => $query->where('payment_status', 'paid')->whereNotNull('store_id'),
                        default => $query,
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Detail'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStorePurchases::route('/'),
            'edit' => Pages\EditStorePurchase::route('/{record}/edit'),
        ];
    }
}
