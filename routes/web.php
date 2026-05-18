<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VisitorController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [VisitorController::class, 'index'])->name('dashboard');
    
    Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    Route::put('/visitors/{visitor}', [VisitorController::class, 'update'])->name('visitors.update');
    Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');
    Route::patch('/visitors/{visitor}/checkout', [VisitorController::class, 'checkout'])->name('visitors.checkout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
