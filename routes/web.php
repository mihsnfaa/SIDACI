<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware(['web'])->group(function () {

    // Redirect root ke halaman login
    Route::get('/', fn () => redirect()->route('login'));

    // Auth: Login dan Logout
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard setelah login
    Route::middleware('auth')->group(function () {

        // Dashboard umum
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Dashboard per bidang
        Route::get('/dashboard/{bidang}', [DashboardController::class, 'showByBidang'])->name('dashboard.bidang');

        // Route admin
        Route::middleware('admin')->group(function () {
            Route::get('/admin/dashboard', [DocumentsController::class, 'adminDashboard'])->name('admin.dashboard');
        });

        // Dokumen per bidang
        Route::prefix('bidang')->group(function () {
            Route::get('/kesmas', [DocumentsController::class, 'kesmas'])->name('kesmas');
            Route::get('/progsi', [DocumentsController::class, 'progsi'])->name('progsi');
            Route::get('/sekretariat', [DocumentsController::class, 'sekretariat'])->name('sekretariat');
            Route::get('/yansdk', [DocumentsController::class, 'yansdk'])->name('yansdk');
            Route::get('/p2p', [DocumentsController::class, 'p2p'])->name('p2p');
        });

        // CRUD dokumen
        Route::post('/dokumen/upload', [DocumentsController::class, 'upload'])->name('dokumen.upload');
        Route::get('/dokumen/download/{id}', [DocumentsController::class, 'download'])->name('dokumen.download');
        Route::get('/dokumen/detail/{id}', [DocumentsController::class, 'detail'])->name('dokumen.detail');
        Route::delete('/dokumen/{id}', [DocumentsController::class, 'destroy'])->name('dokumen.destroy');
        Route::put('/dokumen/update/{id}', [DocumentsController::class, 'update'])->name('documents.update');
    });
});
