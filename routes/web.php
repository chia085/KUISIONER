<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD

use App\Http\Controllers\PolibatamController;
use App\Http\Controllers\KuisionerController;

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminKuisionerController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\AdminGrafikController;
use App\Http\Controllers\AdminJawabanController;

/*
|--------------------------------------------------------------------------
| USER PUBLIC
|--------------------------------------------------------------------------
*/

// Landing publik
Route::get('/polibatam', [PolibatamController::class, 'index'])->name('polibatam');

// (opsional) endpoint ajax kamu
Route::get('/get-kuisioner/{role}', [PolibatamController::class, 'getKuisioner'])->name('get.kuisioner');

// Fix: jangan boleh akses submit via GET
Route::get('/kuisioner/{id}/submit', fn () => abort(404));

// Show kuisioner (form)
Route::get('/kuisioner/{id}', [KuisionerController::class, 'show'])->name('kuisioner.show');

// Submit jawaban (POST)
Route::post('/kuisioner/{id}/submit', [KuisionerController::class, 'submit'])->name('kuisioner.submit');

// Grafik responden (publik)
Route::get(
    '/kuisioner/{id}/grafik-responden/{role}',
    [KuisionerController::class, 'grafikResponden']
)->name('kuisioner.grafik.responden');

// Grafik layanan (publik)
Route::get(
    '/kuisioner/grafik/{id}',
    [KuisionerController::class, 'grafikLayanan']
)->name('kuisioner.grafik');

// (opsional) halaman grafik publik terpisah
Route::get('/grafik', [PolibatamController::class, 'grafikPublik'])->name('grafik.publik');
=======
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManajemenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TentangController;

>>>>>>> 6e8e8076380d5f87fa31643c2b4e242f7753aa94


/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN AREA (SATU GROUP SAJA - JANGAN DI-NESTING LAGI)
|--------------------------------------------------------------------------
| Kalau kamu belum pakai middleware auth, boleh hapus ->middleware('auth')
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminLoginController::class, 'dashboard'])->name('dashboard');

    // grafik
    Route::get('/grafik', [AdminGrafikController::class, 'index'])->name('grafik');
    Route::get('/grafik/export/excel', [AdminGrafikController::class, 'exportExcel'])->name('grafik.export.excel');
    Route::get('/grafik/export/pdf', [AdminGrafikController::class, 'exportPdf'])->name('grafik.export.pdf');
    Route::get('/grafik/pilih', [AdminGrafikController::class, 'pilihLayanan'])->name('grafik.pilih');
    Route::get('/grafik/layanan/{id}', [AdminGrafikController::class, 'layanan'])->name('grafik.layanan');

    // kuisioner & pertanyaan
    Route::resource('kuisioner', AdminKuisionerController::class);

    Route::post('/kuisioner/{id}/toggle',
        [AdminKuisionerController::class, 'toggle']
    )->name('kuisioner.toggle');

    Route::resource('pertanyaan', PertanyaanController::class);

    // QR
    Route::get('/kuisioner/{id}/qr', [AdminKuisionerController::class, 'qr'])->name('kuisioner.qr');
    Route::get('/kuisioner/{id}/qr/download', [AdminKuisionerController::class, 'qrDownload'])->name('kuisioner.qr.download');

    // jawaban
    Route::get('/jawaban', [AdminJawabanController::class, 'index'])->name('jawaban.index');
    Route::get('/jawaban/export/pdf', [AdminJawabanController::class, 'exportPdf'])->name('jawaban.export.pdf');
});


    // ===================== KUISIONER =====================
    Route::resource('kuisioner', AdminKuisionerController::class);

    Route::post('/kuisioner/{id}/toggle', [AdminKuisionerController::class, 'toggle'])
        ->name('kuisioner.toggle');

    // QR Kuisioner
    Route::get('/kuisioner/{id}/qr', [AdminKuisionerController::class, 'qr'])
        ->name('kuisioner.qr');

    Route::get('/kuisioner/{id}/qr/download', [AdminKuisionerController::class, 'qrDownload'])
        ->name('kuisioner.qr.download');


    // ===================== PERTANYAAN =====================
    Route::resource('pertanyaan', PertanyaanController::class);


    // ===================== JAWABAN RESPONDEN (ADMIN) =====================
    // index + filter kuisioner + filter tanggal + filter tipe (saran/pilihan)
    Route::get('/jawaban', [AdminJawabanController::class, 'index'])
        ->name('jawaban.index');

    // export pdf dari hasil filter yang sama
    Route::get('/jawaban/export/pdf', [AdminJawabanController::class, 'exportPdf'])
        ->name('jawaban.export.pdf');

=======
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
Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan');

// Route ke halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');


>>>>>>> 6e8e8076380d5f87fa31643c2b4e242f7753aa94
