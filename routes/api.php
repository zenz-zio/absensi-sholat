<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/scan-sholat', [AbsensiController::class, 'scanAbsensi'])->name('api.scan.sholat');
Route::post('/scan-sholat-nisn', [AbsensiController::class, 'absenByNisn']);