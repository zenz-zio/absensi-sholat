<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    //{
    protected $table = 'absensis';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'jam_masuk',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
    ];

    // relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}

