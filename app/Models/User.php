<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'google_id',
        'avatar',
        'is_admin',
        'verification_code',
        'verification_expires_at',
        'offer_sent_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_expires_at' => 'datetime',
            'offer_sent_at' => 'datetime',
            'is_admin' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /** Hanya admin yang boleh masuk panel Filament. */
    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_admin;
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function isVerified(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    /** Generate & store a fresh 6-digit verification code (valid 10 minutes). */
    public function generateVerificationCode(): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->forceFill([
            'verification_code' => $code,
            'verification_expires_at' => Carbon::now()->addMinutes(10),
        ])->save();

        return $code;
    }

    public function verificationCodeValid(string $code): bool
    {
        return $this->verification_code
            && hash_equals($this->verification_code, $code)
            && $this->verification_expires_at
            && $this->verification_expires_at->isFuture();
    }

    public function markVerified(): void
    {
        $this->forceFill([
            'email_verified_at' => Carbon::now(),
            'verification_code' => null,
            'verification_expires_at' => null,
        ])->save();
    }
}
