<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreOrder extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];

    public const PAYMENT_STATUSES = ['unpaid', 'paid', 'manual_confirm'];

    protected $fillable = [
        'store_id',
        'voucher_id',
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'customer_note',
        'subtotal',
        'discount_amount',
        'total',
        'status',
        'payment_status',
        'checkout_channel',
        'whatsapp_message',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'discount_amount' => 'integer',
            'total' => 'integer',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(StoreOrderItem::class);
    }

    public function getRouteKeyName(): string
    {
        return 'order_code';
    }

    public function getFormattedTotalAttribute(): string
    {
        return formatRupiah($this->total);
    }

    public function getWhatsappUrlAttribute(): string
    {
        return whatsappUrl($this->store?->whatsapp_number, (string) $this->whatsapp_message);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst((string) $this->status),
        };
    }
}
