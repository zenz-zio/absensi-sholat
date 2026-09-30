<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Update/simpan status absensi manual (dipanggil dari modal
     * "Edit Status Absensi" di halaman Data Siswa).
     *
     * PENTING: waktu_sholat SENGAJA tidak dimasukkan ke key pencarian
     * updateOrCreate. Badge "Sudah Absen"/"Belum Absen" di halaman Data
     * Siswa (lihat SiswaController::index -> $siswa->status_sholat)
     * dihitung dari ADA/TIDAKNYA record hari ini dengan status 'Sholat',
     * tanpa peduli waktu_sholat spesifik. Kalau waktu_sholat dimasukkan
     * ke key di sini, edit manual akan selalu membuat row BARU (karena
     * request ini tidak mengirim waktu_sholat -> selalu NULL) alih-alih
     * meng-update row yang sudah ada dari scan wajah/QR (yang waktu_sholat-nya
     * terisi), sehingga status kelihatan "tidak berubah" di tabel.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa'     => 'required|exists:siswas,id',
            'status'       => 'required|in:Sholat,Tidak Sholat',
            'waktu_sholat' => 'nullable|in:Subuh,Dzuhur,Ashar,Maghrib,Isya',
            'keterangan'   => 'nullable|string'
        ]);

        Absensi::updateOrCreate(
            [
                'id_siswa' => $request->id_siswa,
                'tanggal'  => now()->toDateString(),
            ],
            [
                'id_recorder'  => Auth::id(),
                'status'       => $request->status,
                'waktu_sholat' => $request->waktu_sholat,
                'jam_masuk'    => $request->status == 'Sholat'
                                    ? now()->format('H:i:s')
                                    : null,
                'keterangan'   => $request->keterangan,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status absensi berhasil diperbarui']);
        }

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    public function dashboardStats(Request $request)
    {
        $totalSiswa = Siswa::count();

        $query = Absensi::whereDate('tanggal', now())
            ->where('status', 'Sholat');

        $prayer = $request->query('prayer');

        if ($prayer) {
            $query->where('waktu_sholat', $prayer);
        }

        $sudahAbsensi = (clone $query)->distinct('id_siswa')->count('id_siswa');
        $belumAbsensi = max($totalSiswa - $sudahAbsensi, 0);

        return response()->json([
            'success' => true,
            'data' => [
                'total_siswa'   => $totalSiswa,
                'sudah_absensi' => $sudahAbsensi,
                'belum_absensi' => $belumAbsensi,
                'waktu_sholat'  => $prayer,
            ],
        ]);
    }

    public function index()
    {
        $absensis = Absensi::with(['siswa', 'recorder'])
            ->latest()
            ->get();

        return view('dashboard.admin.absensi.index', compact('absensis'));
    }

    public function riwayat()
    {

        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->first();


        if (!$siswa) {

            $absensis = collect();

        } else {


            $absensis = Absensi::with('siswa')
                ->where('id_siswa', $siswa->id)
                ->latest()
                ->get();
        }

        return view('dashboard.user.riwayat', compact('absensis'));
    }

    public function scanAbsensi(Request $request)
    {
        $request->validate([
            'id_recorder'    => 'required',
            'qr_code'        => 'nullable|string',
            'emergency_code' => 'nullable|string',
            'prayer_name'    => 'nullable|in:Subuh,Dzuhur,Ashar,Maghrib,Isya',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        $siswa = null;


        if ($request->filled('qr_code')) {
            $siswa = Siswa::where('qr_code', $request->qr_code)->first();
        }


        if (!$siswa && $request->filled('emergency_code')) {
            $siswa = Siswa::where('emergency_code', $request->emergency_code)->first();
        }


        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }


        $cek = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal', now())
            ->where('status', 'Sholat')
            ->when($request->filled('prayer_name'), function ($q) use ($request) {
                $q->where('waktu_sholat', $request->prayer_name);
            })
            ->first();

        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah absen' . ($request->filled('prayer_name') ? ' untuk waktu ' . $request->prayer_name : '') . ' hari ini.',
            ], 400);
        }


        $absensi = Absensi::create([
            'id_recorder'  => $request->id_recorder,
            'id_siswa'     => $siswa->id,
            'waktu_sholat' => $request->prayer_name,
            'tanggal'      => now(),
            'status'       => 'Sholat',
            'jam_masuk'    => now()->format('H:i:s'),
            'keterangan'   => $request->keterangan,
        ]);


        $siswa->update([
            'qr_code'        => null,
            'emergency_code' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil.',
            'data'    => [
                'siswa' => [
                    'nama' => $siswa->nama,
                    'nisn' => $siswa->nisn,
                ],
            ],
        ]);
    }

    public function absenByNisn(Request $request)
    {
        $request->validate([
            'nisn'        => 'required|string',
            'id_recorder' => 'required',
            'prayer_name' => 'nullable|in:Subuh,Dzuhur,Ashar,Maghrib,Isya',
            'keterangan'  => 'nullable|string|max:255',
        ]);


        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'NISN tidak ditemukan.',
            ], 404);
        }

        $cek = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal', now())
            ->where('status', 'Sholat')
            ->when($request->filled('prayer_name'), function ($q) use ($request) {
                $q->where('waktu_sholat', $request->prayer_name);
            })
            ->first();

        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah absen' . ($request->filled('prayer_name') ? ' untuk waktu ' . $request->prayer_name : '') . ' hari ini.',
            ], 400);
        }

        $absensi = Absensi::create([
            'id_recorder'  => $request->id_recorder,
            'id_siswa'     => $siswa->id,
            'waktu_sholat' => $request->prayer_name,
            'tanggal'      => now(),
            'status'       => 'Sholat',
            'jam_masuk'    => now()->format('H:i:s'),
            'keterangan'   => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil.',
            'data'    => ['siswa' => $siswa]
        ]);
    }
}