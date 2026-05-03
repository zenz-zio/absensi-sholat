<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; // FIX biar gak merah

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.user.index');
    }

    public function riwayat()
    {
        return view('dashboard.user.riwayat');
    }

    public function profil()
    {
        return view('dashboard.user.profil', [
            'user' => Auth::user() // kirim data user
        ]);
    }

    public function editProfil()
    {
        return view('dashboard.user.edit-profil', [
            'user' => Auth::user()
        ]);
    }

    public function qrAbsen()
    {
        $userId = Auth::id(); // FIX (gak merah & gak null aneh)

        return view('dashboard.user.qr-absen', [
            'kode' => '7ZXCV',
            'expired' => Carbon::now()->addHour()->format('d/m/Y H:i:s'),
            'qrData' => encrypt($userId)
        ]);
    }
}