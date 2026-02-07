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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_siswa');
            $table->string('nisn')->unique();   // Nomor Induk Siswa Nasional
            $table->string('kelas');            // contoh: X RPL 1 / 8A
            $table->string('jurusan');          // contoh: RPL / TKJ / IPA
            $table->string('qr_code')->nullable();
            $table->string('emergency_code')->nullable();
            $table->timestamp('qr_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
