<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'weight',
        'image',
        'gallery',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'compare_price' => 'integer',
            'stock' => 'integer',
            'weight' => 'integer',
            'gallery' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    // ---- Relationships ----

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // ---- Scopes ----

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // ---- Accessors / helpers ----
    // Catatan: TIDAK meng-override getRouteKeyName ke 'slug' secara global,
    // karena slug produk hanya unik per-toko. Storefront memakai scoped binding
    // {store:slug}/products/{product:slug}; dashboard memakai binding id default.

    public function getFormattedPriceAttribute(): string
    {
        return formatRupiah($this->price);
    }

    public function getFormattedComparePriceAttribute(): ?string
    {
        return $this->compare_price ? formatRupiah($this->compare_price) : null;
    }

    /** Apakah produk sedang promo (compare_price lebih besar dari price). */
    public function getIsOnSaleAttribute(): bool
    {
        return $this->compare_price !== null && $this->compare_price > $this->price;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (! $this->is_on_sale || ! $this->compare_price) {
            return null;
        }

        return (int) round(($this->compare_price - $this->price) / $this->compare_price * 100);
    }

    public function getProductImageUrlAttribute(): string
    {
        return $this->image
            ? Storage::url($this->image)
            : 'https://placehold.co/600x600?text='.urlencode($this->name);
    }

    /** Daftar URL galeri (selalu array, aman untuk loop di Blade). */
    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($path) => Storage::url($path))
            ->all();
    }

    /** true jika stok tidak dilacak (null) atau masih tersedia. */
    public function getInStockAttribute(): bool
    {
        return $this->stock === null || $this->stock > 0;
    }
}
