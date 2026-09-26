<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetMutationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('assets', AssetController::class);

Route::get('/mutations', [AssetMutationController::class, 'index'])
    ->name('mutations.index');

Route::get('/mutations/create', [AssetMutationController::class, 'create'])
    ->name('mutations.create');

Route::post('/mutations', [AssetMutationController::class, 'store'])
    ->name('mutations.store');

Route::get('/maintenances', [MaintenanceController::class, 'index'])
    ->name('maintenances.index');

Route::get('/maintenances/create', [MaintenanceController::class, 'create'])
    ->name('maintenances.create');

Route::post('/maintenances', [MaintenanceController::class, 'store'])
    ->name('maintenances.store');