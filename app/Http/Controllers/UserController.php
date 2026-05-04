<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
            'user' => Auth::user()
        ]);
    }

    public function editProfil()
    {
        return view('dashboard.user.edit-profil', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfil(Request $request)
    {
        // ✅ validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        // ✅ ambil user login
        $user = Auth::user();

        // ✅ update manual (AMAN, gak error fillable)
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.profil')
            ->with('success', 'Profil berhasil diupdate');
    }

    public function qrAbsen()
    {
        return view('dashboard.user.qr-absen', [
            'kode' => '7ZXCV',
            'expired' => Carbon::now()->addHour()->format('d/m/Y H:i:s'),
            'qrData' => encrypt(Auth::id())
        ]);
    }
}