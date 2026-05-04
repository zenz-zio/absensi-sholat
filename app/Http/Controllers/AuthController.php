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
            ],
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Login berhasil');
        }

        // JIKA GAGAL
        return back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput();
    }

    // ================= REGISTER =================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi semua field dari form (termasuk data siswa)
        $data = $request->validate(
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'nisn' => 'required|digits:10|unique:siswas,nisn', // NISN 10 digit, unik di tabel siswa
                'kelas' => 'required|in:10,11,12',
                'jurusan' => 'required|in:IPA,IPS,RPL,TKJ',
            ],
            [
                // Custom pesan error (bisa disesuaikan)
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
            ],
        );

        // 2. Simpan ke tabel users (dapatkan objek user yang baru)
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // atau 'siswa' tergantung role di sistemmu
        ]);

        // 3. Simpan data ke tabel siswa (relasi one-to-one)
        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $data['nisn'],
            'kelas' => $data['kelas'],
            'jurusan' => $data['jurusan'],
            'qr_code' => null, // optional, bisa di-generate nanti
            'emergency_code' => null, // optional
            'qr_expires_at' => null, // optional
        ]);

        // 4. Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
