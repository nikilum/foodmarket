<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NSettingsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Публичные функции

Route::get('/', [PageController::class, 'index']); // Загрузка основной страницы
Route::get('/products', [PageController::class, 'loadProducts']); // Подгрузка продуктов для основной страницы
Route::get('/products/{id}', [PageController::class, 'productPage'])->whereNumber('id');

Route::middleware('authorized')->group(function () {

    Route::middleware('verified')->group(function () {

        // Основная страница +
        Route::resource('cart_products', CartController::class)->except(['create', 'edit', 'show']);

        Route::get('/orders', [PageController::class, 'order']); // Загрузка панели истории заказов
        Route::resource('uorders', OrderController::class)->except(['create']);
        Route::middleware('manager')->group(function () { // менеджер
            Route::get('/manager', [PageController::class, 'manager']);
            Route::resource('morders', ManagerController::class)->only(['index', 'show', 'update']);
        });
        Route::middleware('admin')->group(function () { // админ
            Route::get('/admin', [PageController::class, 'admin']);
            Route::resource('aproducts', AdminController::class)->except(['create', 'show', 'update']);
        });
        Route::middleware('global')->group(function () { // глобальный админ
            Route::get('/global', [PageController::class, 'global']);
            Route::resource('gusers', GlobalController::class)->except(['create', 'store', 'show']);
        });
        // Баланс
        Route::resource('balances', BalanceController::class)->only(['index', 'update', 'show']);
    });
    // Панель настроек
    Route::get('/settings', [PageController::class, 'settings']); // Загрузка панели настроек
    Route::resource('usettings', NSettingsController::class)->only(['index', 'update']);

    // Верификация
    Route::middleware('notVerified')->group(function () {
        Route::get('/verify', [PageController::class, 'verify'])->name('verify');
        Route::post('/verify', [UserController::class, 'verifyMail']);
        Route::patch('/verify', [UserController::class, 'repeatVerifyCode'])->middleware('throttle:5,60');
    });

});

Route::middleware('notLoggedIn')->group(function () {

    // Регистрация
    Route::get('/register', [PageController::class, 'register']);
    Route::post('/register', [UserController::class, 'register']);

    // Логин
    Route::get('/login', [PageController::class, 'login']);
    Route::post('/login', [UserController::class, 'login']);
});
Route::get('/logout', [PageController::class, 'logout']);
