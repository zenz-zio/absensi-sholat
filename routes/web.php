<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/admin', function () {
    return view('dashboard.admin.index');
})->name('admin.dashboard');

Route::get('/resi', [ResiController::class, 'index'])->name('admin.resi.index');
Route::get('/resi/create', [ResiController::class, 'create'])->name('admin.resi.create');
Route::post('/resi/create', [ResiController::class, 'store'])->name('admin.resi.store');
Route::get('/resi/edit/{id}', [ResiController::class, 'edit'])->name('admin.resi.edit');
Route::put('/resi/edit/{id}', [ResiController::class, 'update'])->name('admin.resi.update');
Route::delete('/resi/delete/{id}', [ResiController::class, 'destroy'])->name('admin.resi.delete');
Route::get('/resi/qr/{id}', [ResiController::class, 'showQr'])->name('admin.resi.qr');

Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
Route::get('/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
Route::post('/siswa/create', [SiswaController::class, 'store'])->name('admin.siswa.store');
Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
Route::put('/siswa/edit/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete');

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

Route::get('/user', [UserController::class,'index'])
    ->name('user.dashboard');

Route::get('/user/riwayat-absensi', [UserController::class, 'riwayat'])
    ->name('user.riwayat');

Route::get('/user/profil', [UserController::class, 'profil'])
    ->name('user.profil');

Route::get('/user/profil/edit', [UserController::class, 'editProfil'])
    ->name('user.profil.edit');

Route::post('/user/profil/edit', [UserController::class, 'editProfil'])
    ->name('user.profil.update');

Route::get('/user/qr-absen', [UserController::class, 'qrAbsen'])
    ->name('user.qr.absen');

Route::get('/user/qr-absen', [UserController::class, 'qrAbsen']);
Route::get('/user/qr-absen', [UserController::class, 'qrAbsen'])
    ->name('user.qr.absen');








// Route::get('/', [BukuController::class, 'index']);
// Route::get('/create', [BukuController::class, 'create']);
// Route::post('/create', [BukuController::class, 'store']);

// Route::get('/edit/{id}', [BukuController::class, 'edit']);
// Route::put('/edit/{id}', [BukuController::class, 'update']);

// Route::delete('/delete/{id}', [BukuController::class, 'destroy']);
