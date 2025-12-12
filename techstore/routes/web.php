<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\NguoiDungController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerAuthController;
use Illuminate\Support\Facades\Route;

// Customer/Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{key}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{key}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

// Customer Auth Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

// Alias for customer routes (shorter URLs)
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login']);
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register']);
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (không cần middleware)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Danh mục
        Route::resource('danhmuc', DanhMucController::class);

                // Sản phẩm
                Route::resource('sanpham', SanPhamController::class);
                Route::post('sanpham/{id}/images', [SanPhamController::class, 'addImages'])->name('sanpham.addImages');
                Route::delete('sanpham/images/{id}', [SanPhamController::class, 'deleteImage'])->name('sanpham.deleteImage');
                Route::patch('sanpham/images/{id}/primary', [SanPhamController::class, 'setPrimaryImage'])->name('sanpham.setPrimaryImage');
                Route::post('sanpham/{id}/variants', [SanPhamController::class, 'addVariant'])->name('sanpham.addVariant');
                Route::put('sanpham/{id}/variants/{variantId}', [SanPhamController::class, 'updateVariant'])->name('sanpham.updateVariant');
                Route::delete('sanpham/{id}/variants/{variantId}', [SanPhamController::class, 'deleteVariant'])->name('sanpham.deleteVariant');

        // Đơn hàng
        Route::get('donhang', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('donhang/{donHang}', [DonHangController::class, 'show'])->name('donhang.show');
        Route::patch('donhang/{donHang}/status', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');

                // Nhập hàng
                Route::get('phieunhap', [App\Http\Controllers\Admin\PhieuNhapController::class, 'index'])->name('phieunhap.index');
                Route::get('phieunhap/create', [App\Http\Controllers\Admin\PhieuNhapController::class, 'create'])->name('phieunhap.create');
                Route::post('phieunhap', [App\Http\Controllers\Admin\PhieuNhapController::class, 'store'])->name('phieunhap.store');
                Route::get('phieunhap/{id}', [App\Http\Controllers\Admin\PhieuNhapController::class, 'show'])->name('phieunhap.show');
                Route::delete('phieunhap/{id}', [App\Http\Controllers\Admin\PhieuNhapController::class, 'destroy'])->name('phieunhap.destroy');

                // Nhà cung cấp
                Route::get('nhacungcap', [App\Http\Controllers\Admin\NhaCungCapController::class, 'index'])->name('nhacungcap.index');
                Route::post('nhacungcap', [App\Http\Controllers\Admin\NhaCungCapController::class, 'store'])->name('nhacungcap.store');
                Route::put('nhacungcap/{id}', [App\Http\Controllers\Admin\NhaCungCapController::class, 'update'])->name('nhacungcap.update');
                Route::delete('nhacungcap/{id}', [App\Http\Controllers\Admin\NhaCungCapController::class, 'destroy'])->name('nhacungcap.destroy');

                // Người dùng
                Route::get('nguoidung', [NguoiDungController::class, 'index'])->name('nguoidung.index');
                Route::get('nguoidung/{nguoidung}', [NguoiDungController::class, 'show'])->name('nguoidung.show');
            });
        });
