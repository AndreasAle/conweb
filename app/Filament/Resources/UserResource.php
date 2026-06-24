<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Mail\BlastMail;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Pelanggan';
    protected static ?string $navigationLabel = 'Pengguna Terdaftar';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count() ?: null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Daftar')->dateTime('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->label('WhatsApp')->copyable()->placeholder('—'),
                Tables\Columns\IconColumn::make('email_verified_at')->label('Verified')
                    ->boolean()->trueIcon('heroicon-o-check-badge')->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('google_id')->label('Google')->boolean()
                    ->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-minus')->falseColor('gray'),
                Tables\Columns\TextColumn::make('orders_count')->label('Pesanan')->counts('orders')->badge()->color('info'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')->label('Terverifikasi')
                    ->nullable()->trueLabel('Sudah')->falseLabel('Belum'),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')->label('WA')->icon('heroicon-o-chat-bubble-left-right')->color('success')
                    ->url(fn (User $r) => $r->phone ? 'https://wa.me/'.preg_replace('/\D/', '', $r->phone) : null)
                    ->openUrlInNewTab()->visible(fn (User $r) => (bool) $r->phone),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('blast')->label('Kirim Email')->icon('heroicon-o-envelope')->color('primary')
                    ->form([
                        Forms\Components\TextInput::make('subject')->label('Subjek')->required(),
                        Forms\Components\RichEditor::make('body')->label('Isi Email')->required()
                            ->helperText('Email dikirim dari mail@conweb.id.'),
                    ])
                    ->action(function (array $data, $records) {
                        $sent = 0;
                        foreach ($records as $user) {
                            if (! $user->email) {
                                continue;
                            }
                            Mail::to($user->email)->send(new BlastMail($user->name, $data['subject'], $data['body']));
                            $sent++;
                            usleep(200000); // jeda 0.2 detik antar email (bertahap)
                        }
                        Notification::make()->title("Email terkirim ke {$sent} pengguna")->success()->send();
                    }),
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
