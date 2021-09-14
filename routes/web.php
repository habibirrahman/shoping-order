<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
// fitur tanpa auth
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/carts/{slug}/add', [CartController::class, 'add'])->name('carts.add');
// fitur auth
Route::get('/auth/login', [AuthController::class, 'showFormLogin']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/register', [AuthController::class, 'showFormRegister']);
Route::post('/auth/register', [AuthController::class, 'register']);
// midtrans response
Route::post('/payments/notification', [PaymentController::class, 'notification']);
Route::get('/payments/completed', [PaymentController::class, 'completed']);
Route::get('/payments/failed', [PaymentController::class, 'failed']);
Route::get('/payments/unfinish', [PaymentController::class, 'unfinish']);
// fitur unguest
Route::group(['middleware' => 'auth:sanctum', 'verified'], function () {
    // fitur admin
    Route::get('/orders/admin', [AdminController::class, 'getOrders'])->name('orders.admin');
    Route::post('/orders/{id}/status/{status}/admin', [AdminController::class, 'setStatus'])->name('status.admin');
    Route::get('/orders/completed/admin', [AdminController::class, 'getCompleted'])->name('completed.admin');
    Route::get('/payments/admin', [AdminController::class, 'getPayments'])->name('payments.admin');
    // crud produk dan kategori, serta getUsers
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/users/admin', [AdminController::class, 'getUsers'])->name('users.admin');
    // fitur keranjang
    Route::post('/carts/{slug}/store', [CartController::class, 'store'])->name('carts.store');
    Route::resource('carts', CartController::class);
    // fitur pesanan
    Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders/{all_cart}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/orders/{id}/add', [OrderController::class, 'add'])->name('orders.add');
    Route::resource('orders', OrderController::class);
});
