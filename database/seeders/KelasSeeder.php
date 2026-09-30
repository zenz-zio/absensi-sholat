<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $daftarKelas = [
            ['nama_kelas' => 'VII-A', 'wali_kelas' => 'Ibu Siti Aminah'],
            ['nama_kelas' => 'VII-B', 'wali_kelas' => 'Bapak Ahmad Fauzi'],
            ['nama_kelas' => 'VIII-A', 'wali_kelas' => 'Ibu Rina Wulandari'],
            ['nama_kelas' => 'VIII-B', 'wali_kelas' => 'Bapak Dedi Kurniawan'],
            ['nama_kelas' => 'IX-A', 'wali_kelas' => 'Ibu Nur Hasanah'],
        ];

        foreach ($daftarKelas as $kelas) {
            Kelas::updateOrCreate(['nama_kelas' => $kelas['nama_kelas']], $kelas);
        }
    }
}
