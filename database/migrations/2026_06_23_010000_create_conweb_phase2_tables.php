<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('hero_title_id')->nullable()->after('desc_en');
            $table->string('hero_title_en')->nullable()->after('hero_title_id');
            $table->string('hero_subtitle_id')->nullable()->after('hero_title_en');
            $table->string('hero_subtitle_en')->nullable()->after('hero_subtitle_id');
            $table->longText('body_id')->nullable()->after('hero_subtitle_en');
            $table->longText('body_en')->nullable()->after('body_id');
        });

        Schema::create('web_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category');
            $table->string('layout')->default('korporat'); // ekspor | umkm | toko-online | korporat
            $table->string('thumbnail')->nullable();
            $table->string('primary_color')->default('#2563eb');
            $table->string('secondary_color')->default('#0a1530');
            $table->boolean('is_featured')->default(false);
            $table->integer('popularity')->default(0);
            $table->string('price_label')->nullable();
            $table->string('tagline_id')->nullable();
            $table->string('tagline_en')->nullable();
            $table->json('demo_services')->nullable(); // [{icon,title_id,title_en,desc_id,desc_en}]
            $table->json('demo_stats')->nullable(); // [{value,label_id,label_en}]
            $table->string('testimonial_name')->nullable();
            $table->string('testimonial_role_id')->nullable();
            $table->string('testimonial_role_en')->nullable();
            $table->text('testimonial_quote_id')->nullable();
            $table->text('testimonial_quote_en')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('package'); // domain | package
            $table->string('name');
            $table->decimal('price', 12, 0);
            $table->decimal('original_price', 12, 0)->nullable();
            $table->string('period')->default('/tahun');
            $table->string('badge')->nullable();
            $table->json('features')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whatsapp');
            $table->string('email')->nullable();
            $table->string('type')->default('custom'); // template | service | package | custom
            $table->string('reference')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // new | contacted | closed
            $table->timestamps();
        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->text('excerpt_id')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('content_id')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('author')->default('ConWeb Team');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('pricing_plans');
        Schema::dropIfExists('web_templates');

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['slug', 'hero_title_id', 'hero_title_en', 'hero_subtitle_id', 'hero_subtitle_en', 'body_id', 'body_en']);
        });
    }
};
