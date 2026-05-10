<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';


    protected $fillable = [
        'user_id', // WAJIB biar relasi ke users jalan
        'nisn',
        'nama', // tambahin ini biar bisa ditampilkan
        'kelas',
        'jurusan',
        'qr_code',
        'emergency_code',
        'qr_expires_at',
    ];

    protected $casts = [
        'qr_expires_at' => 'datetime',
    ];

    // Relasi ke absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_siswa', 'id');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // kasih foreign key biar jelas
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_siswa', 'id_siswa');
    }
}
