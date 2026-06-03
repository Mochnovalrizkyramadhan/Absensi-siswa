<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Api\PresensiController as ApiPresensiController;
use App\Http\Controllers\Api\SiswaController as ApiSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('siswa.index');
});

Route::resource('siswa', SiswaController::class)->except(['show']);
Route::get('presensi', [PresensiController::class, 'index'])->name('presensi.index');
Route::get('presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
Route::post('presensi', [PresensiController::class, 'store'])->name('presensi.store');
Route::get('rekap', [PresensiController::class, 'rekap'])->name('rekap.index');
Route::get('rekap/export-queued', [PresensiController::class, 'exportQueued'])->name('rekap.export.queued');
Route::get('rekap/export', [PresensiController::class, 'export'])->name('rekap.export');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('api')->group(function () {
    Route::get('siswas', [ApiSiswaController::class, 'index']);
    Route::get('siswas/{siswa}', [ApiSiswaController::class, 'show']);
    Route::post('siswas', [ApiSiswaController::class, 'store']);
    Route::put('siswas/{siswa}', [ApiSiswaController::class, 'update']);
    Route::delete('siswas/{siswa}', [ApiSiswaController::class, 'destroy']);

    Route::get('presensis', [ApiPresensiController::class, 'index']);
    Route::get('presensis/{presensi}', [ApiPresensiController::class, 'show']);
    Route::post('presensis', [ApiPresensiController::class, 'store']);
    Route::put('presensis/{presensi}', [ApiPresensiController::class, 'update']);
    Route::delete('presensis/{presensi}', [ApiPresensiController::class, 'destroy']);
});
