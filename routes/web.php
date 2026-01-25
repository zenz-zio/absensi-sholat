<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ResiController;
use Illuminate\Support\Facades\Route;

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

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('store.register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('store.login');

// Route::get('/', [BukuController::class, 'index']);
// Route::get('/create', [BukuController::class, 'create']);
// Route::post('/create', [BukuController::class, 'store']);

// Route::get('/edit/{id}', [BukuController::class, 'edit']);
// Route::put('/edit/{id}', [BukuController::class, 'update']);

// Route::delete('/delete/{id}', [BukuController::class, 'destroy']);
