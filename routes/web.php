<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FaceRegisterController;
use App\Http\Controllers\FaceScanController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('store.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
});

Route::prefix('guru')->name('admin.')->middleware('guru')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.admin.index');
    })->name('dashboard');

    Route::get('/scan', function () {
        return view('dashboard.admin.scanQR.scan');
    })->name('ScanQR.index');


    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/create', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/edit/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/update-massal', [SiswaController::class, 'updateMassal'])->name('siswa.update-massal');
    Route::post('/siswa/{id}/reset-face', [FaceRegisterController::class, 'resetFace'])->name('siswa.reset-face');

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/create', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/edit/{id}', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/edit/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('/absensi/delete/{id}', [AbsensiController::class, 'destroy'])->name('absensi.delete');
});

// Data ringkas untuk dashboard admin (total siswa, sudah/belum absensi hari ini),
// dipanggil via fetch() dari halaman dashboard.admin.index.
Route::middleware('guru')->group(function () {
    Route::get('/api/dashboard-absensi', [AbsensiController::class, 'dashboardStats']);
});

Route::prefix('siswa')->name('user.')->middleware('auth', 'siswa')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-absensi', [UserController::class, 'riwayat'])->name('riwayat');
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::get('/profil/edit', [UserController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil/update', [UserController::class, 'updateProfil'])->name('profil.update'); // <-- Ubah ke PUT
    Route::get('/qr-absen', [SiswaController::class, 'generate'])->name('qr.absen');
    Route::post('/force-generate-qr', [SiswaController::class, 'forceGenerate'])->name('force-generate');
    Route::get('/qr-absen/status', [SiswaController::class, 'checkQrStatus'])->name('qr.status');
});

Route::middleware('auth')->group(function () {
    Route::get('/face/register', [FaceRegisterController::class, 'index'])->name('user.face.register');
    Route::post('/face/store', [FaceRegisterController::class, 'store'])->name('user.face.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/scan-wajah', [FaceScanController::class, 'index'])->name('face.scan');
    Route::post('/api/face-match', [FaceScanController::class, 'match'])->name('face.match');
});

// Data ringkas untuk dashboard siswa (status absensi hari ini + total kehadiran),
// dipanggil via fetch() dari halaman dashboard.user.index.
Route::middleware('auth')->group(function () {
    Route::get('/api/user/dashboard-data', [UserController::class, 'dashboardData'])->name('user.dashboard-data');
});

Route::get('/', function () {
    return view('welcome');
});