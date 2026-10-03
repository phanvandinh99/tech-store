 BẢN ĐẶC TẢ YÊU CẦU HỆ THỐNG
NỀN TẢNG THƯƠNG MẠI ĐIỆN TỬ CÔNG NGHỆ – PHIÊN BẢN HOÀN CHỈNH
📌 1. Tổng quan
Hệ thống là một nền tảng web thương mại điện tử chuyên biệt cho lĩnh vực thiết bị và phụ kiện công nghệ, cho phép người dùng duyệt, so sánh, mua sắm, đánh giá và yêu cầu bảo hành sản phẩm. Hệ thống hỗ trợ ba vai trò: Khách vãng lai, Khách hàng đã đăng ký, và Quản trị viên, với giao diện người dùng thân thiện và giao diện quản trị toàn diện.

Mục tiêu:

Trải nghiệm mua sắm liền mạch, minh bạch
Hỗ trợ toàn diện trước – trong – sau bán hàng
Dễ mở rộng, bảo trì và vận hành
🧩 2. Chức năng chi tiết theo vai trò
👤 2.1. Khách vãng lai (Guest)
Duyệt sản phẩm theo danh mục: Điện thoại, Laptop, Tablet, Phụ kiện
Tìm kiếm sản phẩm theo tên, mã sản phẩm, thương hiệu
Lọc & sắp xếp nâng cao:
Theo khoảng giá, đánh giá (≥4 sao), tồn kho
Sắp xếp: mới nhất, giá tăng/giảm, bán chạy
Xem chi tiết sản phẩm:
Hình ảnh (slider), mô tả, thông số kỹ thuật, giá, tồn kho
Hiển thị đánh giá trung bình và số lượt đánh giá
Xem bình luận & đánh giá (chỉ đọc)
So sánh sản phẩm: chọn 2–4 sản phẩm → xem bảng so sánh thông số
Giỏ hàng tạm: thêm/sửa/xóa dựa trên session
Danh sách yêu thích tạm: lưu trong session (không bền)
⚠️ Guest không thể đặt hàng, đánh giá, đăng ký bảo hành hoặc lưu yêu thích bền vững.

🔐 2.2. Khách hàng đã đăng ký (Customer)
🔹 Tài khoản & cá nhân
Đăng ký (bắt buộc xác minh email)
Đăng nhập / đăng xuất / quên mật khẩu
Quản lý hồ sơ: tên, SĐT, email
Quản lý nhiều địa chỉ giao hàng
🔹 Mua sắm & đơn hàng
Giỏ hàng lưu bền (kết nối với tài khoản)
Danh sách yêu thích (Wishlist): thêm/xóa/xem sản phẩm
So sánh sản phẩm (lưu được trong tài khoản)
Gợi ý thông minh:
Sản phẩm bạn vừa xem
Khách hàng thường mua cùng
Áp dụng mã giảm giá / voucher tại giỏ hàng
Đặt hàng → chọn địa chỉ, phương thức (COD hoặc thanh toán online – mô phỏng)
Theo dõi đơn hàng theo trạng thái:
Chờ xác nhận → Đã xác nhận → Đang giao → Hoàn thành / Đã hủy
🔹 Tương tác & hậu mãi
Đánh giá sản phẩm (chỉ sau khi đơn hoàn thành):
Sao (1–5), nội dung, hình ảnh (tùy chọn)
Bình luận dưới đánh giá (tùy chọn)
Quản lý bảo hành:
Xem danh sách sản phẩm đủ điều kiện bảo hành
Tạo yêu cầu bảo hành: mô tả lỗi, tải ảnh, chọn hình thức
Theo dõi trạng thái: Chờ tiếp nhận → Đang xử lý → Hoàn tất / Từ chối
🔹 Thông báo
Nhận email tự động:
Xác nhận đơn hàng
Cập nhật trạng thái giao hàng
Nhắc nhở đánh giá sau 3 ngày nhận hàng
🛠️ 2.3. Quản trị viên (Admin)
🔹 Xác thực & bảo mật
Đăng nhập riêng qua /admin
Middleware phân quyền mạnh (role: admin)
Nhật ký hoạt động (Activity Log): ghi lại thao tác sửa/xóa
🔹 Quản lý sản phẩm & danh mục
Tạo/sửa/xóa danh mục (có thể phân cấp)
Quản lý sản phẩm:
Tải nhiều ảnh
Nhập thông số kỹ thuật (bảng key-value)
Cập nhật giá, tồn kho, trạng thái hiển thị
Gắn thương hiệu, mã SKU
Quản lý nhà cung cấp (tùy chọn mở rộng)
🔹 Quản lý đơn hàng & khách hàng
Xem toàn bộ đơn (kể cả của guest)
Cập nhật trạng thái đơn hàng
Xem thông tin khách & địa chỉ giao hàng
Quản lý tài khoản người dùng: xem, khóa/mở
🔹 Quản lý khuyến mãi & voucher
Tạo mã giảm giá:
Theo % hoặc số tiền cố định
Giới hạn: đơn tối thiểu, số lần dùng, thời gian
Tạo chương trình khuyến mãi: “Mua 2 phụ kiện giảm 10%”
🔹 Quản lý đánh giá & bình luận
Duyệt / ẩn / xóa đánh giá (chống nội dung xấu)
🔹 Quản lý bảo hành
Xem & xử lý yêu cầu bảo hành
Cập nhật trạng thái & ghi chú nội bộ
Liên kết với phiếu bảo hành chính hãng (nếu có)
🔹 Thống kê & báo cáo
Doanh thu theo ngày/tuần/tháng
Sản phẩm bán chạy nhất
Tỷ lệ đơn hoàn thành / hủy
Số lượng đánh giá & yêu cầu bảo hành
🔹 Quản lý tồn kho
Cảnh báo “sắp hết hàng” (số lượng < ngưỡng)
Xem lịch sử nhập hàng (nếu có quản lý nhà cung cấp)

🧱 Công nghệ sử dụng
- Frontend: HTML, CSS, JavaScript (Bootstrap 5)
- Backend: PHP với framework Laravel 12
- Cơ sở dữ liệu: MySQL
- Môi trường phát triển: XAMPP / Visual Studio Code

## 🚀 Hướng dẫn cài đặt và chạy dự án

### Yêu cầu hệ thống
- PHP >= 8.2
- Composer
- MySQL >= 5.7 hoặc MariaDB >= 10.3
- Node.js >= 18.x và npm
- XAMPP (hoặc Apache + MySQL riêng)

### Bước 1: Clone và cài đặt dependencies

```bash
# Di chuyển vào thư mục dự án
cd tech-store/techstore

# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### Bước 2: Cấu hình môi trường

1. Copy file `.env.example` thành `.env`:
```bash
copy .env.example .env
```

2. Mở file `.env` và cấu hình database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tech_store_db
DB_USERNAME=root
DB_PASSWORD=
```

3. Tạo database MySQL:
```sql
CREATE DATABASE tech_store_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Bước 3: Chạy migrations và seeders

```bash
# Tạo application key
php artisan key:generate

# Chạy migrations để tạo các bảng
php artisan migrate

# Chạy seeders để tạo dữ liệu mẫu
php artisan db:seed
```

### Bước 4: Build frontend assets

```bash
# Build assets cho production
npm run build

# Hoặc chạy dev server (tự động reload)
npm run dev
```

### Bước 5: Chạy server

```bash
# Chạy Laravel development server
php artisan serve
```

### Bước 6: Truy cập ứng dụng

**Trang khách hàng (Frontend):**
- URL: `http://localhost:8000`
- Chức năng: Xem sản phẩm, thêm vào giỏ hàng, đặt hàng

**Trang quản trị (Admin Panel):**
- URL: `http://localhost:8000/admin/login`
- Thông tin đăng nhập mặc định:
  - Email: `admin@gmail.com`
  - Password: `admin123`

## 📁 Cấu trúc dự án

```
tech-store/
├── Database/
│   └── tech_store_db.sql          # File SQL schema gốc
├── techstore/                      # Thư mục Laravel chính
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       ├── Admin/          # Controllers cho admin
│   │   │       │   ├── AuthController.php
│   │   │       │   ├── DashboardController.php
│   │   │       │   ├── DanhMucController.php
│   │   │       │   ├── SanPhamController.php
│   │   │       │   ├── DonHangController.php
│   │   │       │   └── NguoiDungController.php
│   │   │       └── Customer/       # Controllers cho khách hàng
│   │   │           ├── HomeController.php
│   │   │           ├── ProductController.php
│   │   │           ├── CartController.php
│   │   │           ├── CheckoutController.php
│   │   │           └── CustomerAuthController.php
│   │   └── Models/                 # Eloquent Models
│   ├── database/
│   │   ├── migrations/             # Database migrations
│   │   └── seeders/                # Database seeders
│   ├── resources/
│   │   └── views/
│   │       ├── admin/              # Views cho admin panel
│   │       └── frontend/           # Views cho trang khách hàng
│   │           ├── layout.blade.php
│   │           ├── home.blade.php
│   │           └── partials/        # Header, Footer, Offcanvas
│   └── routes/
│       └── web.php                 # Web routes
└── README.md
```

## 🛣️ Routes và URLs

### Frontend Routes (Trang khách hàng)
- **Trang chủ:** `http://localhost:8000/`
- **Danh sách sản phẩm:** `http://localhost:8000/san-pham`
- **Chi tiết sản phẩm:** `http://localhost:8000/san-pham/{id}`
- **Giỏ hàng:** `http://localhost:8000/cart`
- **Thanh toán:** `http://localhost:8000/checkout`
- **Đăng nhập:** `http://localhost:8000/login`
- **Đăng ký:** `http://localhost:8000/register`

### Admin Routes (Trang quản trị)
- **Đăng nhập admin:** `http://localhost:8000/admin/login`
- **Dashboard:** `http://localhost:8000/admin/dashboard`
- **Quản lý danh mục:** `http://localhost:8000/admin/danhmuc`
- **Quản lý sản phẩm:** `http://localhost:8000/admin/sanpham`
- **Quản lý đơn hàng:** `http://localhost:8000/admin/donhang`
- **Quản lý người dùng:** `http://localhost:8000/admin/nguoidung`

## 🎯 Cấu trúc Controllers

Dự án được tổ chức với 2 namespace chính để dễ quản lý và phát triển:

### 1. Admin Controllers (`App\Http\Controllers\Admin\`)
Quản lý toàn bộ chức năng quản trị:
- `AuthController` - Xác thực và đăng nhập admin
- `DashboardController` - Dashboard thống kê
- `DanhMucController` - CRUD danh mục sản phẩm
- `SanPhamController` - CRUD sản phẩm
- `DonHangController` - Quản lý đơn hàng
- `NguoiDungController` - Quản lý người dùng

### 2. Customer Controllers (`App\Http\Controllers\Customer\`)
Quản lý toàn bộ chức năng phía khách hàng:
- `HomeController` - Trang chủ và hiển thị sản phẩm nổi bật
- `ProductController` - Danh sách và chi tiết sản phẩm
- `CartController` - Quản lý giỏ hàng (thêm, sửa, xóa)
- `CheckoutController` - Xử lý thanh toán
- `CustomerAuthController` - Đăng nhập/Đăng ký khách hàng

## 🔑 Tài khoản mẫu

Sau khi chạy `php artisan db:seed`, bạn sẽ có:

**Admin:**
- Email: `admin@gmail.com`
- Password: `admin123`

**Customer:**
- Email: `clontomi1@gmail.com`
- Password: `abc123456`

## 📊 Dữ liệu mẫu

Seeder sẽ tạo:
- 4 danh mục: Điện thoại, Máy tính xách tay, Máy tính bảng, Phụ kiện
- 2 thuộc tính: Màu sắc, Dung lượng lưu trữ
- 2 sản phẩm mẫu: iPhone 15 Pro Max (3 biến thể), Ốp lưng (1 biến thể)
- 1 nhà cung cấp và phiếu nhập mẫu

## 🛠️ Các lệnh hữu ích

```bash
# Xóa và tạo lại database (fresh migration + seed)
php artisan migrate:fresh --seed

# Tạo migration mới
php artisan make:migration create_table_name

# Tạo model mới
php artisan make:model ModelName

# Tạo controller mới
php artisan make:controller ControllerName

# Xóa cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📝 Lưu ý

- Đảm bảo MySQL service đang chạy trước khi chạy migrations
- Nếu gặp lỗi permission, chạy: `chmod -R 775 storage bootstrap/cache`
- Để sử dụng SQLite thay vì MySQL, đổi `DB_CONNECTION=sqlite` trong `.env`


https://myaccount.google.com/apppasswords