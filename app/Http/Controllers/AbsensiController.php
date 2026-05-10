<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Simpan absensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswas,id',
            'status' => 'required|in:Sholat,Tidak Sholat',
            'keterangan' => 'nullable|string'
        ]);

        Absensi::create([
            'id_recorder' => Auth::id(),
            'id_siswa' => $request->id_siswa,
            'tanggal' => now()->toDateString(),
            'status' => $request->status,
            'jam_masuk' => $request->status == 'Sholat' ? now()->format('H:i') : null,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    /**
     * ADMIN - lihat semua absensi
     */
    public function index()
    {
        $absensis = Absensi::with(['siswa.user', 'recorder'])
            ->latest('tanggal')
            ->get();

        return view('dashboard.admin.absensi.index', [
            'absensis' => $absensis
        ]);
    }

    public function scanAbsensi(Request $request)
    {
        $request->validate([
            'id_recorder'    => 'required',
            'qr_code'        => 'nullable|string',
            'emergency_code' => 'nullable|string',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        $siswa = Siswa::where('qr_code', $request->qr_code)
            ->orWhere('emergency_code', $request->emergency_code)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        $absensi = Absensi::create([
            'id_recorder' => $request->id_recorder,
            'id_siswa'    => $siswa->id,
            'tanggal'     => now()->toDateString(),
            'status'      => 'Sholat',
            'jam_masuk'   => now()->toTimeString(),
            'keterangan'  => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil disimpan.',
            'data'    => $absensi,
        ], 201);
    }
}
