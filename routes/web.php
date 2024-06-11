<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
//Cart
Route::resource('cart', CartsController::class);
// Route::get('cart', [CartsController::class, 'index'])->name('cart.index');
Route::get('checkout', [CartsController::class, 'checkout'])->name('cart.checkout');
Route::post('Storecheckout', [CartsController::class, 'Storecheckout'])->name('cart.Storecheckout');

Route::post('/vnpay-payment', [CartsController::class, 'vnpay_payment']);

// Route::post('cart', [CartsController::class, 'store'])->name('cart.store');


Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/in-login', [HomeController::class, 'InLogin'])->name('InLogin');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::post('/add-register', [HomeController::class, 'StoreRegister'])->name('StoreRegister');
Route::get('/search-cate{id}', [HomeController::class, 'searchCategory'])->name('search.category');




Route::get('logon', [AdminController::class, 'logon'])->name('logon');
Route::post('logon', [AdminController::class, 'InLogon'])->name('admin.InLogon');
Route::get('/sig-out', [AdminController::class, 'SigOut'])->name('admin.SigOut');

Route::prefix("admin")->middleware(['admin', AdminAuthenticate::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::resource('category', CategoryController::class);
    Route::get('category-trash', [CategoryController::class, 'trash'])->name('category.trash');
    Route::get('category-restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::get('category-permanently-delete/{id}', [CategoryController::class, 'permanentlyDelete'])->name('category.permanentlyDelete');

    Route::resource('product', ProductController::class);
    Route::get('product-trash', [ProductController::class, 'trash'])->name('product.trash');
    Route::get('product-restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
    Route::get('product-permanently-delete/{id}', [ProductController::class, 'permanentlyDelete'])->name('product.permanentlyDelete');
});
