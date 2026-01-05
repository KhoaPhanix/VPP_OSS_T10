<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer routes (requires authentication)
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [ProductManagementController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductManagementController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductManagementController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductManagementController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductManagementController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product}/stock', [ProductManagementController::class, 'updateStock'])->name('products.stock');

    // Categories
    Route::get('/categories', [CategoryManagementController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryManagementController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryManagementController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryManagementController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryManagementController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryManagementController::class, 'destroy'])->name('categories.destroy');

    // Orders
    Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderManagementController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/approve', [OrderManagementController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{order}/reject', [OrderManagementController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{order}/complete', [OrderManagementController::class, 'complete'])->name('orders.complete');

    // Reports
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/behavior', [ReportController::class, 'behavior'])->name('reports.behavior');
    Route::get('/reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top-products');
});
