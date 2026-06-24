<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Services\FonnteService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Pesanan & Leads';
    protected static ?string $navigationLabel = 'Pesanan Website';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('payment_status', 'pending')->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('order_code')->label('Kode Pesanan')->disabled(),
                Forms\Components\Select::make('payment_status')->label('Status Bayar')->options([
                    'pending' => 'Menunggu Pembayaran',
                    'paid' => 'Lunas',
                    'expired' => 'Kadaluarsa',
                    'failed' => 'Gagal',
                ])->required(),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('customer_name')->label('Nama'),
                Forms\Components\TextInput::make('customer_email')->label('Email'),
                Forms\Components\TextInput::make('customer_phone')->label('WhatsApp'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('domain_name')->label('Nama Domain'),
                Forms\Components\TextInput::make('domain_tld')->label('TLD'),
                Forms\Components\TextInput::make('duration_years')->label('Durasi (tahun)')->numeric(),
            ]),
            Forms\Components\TextInput::make('total_amount')->label('Total (Rp)')->numeric(),
            Forms\Components\TextInput::make('xendit_invoice_url')->label('Link Invoice Xendit')->url()->disabled(),

            Forms\Components\Section::make('Status Pengerjaan (tracking pelanggan)')->schema([
                Forms\Components\Select::make('work_status')->label('Tahap Pengerjaan')
                    ->options(collect(Order::WORK_STAGES)->map(fn ($s) => $s['label'])->toArray())
                    ->default('received')->required()->live(),
                Forms\Components\Textarea::make('work_note')->label('Catatan untuk pelanggan (opsional)')->rows(2)
                    ->helperText('Tampil di halaman tracking pelanggan pada tahap aktif.'),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('order_code')->label('Kode')->searchable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')->label('WhatsApp')->copyable(),
                Tables\Columns\TextColumn::make('domain_name')->label('Domain')->formatStateUsing(fn ($record) => $record->domain_name.$record->domain_tld),
                Tables\Columns\TextColumn::make('template.name')->label('Template'),
                Tables\Columns\TextColumn::make('duration_years')->label('Durasi')->suffix(' th'),
                Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR', divideBy: 1),
                Tables\Columns\TextColumn::make('payment_status')->label('Bayar')->badge()->color(fn (string $state) => match ($state) {
                    'pending' => 'warning',
                    'paid' => 'success',
                    'expired', 'failed' => 'danger',
                    default => 'gray',
                }),
                Tables\Columns\TextColumn::make('work_status')->label('Pengerjaan')->badge()->color('info')
                    ->formatStateUsing(fn ($state) => Order::WORK_STAGES[$state]['label'] ?? $state),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')->label('Status')->options([
                    'pending' => 'Menunggu Pembayaran',
                    'paid' => 'Lunas',
                    'expired' => 'Kadaluarsa',
                    'failed' => 'Gagal',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('invoice')->label('Buka Invoice')->icon('heroicon-o-document-currency-dollar')
                    ->url(fn (Order $record) => $record->xendit_invoice_url)->openUrlInNewTab()
                    ->visible(fn (Order $record) => (bool) $record->xendit_invoice_url),
                Tables\Actions\Action::make('whatsapp')->label('Kirim WA')->icon('heroicon-o-chat-bubble-left-right')->color('success')
                    ->action(function (Order $record) {
                        $message = "Halo {$record->customer_name}, terima kasih! Pembayaran untuk domain {$record->domain_name}{$record->domain_tld} sudah kami terima.\n\nWebsite Anda sedang kami siapkan dan akan segera live. Kode pesanan: {$record->order_code}.";
                        app(FonnteService::class)->sendMessage($record->customer_phone, $message);
                        $record->update(['wa_notified_at' => now()]);
                        Notification::make()->title('Pesan WA dikirim (atau dicatat di log jika mode dev)')->success()->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
