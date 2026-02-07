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
            return redirect()->back()->with('error', 'Siswa tidak ditemukan');
        }

        $now = Carbon::now();
        $qrExpired = Carbon::parse($siswa->qr_expires_at);

        if ($now->greaterThanOrEqualTo($qrExpired) || is_null($siswa->qr_code)) {
            $randomQr = Str::random(32);
            $emergencyCode = Str::upper(Str::random(6));
            $expiredTime = Carbon::now()->addHour();

            $siswa->update([
                'qr_code' => $randomQr,
                'emergency_code' => $emergencyCode,
                'qr_expires_at' => $expiredTime,
            ]);
        } else {
            $randomQr = $siswa->qr_code;
            $emergencyCode = $siswa->emergency_code;
            $expiredTime = $qrExpired;
        }

        $qrData = $randomQr;
        $kode = $emergencyCode;
        $expired = $expiredTime->format('d-m-Y H:i:s');
        $expiredTimestamp = $expiredTime->getTimestamp() * 1000;

        return view('qr-generate', compact('qrData', 'kode', 'expired', 'expiredTimestamp'));
    }
}
