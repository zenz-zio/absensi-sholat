<?php

// Jadwal ini dipakai untuk mendeteksi otomatis "sesi sholat aktif" saat ini
// berdasarkan jam server. Silakan sesuaikan jam per wilayah/musim.
// Format jam: 24 jam, "HH:MM"

return [
    'sesi' => [
        'subuh'   => ['label' => 'Subuh',  'mulai' => '04:00', 'selesai' => '06:00'],
        'dzuhur'  => ['label' => 'Dzuhur', 'mulai' => '12:00', 'selesai' => '13:30'],
        'ashar'   => ['label' => 'Ashar',  'mulai' => '15:00', 'selesai' => '16:30'],
        'maghrib' => ['label' => 'Maghrib','mulai' => '18:00', 'selesai' => '19:00'],
        'isya'    => ['label' => 'Isya',   'mulai' => '19:00', 'selesai' => '20:30'],
        'jumat'   => ['label' => 'Jumat',  'mulai' => '11:30', 'selesai' => '13:30'],
    ],

    // toleransi keterlambatan (menit) sebelum status jadi "telat"
    'toleransi_menit' => 10,
];
