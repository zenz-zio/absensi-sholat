<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with([
            'user',
            'absensis' => function ($query) {
                $query->whereDate('tanggal', today());
            }
        ])->get();

        foreach ($siswas as $siswa) {
            // Cek apakah siswa punya record absensi hari ini DENGAN status "Sholat"
            // (bukan cuma cek ada/tidaknya record, karena "Tidak Sholat" pun tetap sebuah record)
            $siswa->status_sholat = $siswa->absensis
    ->where('status', 'Sholat')
    ->isNotEmpty();
        }

        return view('dashboard.admin.siswa.index', compact('siswas'));
    }

    public function generate()
    {
        $userId = Auth::id();

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            $siswa = Siswa::create([
                'user_id' => $userId,
                'nisn' => '-',
                'kelas' => '-',
                'jurusan' => '-',
            ]);
        }

        $qrMasihValid = false;

        if ($siswa->qr_code && $siswa->qr_expires_at) {
            $qrMasihValid = Carbon::now()->lt($siswa->qr_expires_at);
        }

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
        $userId = Auth::id();

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            $siswa = Siswa::create([
                'user_id' => $userId,
                'nisn' => '-',
                'kelas' => '-',
                'jurusan' => '-',
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

    /**
     * Cek status QR siswa yang sedang login (dipanggil via polling/fetch
     * dari halaman qr-absen). Dipakai supaya halaman QR bisa otomatis
     * refresh sendiri begitu QR-nya sudah dipakai untuk scan (dihapus
     * oleh AbsensiController::scanAbsensi) atau sudah kedaluwarsa -
     * tanpa siswa perlu refresh manual.
     */
    public function checkQrStatus()
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();

        if (!$siswa) {
            return response()->json(['valid' => false]);
        }

        $qrMasihValid = $siswa->qr_code
            && $siswa->qr_expires_at
            && Carbon::now()->lt($siswa->qr_expires_at);

        return response()->json([
            'valid' => (bool) $qrMasihValid,
        ]);
    }

    /**
     * Tampilkan form tambah siswa baru.
     */
    public function create()
    {
        return view('dashboard.admin.siswa.create');
    }

    /**
     * Simpan siswa baru: bikin akun user baru + data siswa sekaligus,
     * memakai pola yang sama seperti AuthController::register().
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name'     => 'required|string|max:100',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'nisn'     => 'required|digits:10|unique:siswas,nisn',
                'kelas'    => 'required|in:10,11,12',
                'jurusan'  => 'required|in:RPL,TKJ,DKV,BC',
            ],
            [
                'name.required'     => 'Nama wajib diisi',
                'email.required'    => 'Email wajib diisi',
                'email.email'       => 'Format email tidak valid',
                'email.unique'      => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min'      => 'Password minimal 6 karakter',
                'password.confirmed'=> 'Konfirmasi password tidak sama',
                'nisn.required'     => 'NISN wajib diisi',
                'nisn.digits'       => 'NISN harus 10 digit angka',
                'nisn.unique'       => 'NISN sudah terdaftar',
                'kelas.required'    => 'Kelas wajib dipilih',
                'jurusan.required'  => 'Jurusan wajib dipilih',
            ]
        );

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'siswa',
        ]);

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nisn'    => $data['nisn'],
            'kelas'   => $data['kelas'],
            'jurusan' => $data['jurusan'],
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Siswa baru berhasil ditambahkan.')
            ->with('highlight_id', $siswa->id);
    }

    /**
     * Tampilkan form edit siswa.
     */
    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        return view('dashboard.admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data siswa. Password bersifat OPSIONAL - hanya diubah
     * kalau admin isi field password (misalnya siswa lupa password).
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $data = $request->validate(
            [
                'name'     => 'required|string|max:100',
                'email'    => 'required|email|unique:users,email,' . $siswa->user_id,
                'password' => 'nullable|min:6|confirmed',
                'nisn'     => 'required|digits:10|unique:siswas,nisn,' . $siswa->id,
                'kelas'    => 'required|in:10,11,12',
                'jurusan'  => 'required|in:RPL,TKJ,DKV,BC',
            ],
            [
                'name.required'      => 'Nama wajib diisi',
                'email.required'     => 'Email wajib diisi',
                'email.email'        => 'Format email tidak valid',
                'email.unique'       => 'Email sudah dipakai user lain',
                'password.min'       => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sama',
                'nisn.required'      => 'NISN wajib diisi',
                'nisn.digits'        => 'NISN harus 10 digit angka',
                'nisn.unique'        => 'NISN sudah dipakai siswa lain',
                'kelas.required'     => 'Kelas wajib dipilih',
                'jurusan.required'   => 'Jurusan wajib dipilih',
            ]
        );

        // Update akun user (nama & email selalu, password hanya kalau diisi)
        $userUpdate = [
            'name'  => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $userUpdate['password'] = Hash::make($data['password']);
        }

        $siswa->user->update($userUpdate);

        // Update data siswa
        $siswa->update([
            'nisn'    => $data['nisn'],
            'kelas'   => $data['kelas'],
            'jurusan' => $data['jurusan'],
        ]);

        $message = !empty($data['password'])
            ? 'Data siswa berhasil diperbarui, password baru sudah aktif.'
            : 'Data siswa berhasil diperbarui.';

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', $message)
            ->with('highlight_id', $siswa->id);
    }

    /**
     * Absen massal - tandai beberapa siswa sekaligus sudah absen hari ini.
     * Memakai updateOrCreate supaya tidak membuat data dobel jika siswa
     * sudah punya record absensi hari ini (konsisten dengan AbsensiController::store).
     */
    public function updateMassal(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:siswas,id',
        ]);

        foreach ($request->ids as $id) {
            Absensi::updateOrCreate(
                [
                    'id_siswa' => $id,
                    'tanggal'  => now()->toDateString(),
                ],
                [
                    'id_recorder' => Auth::id(),
                    'status'      => 'Sholat',
                    'jam_masuk'   => now()->format('H:i:s'),
                ]
            );
        }

        return redirect()->route('admin.siswa.index')
            ->with('success', count($request->ids) . ' siswa berhasil ditandai sudah absen!');
    }

    /**
     * Hapus data siswa beserta riwayat absensinya.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus dulu data absensi terkait supaya tidak kena error foreign key
        $siswa->absensis()->delete();

        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}