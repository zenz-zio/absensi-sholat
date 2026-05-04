<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
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

    /**
     * USER - riwayat absensi sendiri
     */
   
}
