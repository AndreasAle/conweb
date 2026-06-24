<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('discount_type')->default('fixed'); // fixed | percent
            $table->decimal('discount_value', 12, 0);
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('web_template_id')->nullable()->constrained('web_templates')->nullOnDelete();
            $table->string('domain_name');
            $table->string('domain_tld');
            $table->decimal('domain_price', 12, 0)->default(0);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->integer('duration_years')->default(1);
            $table->json('addons')->nullable();
            $table->string('promo_code')->nullable();
            $table->decimal('discount_amount', 12, 0)->default(0);
            $table->decimal('total_amount', 12, 0)->default(0);
            $table->string('xendit_invoice_id')->nullable();
            $table->string('xendit_invoice_url')->nullable();
            $table->string('payment_status')->default('pending'); // pending | paid | expired | failed
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('wa_notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('promo_codes');
    }
};
