<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class FaceScanController extends Controller
{
    /**
     * Threshold jarak Euclidean untuk dianggap "wajah yang sama".
     * Nilai 0.6 dari dokumentasi face-api.js sering kebobolan di kondisi
     * kamera/pencahayaan tidak terkontrol (seperti absensi di lapangan).
     * 0.45 lebih ketat dan lebih aman untuk kasus ini.
     * Kalibrasi ulang berdasarkan log jarak (lihat method match()) kalau perlu.
     */
    private const MATCH_THRESHOLD = 0.45;

    /**
     * Tampilkan halaman scan wajah (untuk recorder).
     */
    public function index()
    {
        return view('dashboard.admin.ScanQR.scan-wajah');
    }

    /**
     * Terima descriptor wajah dari kamera, cocokkan dengan siswa terdaftar,
     * lalu catat absensi kalau ketemu.
     *
     * Siswa yang sudah absen untuk waktu sholat yang sama hari ini akan
     * DITOLAK (tidak bisa scan ulang), tapi begitu masuk waktu sholat
     * berikutnya (waktu_sholat beda), dia bisa scan lagi.
     */
    public function match(Request $request)
    {
        $request->validate([
            'descriptor'   => 'required|array|size:128',
            'descriptor.*' => 'required|numeric',
            'id_recorder'  => 'required',
            'prayer_name'  => 'required|in:Subuh,Dzuhur,Ashar,Maghrib,Isya',
            'keterangan'   => 'nullable|string',
        ]);

        $inputDescriptor = $request->descriptor;

        // with('user') supaya nama siswa bisa diambil dari relasi users
        $siswas = Siswa::with('user')->whereNotNull('face_descriptor')->get();

        $bestMatch = null;
        $bestDistance = null;

        foreach ($siswas as $siswa) {
            // face_descriptor harus sudah di-cast jadi array di Model Siswa,
            // lihat catatan di app/Models/Siswa.php
            $distance = $this->euclideanDistance($inputDescriptor, $siswa->face_descriptor);

            if ($bestDistance === null || $distance < $bestDistance) {
                $bestDistance = $distance;
                $bestMatch = $siswa;
            }
        }

        if (! $bestMatch || $bestDistance > self::MATCH_THRESHOLD) {
            // Logging sementara untuk kalibrasi threshold.
            // Hapus/nonaktifkan setelah threshold dirasa pas.
            \Log::info('Face rejected - tidak dikenali', [
                'closest_siswa_id' => $bestMatch?->id,
                'distance'          => $bestDistance,
                'threshold'         => self::MATCH_THRESHOLD,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Wajah tidak dikenali. Coba lagi atau gunakan QR/NISN.',
            ], 404);
        }

        // ==== Cek sudah absen untuk waktu sholat ini hari ini ====
        $sudahAbsenWaktuIni = Absensi::where('id_siswa', $bestMatch->id)
            ->whereDate('tanggal', now())
            ->where('waktu_sholat', $request->prayer_name)
            ->where('status', 'Sholat')
            ->exists();

        if ($sudahAbsenWaktuIni) {
            return response()->json([
                'success' => false,
                'message' => ($bestMatch->user->name ?? 'Siswa') . ' sudah absen untuk waktu ' . $request->prayer_name . ' hari ini.',
            ], 409);
        }

        // ==== Catat absensi (1 baris per siswa per waktu sholat per hari) ====
        $absensi = Absensi::updateOrCreate(
            [
                'id_siswa'     => $bestMatch->id,
                'tanggal'      => now()->toDateString(),
                'waktu_sholat' => $request->prayer_name,
            ],
            [
                'id_recorder' => $request->id_recorder,
                'jam_masuk'   => now()->format('H:i:s'),
                'status'      => 'Sholat',
                'keterangan'  => $request->keterangan ?? ('Sholat ' . $request->prayer_name . ' (via wajah)'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat via pengenalan wajah!',
            'data' => [
                'siswa' => [
                    'nama' => $bestMatch->user->name ?? null,
                    'nisn' => $bestMatch->nisn,
                ],
                'jarak_kemiripan' => round($bestDistance, 4), // 0 = identik, makin besar makin beda
            ],
        ]);
    }

    private function euclideanDistance(array $a, array $b): float
    {
        $sum = 0;
        foreach ($a as $i => $value) {
            $sum += ($value - ($b[$i] ?? 0)) ** 2;
        }

        return sqrt($sum);
    }
}