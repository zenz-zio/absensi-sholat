<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OverviewAbsensi extends Model
{
    // kalau nama tabel bukan plural default
    protected $table = 'overview_absensi';

    protected $fillable = [
        'tanggal',
        'total_siswa',
        'hadir',
        'izin',
        'sakit',
        'alpha',
        'keterangan'
    ];
}
