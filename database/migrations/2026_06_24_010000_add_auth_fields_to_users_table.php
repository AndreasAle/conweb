<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('google_id')->nullable()->unique()->after('phone');
            $table->string('avatar')->nullable()->after('google_id');
            $table->string('verification_code', 6)->nullable()->after('avatar');
            $table->timestamp('verification_expires_at')->nullable()->after('verification_code');
            $table->timestamp('offer_sent_at')->nullable()->after('verification_expires_at');
        });

        // Google users won't have a password.
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'google_id', 'avatar', 'verification_code', 'verification_expires_at', 'offer_sent_at']);
        });
    }
};
