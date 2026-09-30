<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ================= LOGIN =================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
            ]
        );

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email tidak terdaftar',
                ])
                ->withInput();
        }

        // Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Password salah',
                ])
                ->withInput();
        }

        // Login berhasil
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Login berhasil');
    }

    // ================= REGISTER =================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'nisn' => 'required|digits:10|unique:siswas,nisn',
                'kelas' => 'required|in:10,11,12',
                'jurusan' => 'required|in:DKV,BC,RPL,TKJ',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sama',
                'nisn.required' => 'NISN wajib diisi',
                'nisn.digits' => 'NISN harus 10 digit angka',
                'nisn.unique' => 'NISN sudah terdaftar',
                'kelas.required' => 'Kelas wajib dipilih',
                'jurusan.required' => 'Jurusan wajib dipilih',
            ]
        );

        // Simpan user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa',
        ]);

        // Simpan data siswa
        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $data['nisn'],
            'kelas' => $data['kelas'],
            'jurusan' => $data['jurusan'],
            'qr_code' => null,
            'emergency_code' => null,
            'qr_expires_at' => null,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    // ================= LOGOUT =================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Berhasil logout');
    }
}