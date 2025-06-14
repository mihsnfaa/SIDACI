<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Satu route dinamis dashboard berdasarkan level/bidang
Route::get('/dashboard', function () {
    $user = Auth::user(); // ambil user yang sedang login

    return view('dashboard', [
        'user' => $user,
        'level' => $user->level,
        'bidang' => $user->bidang,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
