<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom DOKU ke tabel orders (paket website).
 * Additive & backward-compatible: kolom Xendit lama tidak dihapus.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('doku_invoice_number')->nullable()->after('xendit_invoice_url');
            $table->string('doku_payment_url')->nullable()->after('doku_invoice_number');
            $table->string('payment_channel')->nullable()->after('doku_payment_url');
            $table->json('raw_callback')->nullable()->after('payment_channel');
            $table->index('doku_invoice_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['doku_invoice_number']);
            $table->dropColumn(['doku_invoice_number', 'doku_payment_url', 'payment_channel', 'raw_callback']);
        });
    }
};
