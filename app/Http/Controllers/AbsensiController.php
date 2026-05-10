<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Simpan absensi manual
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa'   => 'required|exists:siswas,id',
            'status'     => 'required|in:Sholat,Tidak Sholat',
            'keterangan' => 'nullable|string'
        ]);

        Absensi::create([
            'id_recorder' => Auth::id(),
            'id_siswa'    => $request->id_siswa,
            'tanggal'     => now(),
            'status'      => $request->status,
            'jam_masuk'   => $request->status == 'Sholat'
                                ? now()->format('H:i:s')
                                : null,
            'keterangan'  => $request->keterangan,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    /**
     * ADMIN - semua absensi
     */
    public function index()
    {
        $absensis = Absensi::with(['siswa', 'recorder'])
            ->latest()
            ->get();

        return view('dashboard.admin.absensi.index', compact('absensis'));
    }

    /**
     * SISWA - riwayat absensi
     */
    public function riwayat()
    {
        // user login
        $user = Auth::user();

        // cari siswa berdasarkan user_id
        $siswa = Siswa::where('user_id', $user->id)->first();

        // jika siswa tidak ditemukan
        if (!$siswa) {

            $absensis = collect();

        } else {

            // ambil data absensi
            $absensis = Absensi::with('siswa')
                ->where('id_siswa', $siswa->id)
                ->latest()
                ->get();
        }

        return view('dashboard.user.riwayat', compact('absensis'));
    }

    /**
     * Scan QR Absensi
     */
    public function scanAbsensi(Request $request)
    {
        $request->validate([
            'id_recorder'    => 'required',
            'qr_code'        => 'nullable|string',
            'emergency_code' => 'nullable|string',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        $siswa = null;

        // cari QR
        if ($request->filled('qr_code')) {
            $siswa = Siswa::where('qr_code', $request->qr_code)->first();
        }

        // cari emergency code
        if (!$siswa && $request->filled('emergency_code')) {
            $siswa = Siswa::where('emergency_code', $request->emergency_code)->first();
        }

        // jika tidak ditemukan
        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        // cek sudah absen hari ini
        $cek = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal', now())
            ->first();

        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah absen hari ini.',
            ], 400);
        }

        // simpan absensi
        $absensi = Absensi::create([
            'id_recorder' => $request->id_recorder,
            'id_siswa'    => $siswa->id,
            'tanggal'     => now(),
            'status'      => 'Sholat',
            'jam_masuk'   => now()->format('H:i:s'),
            'keterangan'  => $request->keterangan,
        ]);

        // hapus qr setelah dipakai
        $siswa->update([
            'qr_code'        => null,
            'emergency_code' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil.',
            'data'    => $absensi
        ]);
    }
}