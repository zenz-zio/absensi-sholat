<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil (view: profil-user.blade.php).
     */
    public function index()
    {
        return view('user.profil'); // sesuaikan path view kalau beda
    }

    /**
     * Tampilkan form edit profil (view: edit-profil.blade.php).
     */
    public function edit()
    {
        return view('user.edit-profil'); // cocok dengan resources/views/user/edit-profil.blade.php
    }

    /**
     * Proses update nama, email, dan foto profil.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB, samain sama batas di JS
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('foto')) {
            // Hapus foto lama supaya storage tidak numpuk file yang tidak terpakai
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan file baru ke storage/app/public/profile_photos
            $path = $request->file('foto')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()
            ->route('user.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}