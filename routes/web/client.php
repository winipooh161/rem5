<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProjectController;
use App\Http\Controllers\Client\ProjectFileController;
use Illuminate\Support\Facades\Route;

// Клиентские маршруты - с middleware для доступа администраторов
Route::prefix('client')->name('client.')->middleware(['auth', 'admin.or.client'])->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('dashboard');
    
    // Маршруты для проектов клиента
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    
    // Маршрут для скачивания файлов
    Route::get('/project-files/{file}/download', [ProjectFileController::class, 'download'])->name('project-files.download');
});
