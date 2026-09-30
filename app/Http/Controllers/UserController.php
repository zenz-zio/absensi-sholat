<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.user.index');
    }

    public function riwayat()
    {
        $absensis = Absensi::with(['siswa.user'])
            ->whereHas('siswa', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest('tanggal')
            ->get();

        return view('dashboard.user.riwayat', [
            'absensis' => $absensis
        ]);
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

    /**
     * Update profil user (nama, email, dan foto)
     */
    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Update name dan email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()
            ->route('user.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function qrAbsen()
    {
        return view('dashboard.user.qr-absen', [
            'kode' => '7ZXCV',
            'expired' => Carbon::now()->addHour()->format('d/m/Y H:i:s'),
            'qrData' => encrypt(Auth::id())
        ]);
    }

    /**
     * Data ringkas untuk dashboard siswa (dipanggil via fetch dari
     * dashboard.user.index): status absensi hari ini + total kehadiran.
     */
    public function dashboardData()
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();

        if (! $siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa untuk akun ini tidak ditemukan.',
            ], 404);
        }

        // Cek absensi hari ini dengan status "Sholat"
        $absenHariIni = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal', now())
            ->where('status', 'Sholat')
            ->exists();

        // Total kehadiran keseluruhan (semua hari, status Sholat)
        $totalHadir = Absensi::where('id_siswa', $siswa->id)
            ->where('status', 'Sholat')
            ->count();

        return response()->json([
            'success'          => true,
            'status_absensi'   => $absenHariIni ? 'Sudah Absen' : 'Belum Absen',
            'total_kehadiran'  => $totalHadir,
        ]);
    }
}