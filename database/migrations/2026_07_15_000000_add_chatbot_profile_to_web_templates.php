<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('web_templates', function (Blueprint $table) {
            // Profil chatbot AI per template/usaha (demo di halaman preview).
            $table->boolean('chatbot_enabled')->default(true)->after('preview_url');
            $table->string('chatbot_business_name')->nullable()->after('chatbot_enabled'); // nama usaha di demo (mis. Geprek Bar)
            $table->string('chatbot_tone')->default('ramah & santai')->after('chatbot_business_name');
            $table->text('chatbot_about')->nullable()->after('chatbot_tone');       // deskripsi singkat usaha
            $table->text('chatbot_offerings')->nullable()->after('chatbot_about');   // menu/produk + harga (bebas)
            $table->string('chatbot_hours')->nullable()->after('chatbot_offerings'); // jam operasional
            $table->string('chatbot_location')->nullable()->after('chatbot_hours');  // lokasi/cabang
            $table->string('chatbot_contact')->nullable()->after('chatbot_location'); // WA/kontak usaha
            $table->json('chatbot_faq')->nullable()->after('chatbot_contact');       // [{q, a}]
            $table->string('chatbot_greeting')->nullable()->after('chatbot_faq');    // sapaan awal custom
        });
    }

    public function down(): void
    {
        Schema::table('web_templates', function (Blueprint $table) {
            $table->dropColumn([
                'chatbot_enabled', 'chatbot_business_name', 'chatbot_tone', 'chatbot_about',
                'chatbot_offerings', 'chatbot_hours', 'chatbot_location', 'chatbot_contact',
                'chatbot_faq', 'chatbot_greeting',
            ]);
        });
    }
};
