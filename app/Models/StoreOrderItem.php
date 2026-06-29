<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'product_price' => 'integer',
            'quantity' => 'integer',
            'subtotal' => 'integer',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(StoreOrder::class, 'store_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return formatRupiah($this->subtotal);
    }
}
