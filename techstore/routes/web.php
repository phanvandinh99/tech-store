<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\NguoiDungController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

        // Đơn hàng
        Route::get('donhang', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('donhang/{donHang}', [DonHangController::class, 'show'])->name('donhang.show');
        Route::patch('donhang/{donHang}/status', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');

        // Người dùng
        Route::get('nguoidung', [NguoiDungController::class, 'index'])->name('nguoidung.index');
        Route::get('nguoidung/{nguoidung}', [NguoiDungController::class, 'show'])->name('nguoidung.show');
    });
});
