<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuratAdminController;
use App\Http\Controllers\SuratDesaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Admin
Route::get('/beranda-admin', [SuratAdminController::class, 'totalSuratMasukDanKeluarAdmin']);

// Surat Masuk Admin
Route::get('/surat-masuk-admin', [SuratAdminController::class, 'indexMasuk'])->name('surat-admin.indexMasuk');
Route::get('/surat-masuk-admin/create', [SuratAdminController::class, 'createMasuk'])->name('surat-admin.createMasuk');
Route::post('/surat-masuk-admin/store', [SuratAdminController::class, 'storeMasuk'])->name('surat-admin.storeMasuk');
Route::get('/surat-masuk-admin/edit/{id}', [SuratAdminController::class, 'editMasuk'])->name('surat-admin.editMasuk');
Route::put('/surat-masuk-admin/update/{id}', [SuratAdminController::class, 'updateMasuk'])->name('surat-admin.updateMasuk');
Route::delete('/surat-masuk-admin/destroy/{id}', [SuratAdminController::class, 'destroyMasuk'])->name('surat-admin.destroyMasuk');
Route::get('/surat-masuk-admin/{id}', [SuratAdminController::class, 'detailMasukAdmin'])->name('surat-admin.detailMasuk');

// Surat Keluar Admin
Route::get('/surat-keluar-admin', [SuratAdminController::class, 'indexKeluar'])->name('surat-admin.indexKeluar');
Route::get('/surat-keluar-admin/create', [SuratAdminController::class, 'createKeluar'])->name('surat-admin.createKeluar');
Route::post('/surat-keluar-admin/store', [SuratAdminController::class, 'storeKeluar'])->name('surat-admin.storeKeluar');
Route::get('/surat-keluar-admin/edit/{id}', [SuratAdminController::class, 'editKeluar'])->name('surat-admin.editKeluar');
Route::put('/surat-keluar-admin/update/{id}', [SuratAdminController::class, 'updateKeluar'])->name('surat-admin.updateKeluar');
Route::delete('/surat-keluar-admin/destroy/{id}', [SuratAdminController::class, 'destroyKeluar'])->name('surat-admin.destroyKeluar');
Route::get('/surat-keluar-admin/{id}', [SuratAdminController::class, 'detailKeluarAdmin'])->name('surat-admin.detailKeluar');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/laporan-user', [UserController::class, 'laporan'])->name('laporan.user');
});

// Laporan Surat Masuk dan Surat Keluar untuk Admin
Route::get('/laporan-surat-masuk', [SuratAdminController::class, 'laporanSuratMasuk'])->name('admin.laporanSuratMasuk');
Route::get('/laporan-surat-keluar', [SuratAdminController::class, 'laporanSuratKeluar'])->name('admin.laporanSuratKeluar');
Route::get('/laporan-surat-keluar/cetak', [SuratAdminController::class, 'cetakSuratKeluar'])->name('admin.suratKeluar.cetak');
Route::get('/laporan-surat-masuk/cetak', [SuratAdminController::class, 'cetakSuratMasuk'])->name('admin.suratMasuk.cetak');
Route::get('/laporan-user/cetak', [UserController::class, 'cetakUser'])->name('laporan.user.cetak');


// Camat
Route::get('/beranda-camat', [SuratAdminController::class, 'totalSuratMasukDanKeluarCamat']);

// Camat: Surat Masuk
Route::get('/surat-masuk-camat', [SuratAdminController::class, 'indexMasukCamat'])->name('surat-camat.indexMasukCamat');
Route::get('/surat-masuk-camat/{id}', [SuratAdminController::class, 'detailMasukCamat'])->name('surat-camat.detailMasuk');

// Camat: Surat Keluar
Route::get('/surat-keluar-camat', [SuratAdminController::class, 'indexKeluarCamat'])->name('surat-camat.indexKeluarCamat');
Route::get('/surat-keluar-camat/{id}', [SuratAdminController::class, 'detailKeluarCamat'])->name('surat-camat.detailKeluar');
Route::get('/surat-keluar-camat/edit/{id}', [SuratAdminController::class, 'editKeluarCamat'])->name('surat-camat.editKeluar');
Route::put('/surat-keluar-camat/update/{id}', [SuratAdminController::class, 'updateKeluarCamat'])->name('surat-camat.updateKeluarCamat');
Route::get('/surat-keluar-camat/create', [SuratAdminController::class, 'createKeluarCamat'])->name('surat-camat.createKeluarCamat');
Route::post('/surat-keluar-camat/store', [SuratAdminController::class, 'storeKeluarCamat'])->name('surat-camat.storeKeluarCamat');

Route::get('/laporan-surat-masuk-camat', [SuratAdminController::class, 'laporanSuratMasukCamat'])->name('camat.laporanSuratMasuk');
Route::get('/laporan-surat-keluar-camat', [SuratAdminController::class, 'laporanSuratKeluarCamat'])->name('camat.laporanSuratKeluar');
// Desa

Route::get('/beranda-desa', [SuratDesaController::class, 'totalSuratMasukDanKeluar']);

// Surat Masuk Desa
Route::get('/desa/surat-masuk', [SuratDesaController::class, 'indexMasuk'])->name('desa.surat-masuk.index');
Route::get('/desa/surat-masuk/{id}', [SuratDesaController::class, 'detailMasuk'])->name('desa.surat-masuk.detail');


// Surat Keluar Desa
Route::get('/desa/surat-keluar', [SuratDesaController::class, 'indexKeluar'])->name('desa.surat-keluar.index');
Route::get('/desa/surat-keluar/create', [SuratDesaController::class, 'createKeluar'])->name('desa.surat-keluar.create');
Route::post('/desa/surat-keluar/store', [SuratDesaController::class, 'storeKeluar'])->name('desa.surat-keluar.store');
Route::get('/desa/surat-keluar/edit/{id}', [SuratDesaController::class, 'editKeluar'])->name('desa.surat-keluar.edit');
Route::put('/desa/surat-keluar/update/{id}', [SuratDesaController::class, 'updateKeluar'])->name('desa.surat-keluar.update');
Route::delete('/desa/surat-keluar/{id}', [SuratDesaController::class, 'destroyKeluar'])->name('desa.surat-keluar.destroy');
Route::get('/desa/surat-keluar/{id}', [SuratDesaController::class, 'detailKeluar'])->name('desa.surat-keluar.detail');


Route::get('/desa/laporan-surat-masuk', [SuratDesaController::class, 'laporanSuratMasuk'])->name('desa.laporanSuratMasuk');
Route::get('/desa/laporan-surat-keluar', [SuratDesaController::class, 'laporanSuratKeluar'])->name('desa.laporanSuratKeluar');
Route::get('/desa/laporan-surat-keluar/cetak', [SuratDesaController::class, 'cetakSuratKeluar'])->name('laporan.suratKeluar.cetak');
Route::get('/desa/laporan-surat-masuk/cetak', [SuratDesaController::class, 'cetakSuratMasuk'])->name('laporan.suratMasuk.cetak');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
