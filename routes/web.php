<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;

Route::post('/login', [AuthController::class, 'login.process'])
    ->name('login.process');

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/admin', function () {
    return view('dashboard.admin.index');
})->name('admin.dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
 // Tambahkan nama ini

Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
Route::get('/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
Route::post('/siswa/create', [SiswaController::class, 'store'])->name('admin.siswa.store');
Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
Route::put('/siswa/edit/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

Route::post('/siswa/update-massal', [SiswaController::class, 'updateMassal'])->name('admin.siswa.update-massal');

Route::get('/absensi', [AbsensiController::class, 'index'])->name('admin.absensi.index');
Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('admin.absensi.create');
Route::post('/absensi/create', [AbsensiController::class, 'store'])->name('admin.absensi.store');
Route::get('/absensi/edit/{id}', [AbsensiController::class, 'edit'])->name('admin.absensi.edit');
Route::put('/absensi/edit/{id}', [AbsensiController::class, 'update'])->name('admin.absensi.update');
Route::delete('/absensi/delete/{id}', [AbsensiController::class, 'destroy'])->name('admin.absensi.delete');

Route::get('/scan', function () {
    return view('dashboard.admin.scanQR.scan');
})->name('admin.scan.index');



Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('store.register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('store.login');

Route::get('/user', [UserController::class, 'index'])
    ->name('user.dashboard');

Route::get('/user/riwayat-absensi', [UserController::class, 'riwayat'])
    ->name('user.riwayat');

Route::get('/user/profil', [UserController::class, 'profil'])
    ->name('user.profil');

Route::get('/user/profil/edit', [UserController::class, 'editProfil'])
    ->name('user.profil.edit');

Route::post('/user/profil/edit', [UserController::class, 'editProfil'])
    ->name('user.profil.update');

Route::get('/user/qr-absen', [SiswaController::class, 'generate'])->name('user.qr.absen');
Route::post('/force-generate-qr', [SiswaController::class, 'forceGenerate'])->name('siswa.force-generate');


// Route::get('/', [BukuController::class, 'index']);
// Route::get('/create', [BukuController::class, 'create']);
// Route::post('/create', [BukuController::class, 'store']);

// Route::get('/edit/{id}', [BukuController::class, 'edit']);
// Route::put('/edit/{id}', [BukuController::class, 'update']);

// Route::delete('/delete/{id}', [BukuController::class, 'destroy']);
