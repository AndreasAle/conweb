<?php

namespace App\Filament\Pages;

use App\Mail\BlastMail;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Mail;

class EmailBlast extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Pelanggan';
    protected static ?string $navigationLabel = 'Blast Email';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Blast Email ke Pengguna';

    protected static string $view = 'filament.pages.email-blast';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(['audience' => 'all', 'batch_size' => 50]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Select::make('audience')->label('Penerima')->options([
                        'all' => 'Semua pengguna',
                        'verified' => 'Hanya yang terverifikasi',
                        'unverified' => 'Hanya yang belum verifikasi',
                        'customers' => 'Hanya yang pernah memesan',
                    ])->default('all')->required()->live(),
                    Placeholder::make('count')->label('Estimasi penerima')
                        ->content(fn (): string => $this->recipientsQuery($this->data['audience'] ?? 'all')->count().' pengguna'),
                ])->columns(2),
                TextInput::make('subject')->label('Subjek')->required()->maxLength(150),
                RichEditor::make('body')->label('Isi Email')->required()
                    ->helperText('Dikirim dari mail@conweb.id. Bisa pakai heading, bold, list, dan link.'),
                TextInput::make('batch_size')->label('Jumlah per batch (bertahap)')->numeric()
                    ->default(50)->minValue(1)->maxValue(500)->required()
                    ->helperText('Email dikirim per batch dengan jeda singkat agar tidak dianggap spam.'),
            ])
            ->statePath('data');
    }

    protected function recipientsQuery(string $audience)
    {
        $q = User::query()->whereNotNull('email');

        return match ($audience) {
            'verified' => $q->whereNotNull('email_verified_at'),
            'unverified' => $q->whereNull('email_verified_at'),
            'customers' => $q->whereHas('orders'),
            default => $q,
        };
    }

    public function send(): void
    {
        $data = $this->form->getState();

        $batch = max(1, (int) ($data['batch_size'] ?? 50));
        $sent = 0;

        $this->recipientsQuery($data['audience'])
            ->select('name', 'email')
            ->chunk($batch, function ($users) use (&$sent, $data) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new BlastMail($user->name, $data['subject'], $data['body']));
                    $sent++;
                }
                usleep(500000); // jeda 0.5 detik antar batch
            });

        Notification::make()
            ->title("Blast selesai — {$sent} email terkirim")
            ->body(config('mail.default') === 'log' ? 'Mode log: email dicatat di storage/logs (SMTP belum diisi).' : null)
            ->success()->send();

        $this->form->fill(['audience' => $data['audience'], 'batch_size' => $batch]);
    }
}
