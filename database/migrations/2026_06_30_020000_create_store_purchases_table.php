<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pembelian paket Conweb Store oleh user (self-service).
 * Alur: user pilih paket -> bayar via DOKU -> setelah paid, isi form toko ->
 * toko dibuat & aktif. Tabel ini melacak pembelian + status pembayaran paket,
 * terpisah dari "orders" (paket website) dan "store_orders" (order customer toko).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('store_package_id')->nullable()->constrained('store_packages')->nullOnDelete();
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete();
            $table->string('package_name'); // snapshot nama paket saat dibeli
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->decimal('amount', 12, 0)->default(0);
            $table->string('payment_status')->default('pending'); // pending | paid | expired | failed
            $table->string('payment_channel')->nullable();
            $table->string('doku_invoice_number')->nullable();
            $table->string('doku_payment_url')->nullable();
            $table->json('raw_callback')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('doku_invoice_number');
            $table->index(['user_id', 'payment_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_purchases');
    }
};
