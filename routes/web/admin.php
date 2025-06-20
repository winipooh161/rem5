<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Маршруты для администраторов
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Маршруты управления пользователями
    Route::resource('users', UserController::class)->except(['create', 'store'])->names([
        'index' => 'admin.users.index',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    // Маршрут для обновления шаблонов смет (доступен только админам)
    Route::get('/refresh-estimate-templates', function() {
        if (!auth()->user() || !auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой функции');
        }
        
        Artisan::call('estimates:generate-templates');
        return redirect()->back()->with('success', 'Шаблоны смет успешно обновлены!');
    })->name('admin.refresh-estimate-templates');
});
