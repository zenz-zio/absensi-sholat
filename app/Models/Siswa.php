<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';


    protected $fillable = [
        'user_id',
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

    /**
     * Relasi ke user (ambil nama, email, dll)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke absensi
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_siswa');
    }

    /**
     * Accessor biar bisa pakai ->nama langsung
     */
    public function getNamaAttribute()
    {
        return $this->user->name ?? '-';
    }

    /**
     * Accessor tambahan (opsional tapi berguna)
     */
    public function getEmailAttribute()
    {
        return $this->user->email ?? '-';
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_siswa', 'id_siswa');
    }
}
