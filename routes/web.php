<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WwtpController;
use App\Http\Controllers\TpsProduksiController;
use App\Http\Controllers\TpsDomestikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LokasiWwtpController;
use App\Http\Controllers\OperatorWwtpController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\SatuanSampahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\DaftarEkspedisiController;
use App\Http\Controllers\DaftarPenerimaController;
use App\Http\Controllers\StatusSampahController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.action');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

    // WWTP Routes
    Route::prefix('wwtp')->group(function () {
        Route::get('/', [WwtpController::class, 'index'])->name('wwtp.index');
        Route::get('/export/harian/excel', [WwtpController::class, 'exportHarianExcel'])->name('wwtp.export.harian.excel');
        Route::get('/export/bulanan/excel', [WwtpController::class, 'exportBulananExcel'])->name('wwtp.export.bulanan.excel');
        Route::post('/harian', [WwtpController::class, 'storeHarian'])->name('wwtp.harian.store');
        Route::put('/harian/{id}', [WwtpController::class, 'updateHarian'])->name('wwtp.harian.update');
        Route::delete('/harian/{id}', [WwtpController::class, 'destroyHarian'])->name('wwtp.harian.destroy');
        Route::post('/bulanan', [WwtpController::class, 'storeBulanan'])->name('wwtp.bulanan.store');
        Route::put('/bulanan/{id}', [WwtpController::class, 'updateBulanan'])->name('wwtp.bulanan.update');
        Route::delete('/bulanan/{id}', [WwtpController::class, 'destroyBulanan'])->name('wwtp.bulanan.destroy');
        Route::get('/data/harian/{id}', [WwtpController::class, 'getDataHarian'])->name('wwtp.data.harian');
        Route::get('/data/bulanan/{id}', [WwtpController::class, 'getDataBulanan'])->name('wwtp.data.bulanan');
    });

    // TPS Produksi Routes
    Route::prefix('tps-produksi')->name('tps-produksi.')->group(function () {
        Route::get('/', [TpsProduksiController::class, 'index'])->name('index');
        Route::post('/masuk', [TpsProduksiController::class, 'storeMasuk'])->name('masuk.store');
        Route::put('/masuk/{id}', [TpsProduksiController::class, 'updateMasuk'])->name('masuk.update');
        Route::delete('/masuk/{id}', [TpsProduksiController::class, 'destroyMasuk'])->name('masuk.destroy');
        Route::get('/data/masuk/{id}', [TpsProduksiController::class, 'getMasuk']);
        Route::post('/keluar', [TpsProduksiController::class, 'storeKeluar'])->name('keluar.store');
        Route::put('/keluar/{id}', [TpsProduksiController::class, 'updateKeluar'])->name('keluar.update');
        Route::delete('/keluar/{id}', [TpsProduksiController::class, 'destroyKeluar'])->name('keluar.destroy');
        Route::get('/data/keluar/{id}', [TpsProduksiController::class, 'getKeluar']);
        Route::get('/export/masuk', [TpsProduksiController::class, 'exportMasukExcel'])->name('export.masuk.excel');
        Route::get('/export/keluar', [TpsProduksiController::class, 'exportKeluarExcel'])->name('export.keluar.excel');
        Route::get('/export/pdf/{id}', [TpsProduksiController::class, 'exportSinglePdf'])->name('export.single.pdf');
    });

    // TPS Domestik Routes
    Route::prefix('tps-domestik')->group(function () {
        Route::get('/', [TpsDomestikController::class, 'index'])->name('tps-domestik.index');
        Route::get('/export/excel', [TpsDomestikController::class, 'exportExcel'])->name('tps-domestik.export.excel');
        Route::post('/', [TpsDomestikController::class, 'store'])->name('tps-domestik.store');
        Route::get('/{id}', [TpsDomestikController::class, 'show'])->name('tps-domestik.show');
        Route::put('/{id}', [TpsDomestikController::class, 'update'])->name('tps-domestik.update');
        Route::delete('/{id}', [TpsDomestikController::class, 'destroy'])->name('tps-domestik.destroy');
    });

    // Profile & Related Resources Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::resource('wwtp', LokasiWwtpController::class)->only(['store', 'update', 'destroy']);
        Route::resource('operator', OperatorWwtpController::class)->only(['store', 'update', 'destroy']);
        Route::resource('tps', TpsController::class)->only(['store', 'update', 'destroy']);
        Route::resource('lab', LabController::class)->only(['store', 'update', 'destroy']);
        Route::resource('jenis-sampah', JenisSampahController::class)->only(['store', 'update', 'destroy']);
        Route::resource('satuan-sampah', SatuanSampahController::class)->only(['store', 'update', 'destroy']);
        Route::resource('status-sampah', StatusSampahController::class)->only(['store', 'update', 'destroy']);
        Route::resource('daftar-ekspedisi', DaftarEkspedisiController::class)->only(['store', 'update', 'destroy']);
        Route::resource('daftar-penerima', DaftarPenerimaController::class)->only(['store', 'update', 'destroy']);

        Route::middleware(['is_admin'])->group(function () {
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});

