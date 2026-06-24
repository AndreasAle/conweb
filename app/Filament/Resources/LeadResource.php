<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationGroup = 'Pesanan & Leads';
    protected static ?string $navigationLabel = 'Semua Pesanan';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama')->required(),
                Forms\Components\TextInput::make('whatsapp')->label('WhatsApp')->required(),
                Forms\Components\TextInput::make('email')->label('Email')->email(),
                Forms\Components\Select::make('type')->label('Tipe')->options([
                    'template' => 'Template',
                    'service' => 'Layanan',
                    'package' => 'Paket',
                    'custom' => 'Lainnya',
                ])->required(),
            ]),
            Forms\Components\TextInput::make('reference')->label('Referensi (template/layanan/paket)'),
            Forms\Components\Textarea::make('message')->label('Pesan')->rows(3),
            Forms\Components\Select::make('status')->label('Status')->options([
                'new' => 'Baru',
                'contacted' => 'Sudah Dihubungi',
                'closed' => 'Selesai',
            ])->default('new')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')->label('WhatsApp')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
                Tables\Columns\TextColumn::make('reference')->label('Referensi')->limit(30),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (string $state) => match ($state) {
                    'new' => 'warning',
                    'contacted' => 'info',
                    'closed' => 'success',
                    default => 'gray',
                }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'new' => 'Baru',
                    'contacted' => 'Sudah Dihubungi',
                    'closed' => 'Selesai',
                ]),
                Tables\Filters\SelectFilter::make('type')->options([
                    'template' => 'Template',
                    'service' => 'Layanan',
                    'package' => 'Paket',
                    'custom' => 'Lainnya',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')->label('Buka WA')->icon('heroicon-o-chat-bubble-left-right')->color('success')
                    ->url(fn (Lead $record) => 'https://wa.me/'.preg_replace('/\D/', '', $record->whatsapp))->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
