<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    // dashboard siswa
    public function index()
    {
        $siswa = Auth::user();

        return view('dashboard.siswa.index', compact('siswa'));
    }

    // profil siswa
    public function profil()
    {
        $siswa = Auth::user();

        return view('dashboard.siswa.profil', compact('siswa'));
    }

    // update profil siswa
    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $siswa = Auth::user();
        $siswa = ($request->all());

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
