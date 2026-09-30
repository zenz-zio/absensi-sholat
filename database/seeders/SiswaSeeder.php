<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $namaSiswa = [
            'Ahmad Fadillah', 'Bunga Citra Lestari', 'Cahya Ramadhan', 'Dewi Anggraini',
            'Eko Prasetyo', 'Fitri Handayani', 'Galih Setiawan', 'Hana Salsabila',
            'Irfan Hakim', 'Jihan Aulia', 'Krisna Wijaya', 'Lestari Putri',
            'Muhammad Rizki', 'Nadia Safitri', 'Oki Setiadi', 'Putri Ayu Ningtyas',
            'Qori Aditya', 'Rahma Wati', 'Sandi Pratama', 'Tia Amelia',
        ];

        $kelasList = Kelas::all();

        foreach ($namaSiswa as $i => $nama) {
            Siswa::updateOrCreate(
                ['nis' => '2024' . str_pad($i + 1, 4, '0', STR_PAD_LEFT)],
                [
                    'nama'           => $nama,
                    'kelas_id'       => $kelasList->random()->id,
                    'jenis_kelamin'  => $i % 2 === 0 ? 'L' : 'P',
                    'fingerprint_id' => 'SIM-' . strtoupper(substr(md5($nama), 0, 8)),
                ]
            );
        }
    }
}
