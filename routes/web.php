<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TpsProduksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LokasiWwtpController;
use App\Http\Controllers\OperatorWwtpController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\SatuanSampahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\DaftarEkspedisiController;
use App\Http\Controllers\DaftarPenerimaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.action');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // DUMMY
    Route::get('/wwtp', function () {
        return view('pages.dummy', ['title' => 'WWTP']);
    })->name('wwtp.index');

    Route::get('/tps-domestik', function () {
        return view('pages.dummy', ['title' => 'TPS Domestik']);
    })->name('tps-domestik.index');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::resource('wwtp', LokasiWwtpController::class)->only(['store', 'update', 'destroy']);
        Route::resource('operator', OperatorWwtpController::class)->only(['store', 'update', 'destroy']);
        Route::resource('tps', TpsController::class)->only(['store', 'update', 'destroy']);
        Route::resource('lab', LabController::class)->only(['store', 'update', 'destroy']);
        Route::resource('jenis-sampah', JenisSampahController::class)->only(['store', 'update', 'destroy']);
        Route::resource('satuan-sampah', SatuanSampahController::class)->only(['store', 'update', 'destroy']);
        Route::resource('daftar-ekspedisi', DaftarEkspedisiController::class)->only(['store', 'update', 'destroy']);
        Route::resource('daftar-penerima', DaftarPenerimaController::class)->only(['store', 'update', 'destroy']);
    });
});

Route::middleware(['auth'])->prefix('tps-produksi')->name('tps-produksi.')->group(function () {
    // 1. Halaman Utama & Filter
    Route::get('/', [TpsProduksiController::class, 'index'])->name('index');

    // 2. CRUD Sampah Masuk
    Route::post('/masuk', [TpsProduksiController::class, 'storeMasuk'])->name('masuk.store');
    Route::put('/masuk/{id}', [TpsProduksiController::class, 'updateMasuk'])->name('masuk.update');
    Route::delete('/masuk/{id}', [TpsProduksiController::class, 'destroyMasuk'])->name('masuk.destroy');
    Route::get('/data/masuk/{id}', [TpsProduksiController::class, 'getMasuk']); // AJAX Edit

    // 3. CRUD Sampah Keluar
    Route::post('/keluar', [TpsProduksiController::class, 'storeKeluar'])->name('keluar.store');
    Route::put('/keluar/{id}', [TpsProduksiController::class, 'updateKeluar'])->name('keluar.update');
    Route::delete('/keluar/{id}', [TpsProduksiController::class, 'destroyKeluar'])->name('keluar.destroy');
    Route::get('/data/keluar/{id}', [TpsProduksiController::class, 'getKeluar']); // AJAX Edit

    // 4. Export Excel & PDF
    Route::get('/export/masuk', [TpsProduksiController::class, 'exportMasukExcel'])->name('export.masuk.excel');
    Route::get('/export/keluar', [TpsProduksiController::class, 'exportKeluarExcel'])->name('export.keluar.excel');
    Route::get('/export/pdf/{id}', [TpsProduksiController::class, 'exportSinglePdf'])->name('export.single.pdf');
});