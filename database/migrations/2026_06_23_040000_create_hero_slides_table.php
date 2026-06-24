<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge_id')->nullable();
            $table->string('badge_en')->nullable();
            $table->string('title_id'); // boleh HTML, mis. <em>kata</em> untuk highlight
            $table->string('title_en');
            $table->text('desc_id')->nullable();
            $table->text('desc_en')->nullable();
            $table->string('discount_text_id')->nullable();
            $table->string('discount_text_en')->nullable();
            $table->string('promo_code')->nullable();
            $table->string('button1_label_id')->nullable();
            $table->string('button1_label_en')->nullable();
            $table->string('button1_url')->nullable();
            $table->string('button2_label_id')->nullable();
            $table->string('button2_label_en')->nullable();
            $table->string('button2_url')->nullable();
            $table->string('image')->nullable();
            $table->string('float1_text_id')->nullable();
            $table->string('float1_text_en')->nullable();
            $table->string('float2_text_id')->nullable();
            $table->string('float2_text_en')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
