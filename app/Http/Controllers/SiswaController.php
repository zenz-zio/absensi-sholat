<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SiswaController extends Controller
{
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
}
