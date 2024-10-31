<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Example route for authenticated users
Route::get('/dashboard', function () {
    return view('admin.admin_dashboard');
})->name('dashboard')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\OrderController::class, 'dashboard'])
         ->name('admin.dashboard');
    Route::get('/admin/manage_orders', [AdminController::class, 'manageOrders'])->name('admin.manage_orders');
    Route::get('/admin/manage_accounts', [AdminController::class, 'manageAccounts'])->name('admin.users');
    Route::get('/admin/manage_products', [AdminController::class, 'manageProducts'])->name('admin.users');
    Route::post('/admin/store_account', [AdminController::class, 'storeAccount'])->name('admin.store_account');
    Route::get('/admin/edit_account/{id}', [AdminController::class, 'editAccount'])->name('admin.edit_account');
    Route::put('/admin/update_account/{id}', [AdminController::class, 'updateAccount'])->name('admin.update_account');
    Route::delete('/admin/delete_account/{id}', [AdminController::class, 'deleteAccount'])->name('admin.delete_account');
    Route::put('/admin/update_order_status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.update_order_status');
    Route::post('/admin/store_product', [AdminController::class, 'storeProduct'])->name('admin.store_product');
    Route::get('/admin/edit_product/{id}', [AdminController::class, 'editProduct'])->name('admin.edit_product');
    Route::put('/admin/update_product/{id}', [AdminController::class, 'updateProduct'])->name('admin.update_product');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.delete_product');
    Route::get('/admin/charts', [AdminController::class, 'charts'])->name('admin.charts');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
         ->name('admin.orders.update_status');
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.edit_product');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.update_product');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.delete_product');
});

// Order routes
Route::middleware(['auth'])->group(function () {
    // Customer routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/purchase-history', [OrderController::class, 'history'])->name('purchase.history');

    // Admin routes
    Route::middleware(['admin'])->group(function () {
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
             ->name('admin.orders.update_status');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Public routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.edit_product');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.update_product');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.delete_product');
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        Route::resource('products', AdminProductController::class);
    });
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [App\Http\Controllers\CheckoutController::class, 'cart'])->name('index');
    Route::post('/add/{product}', [App\Http\Controllers\CheckoutController::class, 'addToCart'])->name('add');
    Route::patch('/update/{id}', [App\Http\Controllers\CheckoutController::class, 'updateCart'])->name('update');
    Route::delete('/remove/{id}', [App\Http\Controllers\CheckoutController::class, 'removeFromCart'])->name('remove');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders/history', [CheckoutController::class, 'purchaseHistory'])->name('orders.history');
});

// Grup route untuk admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\UserController::class, 'dashboard'])->name('dashboard');
    
    // User management - gunakan resource routing
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Resource routes untuk orders dan products
    Route::resource('orders', OrderController::class);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Route untuk gambar produk
Route::get('products/{image}', function($image) {
    $path = storage_path('app/public/products/' . $image);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->where('image', '.*\.(jpg|jpeg|png|gif|webp)$');

// Route untuk member
Route::middleware(['auth', 'member'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/purchase/history', [OrderController::class, 'history'])->name('purchase.history');
});

// Route untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
});

Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->middleware('member')->name('checkout.process');

// Rute untuk halaman sukses setelah checkout
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

Route::get('/home', [HomeController::class, 'index'])->name('home');