<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::namespace('Portal')->middleware('guest')->group(function () {
    Route::get('/', [PortalController::class, 'index'])->name('portal');
    Route::post('/auth', [PortalController::class, 'auth']);
});

Route::namespace('Dashboard')->prefix('dashboard')->middleware('auth:web')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/administrator', [DashboardController::class, 'administrator']);
    Route::get('/general', [DashboardController::class, 'general']);
    // ========================== //
    Route::get('/switch-role', [DashboardController::class, 'switch_role']);
    Route::get('/reset-role', [DashboardController::class, 'reset_role']);
    Route::get('/logout', [PortalController::class, 'logout']);
});
