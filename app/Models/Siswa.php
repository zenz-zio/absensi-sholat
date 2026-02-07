<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_siswa',
        'nisn',
        'kelas',
        'jurusan',
        'qr_code',
        'emergency_code',
        'qr_expires_at',
    ];

    protected $casts = [
        'qr_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_siswa');
    }
}
