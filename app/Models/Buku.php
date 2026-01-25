<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // protected $table = ['kanjud']; sebagai contoh

    protected $fillable = ['judul','penulis','penerbit','tahun_terbit'];
}
