<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            if (! Schema::hasColumn('absensis', 'waktu_sholat')) {
                // Nilai: Subuh | Dzuhur | Ashar | Maghrib | Isya
                $table->string('waktu_sholat')->nullable()->after('id_siswa');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            if (Schema::hasColumn('absensis', 'waktu_sholat')) {
                $table->dropColumn('waktu_sholat');
            }
        });
    }
};