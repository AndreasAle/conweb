<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Key/value store for all singleton content (bilingual keys like hero.title.id)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('web');
            $table->string('title_id');
            $table->string('title_en');
            $table->text('desc_id');
            $table->text('desc_en');
            $table->json('features')->nullable(); // [{id, en}]
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('process_steps', function (Blueprint $table) {
            $table->id();
            $table->string('number')->default('01');
            $table->string('title_id');
            $table->string('title_en');
            $table->text('desc_id');
            $table->text('desc_en');
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('grid');
            $table->string('category_id');
            $table->string('category_en');
            $table->string('title');
            $table->text('desc_id');
            $table->text('desc_en');
            $table->json('tags')->nullable();
            $table->string('gradient')->default('linear-gradient(135deg,#1d4ed8,#0a1530)');
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('size')->default('md'); // xl | md | sm
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tech_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('frontend');
            $table->string('title_id');
            $table->string('title_en');
            $table->json('pills')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->text('quote_id');
            $table->text('quote_en');
            $table->string('name');
            $table->string('role_id');
            $table->string('role_en');
            $table->string('avatar_letter')->default('A');
            $table->string('gradient')->default('linear-gradient(135deg,#3b82f6,#1d4ed8)');
            $table->integer('rating')->default(5);
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question_id');
            $table->string('question_en');
            $table->text('answer_id');
            $table->text('answer_en');
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('suffix')->nullable();
            $table->string('label_id');
            $table->string('label_en');
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['logos','stats','faqs','testimonials','tech_categories','portfolio_items','process_steps','services','settings'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
