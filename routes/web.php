<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('layouts.main');
// })->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('store.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('dashboard');
});

Route::prefix('guru')->name('admin.')->middleware('guru')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.admin.index');
    })->name('dashboard');
    Route::get('/scan', function () {
        return view('dashboard.admin.scanQR.scan');
    })->name('scan');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/create', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/edit/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/update-massal', [SiswaController::class, 'updateMassal'])->name('siswa.update-massal');

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/create', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/edit/{id}', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/edit/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('/absensi/delete/{id}', [AbsensiController::class, 'destroy'])->name('absensi.delete');
});


Route::prefix('siswa')->name('user.')->middleware('siswa')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-absensi', [UserController::class, 'riwayat'])->name('riwayat');
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::get('/profil/edit', [UserController::class, 'editProfil'])->name('profil.edit');
    Route::post('/profil/edit', [UserController::class, 'updateProfil'])->name('profil.update');
    Route::get('/qr-absen', [SiswaController::class, 'generate'])->name('qr.absen');
    Route::post('/force-generate-qr', [SiswaController::class, 'forceGenerate'])->name('force-generate');
});
