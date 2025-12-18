<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\NguoiDungController;
use App\Http\Controllers\Admin\ThuongHieuController;
use App\Http\Controllers\Admin\MaGiamGiaController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\BaoHanhController;
use App\Http\Controllers\Admin\NhatKyController;
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

        // Thương hiệu
        Route::get('thuonghieu', [ThuongHieuController::class, 'index'])->name('thuonghieu.index');
        Route::post('thuonghieu', [ThuongHieuController::class, 'store'])->name('thuonghieu.store');
        Route::put('thuonghieu/{id}', [ThuongHieuController::class, 'update'])->name('thuonghieu.update');
        Route::delete('thuonghieu/{id}', [ThuongHieuController::class, 'destroy'])->name('thuonghieu.destroy');

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
        Route::patch('nguoidung/{nguoidung}/toggle-status', [NguoiDungController::class, 'toggleStatus'])->name('nguoidung.toggleStatus');

        // Mã giảm giá / Voucher
        Route::get('magiamgia', [MaGiamGiaController::class, 'index'])->name('magiamgia.index');
        Route::get('magiamgia/create', [MaGiamGiaController::class, 'create'])->name('magiamgia.create');
        Route::post('magiamgia', [MaGiamGiaController::class, 'store'])->name('magiamgia.store');
        Route::get('magiamgia/{id}/edit', [MaGiamGiaController::class, 'edit'])->name('magiamgia.edit');
        Route::put('magiamgia/{id}', [MaGiamGiaController::class, 'update'])->name('magiamgia.update');
        Route::delete('magiamgia/{id}', [MaGiamGiaController::class, 'destroy'])->name('magiamgia.destroy');
        Route::patch('magiamgia/{id}/toggle', [MaGiamGiaController::class, 'toggleStatus'])->name('magiamgia.toggle');

        // Đánh giá & Bình luận
        Route::get('danhgia', [DanhGiaController::class, 'index'])->name('danhgia.index');
        Route::get('danhgia/{id}', [DanhGiaController::class, 'show'])->name('danhgia.show');
        Route::patch('danhgia/{id}/status', [DanhGiaController::class, 'updateStatus'])->name('danhgia.status');
        Route::delete('danhgia/{id}', [DanhGiaController::class, 'destroy'])->name('danhgia.destroy');
        Route::get('binhluan', [DanhGiaController::class, 'binhLuanIndex'])->name('danhgia.binhluan');
        Route::patch('binhluan/{id}/status', [DanhGiaController::class, 'binhLuanUpdateStatus'])->name('danhgia.binhluan.status');
        Route::delete('binhluan/{id}', [DanhGiaController::class, 'binhLuanDestroy'])->name('danhgia.binhluan.destroy');

        // Bảo hành
        Route::get('baohanh', [BaoHanhController::class, 'index'])->name('baohanh.index');
        Route::get('baohanh/{id}', [BaoHanhController::class, 'show'])->name('baohanh.show');
        Route::patch('baohanh/{id}/status', [BaoHanhController::class, 'updateStatus'])->name('baohanh.status');
        Route::delete('baohanh/{id}', [BaoHanhController::class, 'destroy'])->name('baohanh.destroy');

        // Nhật ký hoạt động
        Route::get('nhatky', [NhatKyController::class, 'index'])->name('nhatky.index');
        Route::get('nhatky/{id}', [NhatKyController::class, 'show'])->name('nhatky.show');
    });
});
