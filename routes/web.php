<?php

use Illuminate\Support\Facades\Route;

// HALAMAN PUBLIK

// Halaman Home / Beranda
Route::get('/', [
    App\Http\Controllers\HomeController::class,
    'index'
])->name('home');

// Halaman Catalog
Route::get('/catalog', [
    App\Http\Controllers\HomeController::class,
    'catalog'
])->name('catalog');

// Halaman Tentang Kami
Route::get('/about', function () {
    return view('about');
})->name('about');

// Halaman Contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// DETAIL PRODUK

// Guest dan customer dapat melihat detail produk
Route::get('/products/{id}', [
    App\Http\Controllers\ProductController::class,
    'show'
])->name('products.show');


// AUTH / LOGIN DAN REGISTER

// Halaman Login
Route::get('/login', [
    App\Http\Controllers\AuthController::class,
    'showLogin'
])->name('login');

// Proses Login
Route::post('/login', [
    App\Http\Controllers\AuthController::class,
    'login'
])->name('login.process');

// Halaman Register
Route::get('/register', [
    App\Http\Controllers\AuthController::class,
    'register'
])->name('register');

// Proses Register
Route::post('/register', [
    App\Http\Controllers\AuthController::class,
    'storeRegister'
])->name('register.store');

// Logout
Route::post('/logout', [
    App\Http\Controllers\AuthController::class,
    'logout'
])->name('logout');


// USER / CUSTOMER
// Semua route di dalam bagian ini harus login

Route::middleware(['auth'])->group(function () {

    // CART / KERANJANG

    // Menampilkan keranjang
    Route::get('/cart', [
        App\Http\Controllers\CartController::class,
        'index'
    ])->name('cart.index');

    // Menambahkan produk ke keranjang
    Route::post('/cart', [
        App\Http\Controllers\CartController::class,
        'store'
    ])->name('cart.store');

    // Mengubah jumlah produk di keranjang
    Route::put('/cart/{id}', [
        App\Http\Controllers\CartController::class,
        'update'
    ])->name('cart.update');

    // Menghapus produk dari keranjang
    Route::delete('/cart/{id}', [
        App\Http\Controllers\CartController::class,
        'destroy'
    ])->name('cart.destroy');


    // CHECKOUT

    // Menampilkan halaman checkout
    Route::get('/checkout', [
        App\Http\Controllers\OrderController::class,
        'checkout'
    ])->name('checkout.index');


    // ORDER / PESANAN CUSTOMER

    // Menampilkan daftar pesanan customer
    Route::get('/orders', [
        App\Http\Controllers\OrderController::class,
        'index'
    ])->name('orders.index');

    // Menampilkan detail pesanan customer
    Route::get('/orders/{id}', [
        App\Http\Controllers\OrderController::class,
        'show'
    ])->name('orders.show');

    // Menampilkan invoice pesanan
    Route::get('/orders/{id}/invoice', [
        App\Http\Controllers\OrderController::class,
        'invoice'
    ])->name('orders.invoice');

    // Membuat pesanan dari checkout
    Route::post('/orders', [
        App\Http\Controllers\OrderController::class,
        'store'
    ])->name('orders.store');

    // Membatalkan pesanan
    Route::post('/orders/{id}/cancel', [
        App\Http\Controllers\OrderController::class,
        'cancel'
    ])->name('orders.cancel');


    // ORDER DETAIL

    // Menampilkan detail item dalam pesanan
    Route::get('/orders/{order_id}/details', [
        App\Http\Controllers\OrderDetailController::class,
        'index'
    ])->name('order-details.index');

    // Menambahkan detail pesanan
    Route::post('/order-details', [
        App\Http\Controllers\OrderDetailController::class,
        'store'
    ])->name('order-details.store');

    // Menghapus detail pesanan
    Route::delete('/order-details/{id}', [
        App\Http\Controllers\OrderDetailController::class,
        'destroy'
    ])->name('order-details.destroy');


    // PAYMENT / PEMBAYARAN CUSTOMER

    // Halaman konfirmasi pembayaran
    Route::get('/payment/confirmation/{order_id}', [
        App\Http\Controllers\PaymentController::class,
        'confirmation'
    ])->name('payments.confirmation');

    // Upload / menyimpan bukti pembayaran
    Route::post('/payments', [
        App\Http\Controllers\PaymentController::class,
        'store'
    ])->name('payments.store');


    // REVIEW / ULASAN CUSTOMER

    // Halaman membuat review
    Route::get('/orders/{order_id}/reviews', [
        App\Http\Controllers\ReviewController::class,
        'create'
    ])->name('reviews.create');

    // Menyimpan review
    Route::post('/reviews', [
        App\Http\Controllers\ReviewController::class,
        'store'
    ])->name('reviews.store');


    // PROFILE CUSTOMER

    // Menampilkan profile
    Route::get('/profile', [
        App\Http\Controllers\ProfileController::class,
        'edit'
    ])->name('profile.edit');

    // Mengubah profile
    Route::put('/profile', [
        App\Http\Controllers\ProfileController::class,
        'update'
    ])->name('profile.update');
});


// ADMIN
// Semua route di dalam bagian ini harus login dan harus admin

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD ADMIN

        // Menampilkan dashboard admin
        Route::get('/dashboard', [
            App\Http\Controllers\DashboardController::class,
            'index'
        ])->name('dashboard');


        // PRODUK

        // CRUD produk admin
        Route::resource(
            'products',
            App\Http\Controllers\ProductController::class
        );


        // KATEGORI

        // CRUD kategori admin
        Route::resource(
            'categories',
            App\Http\Controllers\CategoryController::class
        );


        // PESANAN CUSTOMER

        // Menampilkan semua pesanan
        Route::get('/orders', [
            App\Http\Controllers\OrderController::class,
            'indexAdmin'
        ])->name('orders.index');

        // Menampilkan detail pesanan
        Route::get('/orders/{id}', [
            App\Http\Controllers\OrderController::class,
            'showAdmin'
        ])->name('orders.show');

        // Mengubah status pesanan
        Route::put('/orders/{id}', [
            App\Http\Controllers\OrderController::class,
            'update'
        ])->name('orders.update');


        // PEMBAYARAN CUSTOMER

        // Menampilkan semua pembayaran
        Route::get('/payments', [
            App\Http\Controllers\PaymentController::class,
            'index'
        ])->name('payments.index');

        // Menampilkan detail pembayaran
        Route::get('/payments/{id}', [
            App\Http\Controllers\PaymentController::class,
            'show'
        ])->name('payments.show');

        // Menampilkan bukti pembayaran sebagai gambar
        Route::get('/payments/{id}/proof', [
            App\Http\Controllers\PaymentController::class,
            'proof'
        ])->name('payments.proof');

        // Mengubah status pembayaran
        Route::put('/payments/{id}/status', [
            App\Http\Controllers\PaymentController::class,
            'updateStatus'
        ])->name('payments.update-status');


        // REVIEW / ULASAN

        // Menampilkan semua review
        Route::get('/reviews', [
            App\Http\Controllers\ReviewController::class,
            'index'
        ])->name('reviews.index');

        // Menampilkan detail review
        Route::get('/reviews/{id}', [
            App\Http\Controllers\ReviewController::class,
            'show'
        ])->name('reviews.show');

        // Menghapus review
        Route::delete('/reviews/{id}', [
            App\Http\Controllers\ReviewController::class,
            'destroy'
        ])->name('reviews.destroy');


        // REPORT / LAPORAN

        // Menampilkan semua laporan
        Route::get('/reports', [
            App\Http\Controllers\ReportController::class,
            'index'
        ])->name('reports.index');

        // Membuat laporan
        Route::post('/reports/generate', [
            App\Http\Controllers\ReportController::class,
            'generate'
        ])->name('reports.generate');

        // Menampilkan detail laporan
        Route::get('/reports/{id}', [
            App\Http\Controllers\ReportController::class,
            'show'
        ])->name('reports.show');

        // Menghapus laporan
        Route::delete('/reports/{id}', [
            App\Http\Controllers\ReportController::class,
            'destroy'
        ])->name('reports.destroy');


        // USER / PELANGGAN

        // Menampilkan daftar pelanggan
        Route::get('/users', [
            App\Http\Controllers\Admin\UserController::class,
            'index'
        ])->name('users.index');

        // Menampilkan detail pelanggan
        Route::get('/users/{id}', [
            App\Http\Controllers\Admin\UserController::class,
            'show'
        ])->name('users.show');


        // ADMIN

        // CRUD admin
        Route::resource(
            'admins',
            App\Http\Controllers\AdminController::class
        );
    });