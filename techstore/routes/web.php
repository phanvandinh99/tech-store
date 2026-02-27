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
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\WarrantyController;
use Illuminate\Support\Facades\Route;

// Customer/Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/chinh-sach-bao-hanh', function() {
    return view('frontend.pages.warranty-policy');
})->name('warranty.policy');

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

// Customer Orders Routes (requires customer authentication)
Route::middleware('auth:customer')->group(function () {
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::put('/{id}', [OrderController::class, 'update'])->name('update');
    });

    // Warranty Routes
    Route::prefix('warranty')->name('warranty.')->group(function () {
        Route::get('/', [WarrantyController::class, 'index'])->name('index');
        Route::get('/create', [WarrantyController::class, 'create'])->name('create');
        Route::post('/', [WarrantyController::class, 'store'])->name('store');
        Route::get('/{id}', [WarrantyController::class, 'show'])->name('show');
    });

    // Review Routes
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\ReviewController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Customer\ReviewController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Customer\ReviewController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Customer\ReviewController::class, 'update'])->name('update');
        Route::delete('/images/{id}', [App\Http\Controllers\Customer\ReviewController::class, 'deleteImage'])->name('deleteImage');
    });

    // Wishlist Routes
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\WishlistController::class, 'index'])->name('index');
        Route::post('/add', [App\Http\Controllers\Customer\WishlistController::class, 'add'])->name('add');
        Route::post('/remove', [App\Http\Controllers\Customer\WishlistController::class, 'remove'])->name('remove');
        Route::post('/toggle', [App\Http\Controllers\Customer\WishlistController::class, 'toggle'])->name('toggle');
        Route::post('/check', [App\Http\Controllers\Customer\WishlistController::class, 'check'])->name('check');
    });
});

// Customer Auth Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    
    // Password Reset Routes
    Route::get('/password/reset', [App\Http\Controllers\Customer\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Customer\ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
    Route::get('/password/verify', [App\Http\Controllers\Customer\ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('/password/reset', [App\Http\Controllers\Customer\ForgotPasswordController::class, 'resetPassword'])->name('password.update');
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
    
    // Password Reset Routes
    Route::get('/password/reset', [App\Http\Controllers\Admin\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Admin\ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
    Route::get('/password/verify', [App\Http\Controllers\Admin\ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('/password/reset', [App\Http\Controllers\Admin\ForgotPasswordController::class, 'resetPassword'])->name('password.update');

    // Protected admin routes
    Route::middleware(['auth:admin', 'admin'])->group(function () {
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

        // Thuộc tính sản phẩm
        Route::get('thuoctinh', [App\Http\Controllers\Admin\ThuocTinhController::class, 'index'])->name('thuoctinh.index');
        Route::get('thuoctinh/create', [App\Http\Controllers\Admin\ThuocTinhController::class, 'create'])->name('thuoctinh.create');
        Route::post('thuoctinh', [App\Http\Controllers\Admin\ThuocTinhController::class, 'store'])->name('thuoctinh.store');
        Route::get('thuoctinh/{id}/edit', [App\Http\Controllers\Admin\ThuocTinhController::class, 'edit'])->name('thuoctinh.edit');
        Route::put('thuoctinh/{id}', [App\Http\Controllers\Admin\ThuocTinhController::class, 'update'])->name('thuoctinh.update');
        Route::delete('thuoctinh/{id}', [App\Http\Controllers\Admin\ThuocTinhController::class, 'destroy'])->name('thuoctinh.destroy');
        Route::delete('thuoctinh/value/{id}', [App\Http\Controllers\Admin\ThuocTinhController::class, 'deleteValue'])->name('thuoctinh.deleteValue');

        // Đơn hàng
        Route::get('donhang', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('donhang/{donHang}', [DonHangController::class, 'show'])->name('donhang.show');
        Route::patch('donhang/{donHang}/status', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');
        Route::put('donhang/{donHang}', [DonHangController::class, 'update'])->name('donhang.update');

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

        // Thống kê
        Route::get('thongke', [App\Http\Controllers\Admin\ThongKeController::class, 'index'])->name('thongke.index');
        Route::get('thongke/chart-data', [App\Http\Controllers\Admin\ThongKeController::class, 'getChartDataAjax'])->name('thongke.chartData');
    });
});
