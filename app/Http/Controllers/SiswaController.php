<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SiswaController extends Controller
{

    public function index()
    {
        // Ambil data siswa
        $siswas = Siswa::all();

        // Jika ingin menampilkan status sholat, Anda perlu menyesuaikan
        // Contoh sederhana:
        foreach ($siswas as $siswa) {
            // Ambil status sholat dari database atau default false
            $siswa->status_sholat = false; // Ganti dengan query database sebenarnya
        }

        return view('dashboard.admin.siswa.index', compact('siswas'));
    }


    public function generate()
    {
        $userId = 1;

        $siswa = Siswa::where('id_siswa', $userId)->first();

        if (!$siswa) {
            $siswa = Siswa::create([
                'id_siswa' => $userId,
            ]);
        }

        $qrMasihValid = false;

        if ($siswa->qr_code && $siswa->qr_expires_at) {
            $qrMasihValid = Carbon::now()->lt($siswa->qr_expires_at);
        }

        // DEFAULT VALUE (BIAR VIEW AMAN)
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
        $userId = 1;

        $siswa = Siswa::where('id_siswa', $userId)->first();

        if (!$siswa) {
            $siswa = Siswa::create([
                'id_siswa' => $userId,
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
        $today = now()->toDateString();

        // Ambil semua siswa
        $allStudents = Siswa::all();

        // Update status di database
        // Asumsi: Ada tabel sholat atau absensi dengan kolom 'status'
        // Contoh sederhana:
        foreach ($allStudents as $student) {
            // Update atau buat record absensi sholat
            // Ini hanya contoh, sesuaikan dengan struktur database Anda

            // Jika menggunakan tabel terpisah untuk absensi sholat
            // Sholat::updateOrCreate(
            //     ['siswa_id' => $student->id, 'tanggal' => $today],
            //     ['status' => $status]
            // );

            // Atau jika ada kolom di tabel siswa untuk status sholat hari ini
            // $student->update(['status_sholat_hari_ini' => $status]);
        }

        // Pesan sukses
        $message = $status == 'sudah'
            ? 'Semua siswa berhasil ditandai SUDAH SHOLAT!'
            : 'Semua siswa berhasil ditandai BELUM SHOLAT!';

        return redirect()->route('admin.siswa.index')
            ->with('success', $message);
    }
}
