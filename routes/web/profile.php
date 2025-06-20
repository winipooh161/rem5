<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Маршруты для профиля пользователя
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('profile.update-password');
});
