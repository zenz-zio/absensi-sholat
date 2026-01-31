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
            Schema::create('siswas', function (Blueprint $table) {
    $table->id();
    $table->string('nisn')->unique();   // Nomor Induk Siswa Nasional
    $table->string('kelas');            // contoh: X RPL 1 / 8A
    $table->string('jurusan'); 
    $table->string('id-user');          // contoh: RPL / TKJ / IPA
    $table->timestamps();
    
});

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
