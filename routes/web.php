<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Session;

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

Route::get('/', [Controller::class, 'index']); // Загрузка основной страницы
Route::post('/products', [Controller::class, 'loadProducts']); // Подгрузка продуктов для основной страницы
Route::post('/cart/add', [CartController::class, 'addToCart']); // Добавление продукта в корзину
Route::post('/cart', [CartController::class, 'loadCart']); // Загрузка корзины
Route::patch('/cart', [CartController::class, 'updateCart']); // Обновление кол-ва товара в корзине
Route::delete('/cart', [CartController::class, 'deleteCartItem']); // Удаление товара

Route::get('/orders', [Controller::class, 'ordering']); // Загрузка панели истории заказов

// Регистрация

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [UserController::class, 'register']);

// Логин

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [UserController::class, 'login']);

// Верификация

Route::get('/verify', function () {
    return view('auth.verify');
});

Route::post('/verify', [UserController::class, 'verifyMail']);

Route::get('/logout', function (){
    Session::flush();
    return redirect('/');
});

// админка

Route::get('/manager', [Controller::class, 'manager']);

Route::post('/manager/table', [PanelController::class, 'loadManagerTable']);

Route::get('/admin', [Controller::class, 'admin']);
Route::post('/admin', [PanelController::class, 'createProduct']);
Route::post('/admin/update', [PanelController::class, 'updateProduct']);
Route::delete('/admin', [PanelController::class, 'deleteProduct']);

Route::post('/admin/table', [PanelController::class, 'loadAdminTable']);

Route::get('/global', [Controller::class, 'global']);
Route::patch('/global', [PanelController::class, 'updateUser']);
Route::delete('/global', [PanelController::class, 'deleteUser']);

Route::post('/global/table', [PanelController::class, 'loadGlobalTable']);

// Получить данные о продукте

Route::get('/product/{id}', [Controller::class, 'loadProductPage'])->whereNumber('id');
Route::post('/product/{id}', [Controller::class, 'getProductById'])->whereNumber('id');

Route::get('/user/{id}', [Controller::class, 'loadUserPage'])->whereNumber('id');
Route::post('/user/{id}', [Controller::class, 'getUserById'])->whereNumber('id');
