<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeads extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Lead::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('whatsapp')->label('WhatsApp'),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
                Tables\Columns\TextColumn::make('reference')->label('Referensi')->limit(30),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (string $state) => match ($state) {
                    'new' => 'warning',
                    'contacted' => 'info',
                    'closed' => 'success',
                    default => 'gray',
                }),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')->label('Buka WA')->icon('heroicon-o-chat-bubble-left-right')->color('success')
                    ->url(fn (Lead $record) => 'https://wa.me/'.preg_replace('/\D/', '', $record->whatsapp))->openUrlInNewTab(),
            ]);
    }
}
