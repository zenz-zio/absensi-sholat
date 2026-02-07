<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        return view('dashboard.user.profil');
    }

    public function editProfil()
    {
        return view('dashboard.user.edit-profil');
    }

    public function qrAbsen()
    {
        return view('dashboard.user.qr-absen', [
            'kode' => '7ZXCV',
            'expired' => Carbon::now()->addHour()->format('d/m/Y h:i:s A'),
            'qrData' => encrypt(Auth::id() ?? 1)
        ]);
    }
}
