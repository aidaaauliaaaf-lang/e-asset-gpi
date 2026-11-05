
<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetQrController;
use App\Http\Controllers\AssetMutationController;
use App\Http\Controllers\AssetScanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', function () {
    return redirect()->route('login');
});

// ==================================================
// LOGIN
// ==================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});

// ==================================================
// AREA PENGGUNA YANG SUDAH LOGIN
// ADMIN, PIMPINAN, KARYAWAN
// ==================================================

Route::middleware('role:admin,pimpinan,karyawan')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

});

// ==================================================
// DATA ASET
// ==================================================

// PENTING:
// Route assets/create harus berada sebelum assets/{asset}.

// TAMBAH ASET
// ADMIN DAN KARYAWAN

Route::middleware('role:admin,karyawan')->group(function () {

    Route::get('/assets/create', [AssetController::class, 'create'])
        ->name('assets.create');

    Route::post('/assets', [AssetController::class, 'store'])
        ->name('assets.store');

});

// MELIHAT DATA ASET
// ADMIN, PIMPINAN, KARYAWAN

Route::middleware('role:admin,pimpinan,karyawan')->group(function () {

    Route::get('/assets', [AssetController::class, 'index'])
        ->name('assets.index');

    Route::get('/assets/{asset}/qr', [AssetQrController::class, 'show'])
        ->name('assets.qr');

    Route::get('/assets/{asset}', [AssetController::class, 'show'])
        ->name('assets.show');

});

// EDIT DAN HAPUS ASET
// HANYA ADMIN

Route::middleware('role:admin')->group(function () {

    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])
        ->name('assets.edit');

    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update');

    Route::patch('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update.patch');

    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');

});

// ==================================================
// SCAN QR CODE
// ADMIN DAN KARYAWAN
// ==================================================

Route::middleware('role:admin,karyawan')->group(function () {

    Route::get('/asset-scans', [AssetScanController::class, 'index'])
        ->name('asset-scans.index');

    Route::post('/asset-scans', [AssetScanController::class, 'store'])
        ->name('asset-scans.store');

});

// ==================================================
// MUTASI ASET
// ADMIN DAN PIMPINAN: MELIHAT DATA
// ==================================================

Route::middleware('role:admin,pimpinan')->group(function () {

    Route::get('/mutations', [AssetMutationController::class, 'index'])
        ->name('mutations.index');

});

// HANYA ADMIN: MENAMBAH MUTASI

Route::middleware('role:admin')->group(function () {

    Route::get('/mutations/create', [AssetMutationController::class, 'create'])
        ->name('mutations.create');

    Route::post('/mutations', [AssetMutationController::class, 'store'])
        ->name('mutations.store');

});

// ==================================================
// MAINTENANCE ASET
// ADMIN DAN PIMPINAN: MELIHAT DATA
// ==================================================

Route::middleware('role:admin,pimpinan')->group(function () {

    Route::get('/maintenances', [MaintenanceController::class, 'index'])
        ->name('maintenances.index');

});

// HANYA ADMIN: MENAMBAH MAINTENANCE

Route::middleware('role:admin')->group(function () {

    Route::get('/maintenances/create', [MaintenanceController::class, 'create'])
        ->name('maintenances.create');

    Route::post('/maintenances', [MaintenanceController::class, 'store'])
        ->name('maintenances.store');

});

// ==================================================
// LAPORAN E-ASSET
// ADMIN DAN PIMPINAN
// ==================================================

Route::middleware('role:admin,pimpinan')->group(function () {

    Route::get('/laporan', [ReportController::class, 'index'])
        ->name('reports.index');

    // PDF ASET, MUTASI, DAN MAINTENANCE
    Route::get('/laporan/{jenis}/pdf', [ReportController::class, 'downloadPdf'])
        ->whereIn('jenis', ['aset', 'mutasi', 'pemeliharaan'])
        ->name('reports.pdf');

});

// ==================================================
// MANAJEMEN PENGGUNA
// HANYA ADMIN
// ==================================================

Route::middleware('role:admin')->group(function () {

    Route::get('/users', [UserManagementController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserManagementController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserManagementController::class, 'store'])
        ->name('users.store');

    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{user}', [UserManagementController::class, 'update'])
        ->name('users.update');

});
