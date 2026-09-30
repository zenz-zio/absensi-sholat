<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceRegisterController extends Controller
{
    /**
     * Sama seperti threshold di FaceScanController — jarak di bawah ini
     * dianggap "wajah yang sama".
     */
    private const MATCH_THRESHOLD = 0.6;

    /**
     * Tampilkan halaman untuk siswa mendaftarkan wajahnya.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;

        return view('dashboard.user.face-register', compact('siswa'));
    }

    /**
     * Simpan descriptor wajah (128 angka) hasil ekstraksi face-api.js di browser.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descriptor'   => 'required|array|size:128',
            'descriptor.*' => 'required|numeric',
        ]);

        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa untuk akun ini tidak ditemukan.',
            ], 422);
        }

        // Sekali wajah terdaftar, siswa tidak bisa ganti sendiri —
        // harus minta admin reset dulu lewat halaman Data Siswa.
        if ($siswa->hasFaceRegistered()) {
            return response()->json([
                'success' => false,
                'message' => 'Wajah kamu sudah terdaftar. Hubungi admin/guru untuk reset wajah kalau ingin mendaftar ulang.',
            ], 403);
        }

        $inputDescriptor = $request->descriptor;

        // Cek wajah ini sudah terdaftar di akun siswa LAIN atau belum
        $siswaLain = Siswa::whereNotNull('face_descriptor')
            ->where('id', '!=', $siswa->id)
            ->get();

        foreach ($siswaLain as $lain) {
            $distance = $this->euclideanDistance($inputDescriptor, $lain->face_descriptor);

            if ($distance <= self::MATCH_THRESHOLD) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wajah ini sudah terdaftar di akun siswa lain (' . ($lain->nama ?? 'siswa lain') . '). Satu wajah hanya boleh dipakai untuk satu akun.',
                ], 422);
            }
        }

        $siswa->face_descriptor = $inputDescriptor;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Wajah berhasil didaftarkan.',
        ]);
    }

    private function euclideanDistance(array $a, array $b): float
    {
        $sum = 0;
        foreach ($a as $i => $value) {
            $sum += ($value - ($b[$i] ?? 0)) ** 2;
        }

        return sqrt($sum);
    }

    /**
     * ADMIN — reset wajah terdaftar milik siswa tertentu, supaya siswa
     * bisa mendaftar ulang wajahnya sendiri lagi.
     */
    public function resetFace($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->face_descriptor = null;
        $siswa->save();

        return redirect()
            ->back()
            ->with('success', 'Wajah ' . ($siswa->nama ?? 'siswa') . ' berhasil direset. Siswa bisa mendaftar ulang.');
    }
}