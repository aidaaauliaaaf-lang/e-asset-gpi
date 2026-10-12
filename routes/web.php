
<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetMutationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

// Logout semua role
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('role:admin,pimpinan,karyawan')
    ->name('logout');

// Dashboard bersama untuk semua role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('role:admin,pimpinan,karyawan')
    ->name('dashboard');

// Aset: Admin dan Karyawan boleh melihat
Route::get('/assets', [AssetController::class, 'index'])
    ->middleware('role:admin,karyawan')
    ->name('assets.index');

Route::get('/assets/create', [AssetController::class, 'create'])
    ->middleware('role:admin,karyawan')
    ->name('assets.create');

Route::post('/assets', [AssetController::class, 'store'])
    ->middleware('role:admin,karyawan')
    ->name('assets.store');

Route::get('/assets/{asset}', [AssetController::class, 'show'])
    ->middleware('role:admin,karyawan')
    ->name('assets.show');

// Hanya Admin boleh mengedit dan menghapus aset
Route::middleware('role:admin')->group(function () {
    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])
        ->name('assets.edit');

    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update');

    Route::patch('/assets/{asset}', [AssetController::class, 'update.patch']);

    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');
});

// Mutasi aset
// Admin dan Pimpinan boleh melihat daftar mutasi
Route::get('/mutations', [AssetMutationController::class, 'index'])
    ->middleware('role:admin,pimpinan')
    ->name('mutations.index');

// Hanya Admin boleh menambah mutasi
Route::middleware('role:admin')->group(function () {
    Route::get('/mutations/create', [AssetMutationController::class, 'create'])
        ->name('mutations.create');

    Route::post('/mutations', [AssetMutationController::class, 'store'])
        ->name('mutations.store');
});

// Maintenance aset
// Admin dan Pimpinan boleh melihat daftar maintenance
Route::get('/maintenances', [MaintenanceController::class, 'index'])
    ->middleware('role:admin,pimpinan')
    ->name('maintenances.index');

// Hanya Admin boleh menambah maintenance
Route::middleware('role:admin')->group(function () {
    Route::get('/maintenances/create', [MaintenanceController::class, 'create'])
        ->name('maintenances.create');

    Route::post('/maintenances', [MaintenanceController::class, 'store'])
        ->name('maintenances.store');
});

// Manajemen pengguna: hanya Admin
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
