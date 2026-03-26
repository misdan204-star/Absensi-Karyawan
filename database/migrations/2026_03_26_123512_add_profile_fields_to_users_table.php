<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $box) {
            $box->string('phone')->nullable()->after('email');
            $box->string('profile_photo_path')->nullable()->after('phone');
            $box->text('address')->nullable()->after('profile_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $box) {
            $box->dropColumn(['phone', 'profile_photo_path', 'address']);
        });
    }
};
