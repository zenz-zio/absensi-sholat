<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth; // penting

class SiswaController extends Controller
{
    public function index()
    {
        // ambil siswa + relasi user
        $siswas = Siswa::with('user')->get();

        foreach ($siswas as $siswa) {
            $siswa->status_sholat = false;
        }

        return view('dashboard.admin.siswa.index', compact('siswas'));
    }

    public function generate()
    {
        $userId = Auth::id(); // FIX

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            $siswa = Siswa::create([
                'user_id' => $userId,
                'nama' => Auth::user()->name
            ]);
        }

        $qrMasihValid = false;

        if ($siswa->qr_code && $siswa->qr_expires_at) {
            $qrMasihValid = Carbon::now()->lt($siswa->qr_expires_at);
        }

        $qrData = null;
        $kode = null;
        $expired = null;
        $expiredTimestamp = null;

        if ($qrMasihValid) {
            $qrData = $siswa->qr_code;
            $kode = $siswa->emergency_code;
            $expired = Carbon::parse($siswa->qr_expires_at)->format('d-m-Y H:i:s');
            $expiredTimestamp = Carbon::parse($siswa->qr_expires_at)->timestamp * 1000;
        }

        return view('dashboard.user.qr-absen', compact(
            'qrData',
            'kode',
            'expired',
            'expiredTimestamp',
            'qrMasihValid'
        ));
    }

    public function forceGenerate()
    {
        $userId = Auth::id(); // FIX

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            $siswa = Siswa::create([
                'user_id' => $userId,
                'nama' => Auth::user()->name
            ]);
        }

        $expiredTime = Carbon::now()->addHour();

        $siswa->update([
            'qr_code' => Str::random(200),
            'emergency_code' => Str::upper(Str::random(6)),
            'qr_expires_at' => $expiredTime,
        ]);

        return redirect()
            ->route('user.qr.absen')
            ->with('success', 'QR Code berhasil dibuat!');
    }

    public function updateMassal(Request $request)
    {
        $request->validate([
            'status' => 'required|in:sudah,belum'
        ]);

        $status = $request->status;

        $allStudents = Siswa::all();

        foreach ($allStudents as $student) {
            // isi sesuai kebutuhan nanti
        }

        $message = $status == 'sudah'
            ? 'Semua siswa berhasil ditandai SUDAH SHOLAT!'
            : 'Semua siswa berhasil ditandai BELUM SHOLAT!';

        return redirect()->route('admin.siswa.index')
            ->with('success', $message);
    }
}