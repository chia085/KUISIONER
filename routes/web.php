<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManajemenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AkunController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/landing', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
// Tampilkan halaman login
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Proses login
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Manajemen Kuesioner
|--------------------------------------------------------------------------
*/
Route::prefix('manajemen')->name('manajemen.')->controller(ManajemenController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/mahasiswa', 'mahasiswa')->name('mahasiswa');
    Route::get('/polibatam', 'polibatam')->name('polibatam');
    Route::get('/alumni', 'alumni')->name('alumni');
    Route::get('/masyarakat', 'masyarakat')->name('masyarakat');

    Route::post('/mahasiswa/tambah', 'tambahLayanan')->name('layanan.tambah');
    Route::delete('/mahasiswa/hapus/{id}', 'hapusLayanan')->name('layanan.hapus');
});

/*
|--------------------------------------------------------------------------
| Analisis & Akun
|--------------------------------------------------------------------------
*/

// ✅ Hapus view statis agar tidak bentrok dan biar lewat controller
// Route::get('/analisis', fn() => view('analisis'))->name('analisis');

// ✅ Ganti dengan redirect ke analisis.index (biar ada $data dari controller)
Route::get('/analisis', function () {
    return redirect()->route('analisis.index');
})->name('analisis');

// ✅ Analisis Data via Controller
Route::prefix('analisis')->name('analisis.')->controller(AnalisisController::class)->group(function () {
    Route::get('/', 'polibatam')->name('index'); // Default: tampilkan Polibatam
    Route::get('/polibatam', 'polibatam')->name('polibatam');
    Route::get('/mahasiswa', 'mahasiswa')->name('mahasiswa');
    Route::get('/alumni', 'alumni')->name('alumni');
    Route::get('/masyarakat', 'masyarakat')->name('masyarakat');
});

// ✅ Halaman Akun
Route::get('/akun', [AkunController::class, 'index'])->name('akun');

