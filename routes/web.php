<?php

use Illuminate\Support\Facades\Route;

//halaman home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/catalog', [App\Http\Controllers\HomeController::class, 'catalog'])->name('catalog');


//login

Route::get('/login', [
    App\Http\Controllers\AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    App\Http\Controllers\AuthController::class,
    'login'
])->name('login.process');

Route::get('/register', [
    App\Http\Controllers\AuthController::class,
    'register'
])->name('register');

Route::post('/register', [
    App\Http\Controllers\AuthController::class,
    'storeRegister'
])->name('register.store');

Route::post('/logout', [
    App\Http\Controllers\AuthController::class,
    'logout'
])->name('logout');

//category

Route::resource(
    'categories',
    App\Http\Controllers\CategoryController::class
);

//product

Route::resource(
    'products',
    App\Http\Controllers\ProductController::class
);

//cart

Route::get('/cart', [
    App\Http\Controllers\CartController::class,
    'index'
])->name('cart.index');

Route::post('/cart', [
    App\Http\Controllers\CartController::class,
    'store'
])->name('cart.store');

Route::put('/cart/{id}', [
    App\Http\Controllers\CartController::class,
    'update'
])->name('cart.update');

Route::delete('/cart/{id}', [
    App\Http\Controllers\CartController::class,
    'destroy'
])->name('cart.destroy');

//order
Route::get('/orders', [
    App\Http\Controllers\OrderController::class,
    'index'
])->name('orders.index');

Route::get('/orders/{id}', [
    App\Http\Controllers\OrderController::class,
    'show'
])->name('orders.show');

Route::post('/orders', [
    App\Http\Controllers\OrderController::class,
    'store'
])->name('orders.store');

Route::put('/orders/{id}', [
    App\Http\Controllers\OrderController::class,
    'update'
])->name('orders.update');

//orderdetail

Route::get('/orders/{order_id}/details', [
    App\Http\Controllers\OrderDetailController::class,
    'index'
])->name('order-details.index');

Route::post('/order-details', [
    App\Http\Controllers\OrderDetailController::class,
    'store'
])->name('order-details.store');

Route::delete('/order-details/{id}', [
    App\Http\Controllers\OrderDetailController::class,
    'destroy'
])->name('order-details.destroy');

//payment
Route::get('/payments', [
    App\Http\Controllers\PaymentController::class,
    'index'
])->name('payments.index');

Route::post('/payments', [
    App\Http\Controllers\PaymentController::class,
    'store'
])->name('payments.store');

Route::put('/payments/{id}/status', [
    App\Http\Controllers\PaymentController::class,
    'updateStatus'
])->name('payments.update-status');

//review
Route::get('/reviews', [
    App\Http\Controllers\ReviewController::class,
    'index'
])->name('reviews.index');

Route::post('/reviews', [
    App\Http\Controllers\ReviewController::class,
    'store'
])->name('reviews.store');

Route::delete('/reviews/{id}', [
    App\Http\Controllers\ReviewController::class,
    'destroy'
])->name('reviews.destroy');

//report
Route::get('/reports', [
    App\Http\Controllers\ReportController::class,
    'index'
])->name('reports.index');

Route::post('/reports/generate', [
    App\Http\Controllers\ReportController::class,
    'generate'
])->name('reports.generate');

Route::delete('/reports/{id}', [
    App\Http\Controllers\ReportController::class,
    'destroy'
])->name('reports.destroy');

//admin
Route::resource(
    'admins',
    App\Http\Controllers\AdminController::class
);
