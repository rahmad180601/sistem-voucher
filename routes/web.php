<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\DashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/shop/detail/{id}', [HomeController::class, 'show'])->name('shop.show');

    Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
    Route::post('/cart/store', [HomeController::class, 'cartstore'])->name('cart.store');
    Route::patch('/cart/{id}', [HomeController::class, 'cartupdate'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [HomeController::class, 'cartdelete'])->name('cart.delete');
    Route::post('/checkout', [HomeController::class, 'checkout'])->name('checkout.store');

    Route::post('/apply-voucher', [HomeController::class, 'applyVoucher'])->name('apply.voucher');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/post', [LoginController::class, 'loginpost'])->name('loginpost');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/cart', 'CartController@index')->name('cart');
// Route::post('/cart/store', 'CartController@store')->name('cart.store');
// Route::patch('/cart/{id}', 'CartController@update')->name('cart.update');
// Route::delete('/cart/delete/{id}', 'CartController@delete')->name('cart.delete');
// Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');

Route::prefix('admin')->namespace('Admin')->group(function () { 
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.admin');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::post('/produk/update', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/delete', [ProdukController::class, 'delete'])->name('produk.delete');

    Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher.admin');
    Route::post('/voucher/store', [VoucherController::class, 'store'])->name('voucher.store');
    Route::post('/voucher/update', [VoucherController::class, 'update'])->name('voucher.update');
    Route::delete('/voucher/delete', [VoucherController::class, 'delete'])->name('voucher.delete');
});
