<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (! Schema::hasColumn('siswas', 'face_descriptor')) {
                // Disimpan sebagai JSON: array 128 angka (float) hasil ekstraksi face-api.js
                $table->longText('face_descriptor')->nullable()->after('emergency_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'face_descriptor')) {
                $table->dropColumn('face_descriptor');
            }
        });
    }
};