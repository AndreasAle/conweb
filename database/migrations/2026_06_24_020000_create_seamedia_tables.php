<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seamedia_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Care / Launch / Signature
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('seamedia_services', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('web');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('seamedia_showcases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('preview_url')->nullable(); // link demo "Lihat"
            $table->boolean('is_featured')->default(false);
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('seamedia_addons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seamedia_packages');
        Schema::dropIfExists('seamedia_services');
        Schema::dropIfExists('seamedia_showcases');
        Schema::dropIfExists('seamedia_addons');
    }
};
