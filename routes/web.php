<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes([
    'login' => false, // Отключаем стандартный маршрут входа
]);

// Маршруты для SMS авторизации
Route::get('/login', [\App\Http\Controllers\Auth\SmsAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\SmsAuthController::class, 'login']);
Route::post('/login/send-code', [\App\Http\Controllers\Auth\SmsAuthController::class, 'sendCode'])->name('login.send-code');
Route::post('/login/verify-code', [\App\Http\Controllers\Auth\SmsAuthController::class, 'verifyCode'])->name('login.verify-code');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Подключение разделенных маршрутов
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/partner.php';
require __DIR__ . '/web/partner_extensions.php';
require __DIR__ . '/web/partner_project_features.php';
require __DIR__ . '/web/partner_tools.php';
require __DIR__ . '/web/partner_finance.php';
require __DIR__ . '/web/client.php';
require __DIR__ . '/web/estimator.php';
require __DIR__ . '/web/profile.php';