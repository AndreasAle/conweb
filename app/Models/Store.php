<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_package_id',
        'store_template_id',
        'name',
        'slug',
        'tagline',
        'description',
        'logo',
        'banner',
        'whatsapp_number',
        'email',
        'address',
        'city',
        'province',
        'postal_code',
        'instagram_url',
        'tiktok_url',
        'shopee_url',
        'tokopedia_url',
        'primary_color',
        'secondary_color',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    // ---- Relationships ----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(StorePackage::class, 'store_package_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(StoreTemplate::class, 'store_template_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(StoreOrder::class);
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(StoreSetting::class);
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? Storage::url($this->logo)
            : 'https://placehold.co/200x200?text='.urlencode($this->name);
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner ? Storage::url($this->banner) : null;
    }

    public function getWhatsappCheckoutUrlAttribute(): string
    {
        return whatsappUrl($this->whatsapp_number);
    }
}
