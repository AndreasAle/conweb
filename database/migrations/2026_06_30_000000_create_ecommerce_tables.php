<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * E-commerce by Conweb — "Conweb Store" module.
 *
 * Catatan penamaan: tabel order toko sengaja diberi prefix `store_orders` /
 * `store_order_items` karena tabel `orders` & model App\Models\Order sudah
 * dipakai untuk pesanan jasa website (OrderWizard + webhook Xendit). Tidak boleh
 * ada tabrakan nama dengan fitur lama.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Paket layanan Conweb Store (Profile / Store / Commerce)
        Schema::create('store_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 0)->default(0);
            $table->string('price_period')->nullable(); // misal: /bulan, /tahun
            $table->json('features')->nullable();
            $table->unsignedInteger('product_limit')->nullable(); // null = unlimited
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Template tampilan storefront
        Schema::create('store_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('preview_image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. Toko UMKM
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('store_package_id')->nullable()->constrained('store_packages')->nullOnDelete();
            $table->foreignId('store_template_id')->nullable()->constrained('store_templates')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('whatsapp_number');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('shopee_url')->nullable();
            $table->string('tokopedia_url')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'is_featured']);
        });

        // 4. Kategori produk (scoped per toko)
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['store_id', 'slug']);
            $table->index(['store_id', 'is_active']);
        });

        // 5. Produk
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            $table->decimal('price', 12, 0)->default(0);
            $table->decimal('compare_price', 12, 0)->nullable();
            $table->integer('stock')->nullable(); // null = stok tidak dilacak
            $table->string('sku')->nullable();
            $table->unsignedInteger('weight')->nullable(); // gram
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['store_id', 'slug']);
            $table->index(['store_id', 'is_active', 'is_featured']);
        });

        // 6. Voucher / diskon (scoped per toko)
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('code');
            $table->string('type')->default('percentage'); // percentage | fixed
            $table->decimal('value', 12, 0)->default(0);
            $table->decimal('max_discount', 12, 0)->nullable();
            $table->decimal('min_order_amount', 12, 0)->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['store_id', 'code']);
            $table->index(['store_id', 'is_active']);
        });

        // 7. Pesanan toko (prefix `store_` agar tidak bentrok dengan tabel `orders` lama)
        Schema::create('store_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->nullOnDelete();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('customer_address')->nullable();
            $table->text('customer_note')->nullable();
            $table->decimal('subtotal', 12, 0)->default(0);
            $table->decimal('discount_amount', 12, 0)->default(0);
            $table->decimal('total', 12, 0)->default(0);
            $table->string('status')->default('pending'); // pending|confirmed|processing|completed|cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid|paid|manual_confirm
            $table->string('checkout_channel')->default('whatsapp');
            $table->text('whatsapp_message')->nullable();
            $table->timestamps();

            $table->index(['store_id', 'status']);
        });

        // 8. Item pesanan
        Schema::create('store_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_order_id')->constrained('store_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name');
            $table->decimal('product_price', 12, 0)->default(0);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('subtotal', 12, 0)->default(0);
            $table->timestamps();
        });

        // 9. Pengaturan toko (key-value, untuk pengembangan ke depan)
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['store_id', 'key']);
        });
    }

    public function down(): void
    {
        // Urutan drop terbalik agar foreign key aman.
        Schema::dropIfExists('store_settings');
        Schema::dropIfExists('store_order_items');
        Schema::dropIfExists('store_orders');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('store_templates');
        Schema::dropIfExists('store_packages');
    }
};
