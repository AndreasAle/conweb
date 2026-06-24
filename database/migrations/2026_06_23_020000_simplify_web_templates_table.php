<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('web_templates', function (Blueprint $table) {
            $table->string('preview_url')->nullable()->after('thumbnail');
            $table->dropColumn([
                'layout',
                'demo_services',
                'demo_stats',
                'testimonial_name',
                'testimonial_role_id',
                'testimonial_role_en',
                'testimonial_quote_id',
                'testimonial_quote_en',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('web_templates', function (Blueprint $table) {
            $table->dropColumn(['preview_url']);
            $table->string('layout')->default('korporat');
            $table->json('demo_services')->nullable();
            $table->json('demo_stats')->nullable();
            $table->string('testimonial_name')->nullable();
            $table->string('testimonial_role_id')->nullable();
            $table->string('testimonial_role_en')->nullable();
            $table->text('testimonial_quote_id')->nullable();
            $table->text('testimonial_quote_en')->nullable();
        });
    }
};
