<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            // relasi manual (tanpa foreignId)
            $table->unsignedBigInteger('siswa_id');

            $table->date('tanggal');

            $table->enum('status', [
                'hadir',
                'terlambat',
                'izin',
                'sakit',
                'tidak_hadir'
            ]);

            $table->time('jam_masuk')->nullable();
            $table->text('keterangan')->nullable();

                $table->timestamps();
            });
        }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
