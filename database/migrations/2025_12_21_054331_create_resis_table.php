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
        Schema::create('resis', function (Blueprint $table) {
            $table->id();
            $table->string('no_resi');
            $table->string('nama_pengirim');
            $table->string('kontak_pengirim');
            $table->string('alamat_pengirim');
            $table->string('nama_penerima');
            $table->string('kontak_penerima');
            $table->string('alamat_penerima');
            $table->string('jenis_pengiriman');
            $table->string('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resis');
    }
};
