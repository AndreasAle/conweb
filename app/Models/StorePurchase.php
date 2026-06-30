<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorePurchase extends Model
{
    protected $guarded = [];

    protected $casts = [
        'raw_callback' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(StorePackage::class, 'store_package_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /** Sudah bayar tapi toko belum dibuat -> perlu isi form setup. */
    public function needsSetup(): bool
    {
        return $this->isPaid() && ! $this->store_id;
    }

    public function getFormattedAmountAttribute(): string
    {
        return formatRupiah($this->amount);
    }

    /** Label status pembayaran untuk UI. */
    public function statusLabel(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Lunas',
            'expired' => 'Kedaluwarsa',
            'failed' => 'Gagal',
            default => 'Menunggu Pembayaran',
        };
    }
}
