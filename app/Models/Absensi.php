<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';

    protected $fillable = [
        'id_recorder',
        'id_siswa',
        'tanggal',
        'status',
        'jam_masuk',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'id_recorder');
    }
}
