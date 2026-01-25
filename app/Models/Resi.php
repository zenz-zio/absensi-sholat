<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_resi',
        'nama_pengirim',
        'kontak_pengirim',
        'alamat_pengirim',
        'nama_penerima',
        'kontak_penerima',
        'alamat_penerima',
        'jenis_pengiriman',
        'harga',
    ];
}
