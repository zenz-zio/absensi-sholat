<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    //{
    // simpan absensi
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'status'   => 'nullable|in:hadir,izin,sakit',
        ]);

        $jamMasuk = now()->format('H:i');
        $status   = $request->status;

        // jika hadir → auto cek terlambat
        if ($status === null || $status === 'hadir') {
            $status = $jamMasuk > '07:00' ? 'terlambat' : 'hadir';
        }

        // izin & sakit tidak punya jam masuk
        if (in_array($status, ['izin', 'sakit'])) {
            $jamMasuk = null;
        }

        Absensi::create([
            'siswa_id'  => $request->siswa_id,
            'tanggal'   => now()->toDateString(),
            'jam_masuk' => $jamMasuk,
            'status'    => $status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    // list absensi (opsional)
    public function index()
    {
        $absensis = Absensi::with('siswa')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('dashboard.admin.absensi.index', compact('absensis'));
    }
}
