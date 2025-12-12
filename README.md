Hệ thống thương mại điện tử chuyên bán điện thoại, máy tính, máy tính bảng và phụ kiện công nghệ
Một nền tảng web cho phép người dùng mua sắm trực tuyến các sản phẩm công nghệ như điện thoại, máy tính xách tay, máy tính bảng và phụ kiện liên quan, hỗ trợ cả khách vãng lai và người dùng đã đăng ký, kèm theo giao diện quản trị dành cho quản trị viên.
🧩 Chức năng hệ thống
👤 1. Khách vãng lai (Guest)
Duyệt danh mục sản phẩm theo nhóm:
    Điện thoại
    Máy tính xách tay (Laptop)
    Máy tính bảng (Tablet)
    Phụ kiện (sạc, cáp, ốp, tai nghe, chuột, bàn phím, v.v.)
Tìm kiếm sản phẩm theo tên hoặc mã
Xem chi tiết sản phẩm (hình ảnh, mô tả, giá, đánh giá – nếu có)
Thêm/sửa/xóa sản phẩm trong giỏ hàng tạm (dựa trên session)

🔐 2. Người dùng đã đăng ký (Customer)
Đăng ký tài khoản (xác minh email – tùy chọn)
Đăng nhập / Đăng xuất
Quản lý thông tin cá nhân và địa chỉ giao hàng
Sử dụng giỏ hàng được lưu bền vững (liên kết với tài khoản)
Đặt hàng và theo dõi trạng thái đơn hàng (Chờ xác nhận → Đang giao → Hoàn thành / Đã hủy)
Xem lịch sử mua hàng
(Tùy chọn trong tương lai: Đánh giá & bình luận sản phẩm)

🛠️ 3. Quản trị viên (Admin)
Đăng nhập hệ thống quản trị (riêng biệt hoặc phân quyền)
    Quản lý danh mục sản phẩm:
    Thêm / Sửa / Xóa sản phẩm
    Phân loại sản phẩm theo loại (Điện thoại, Laptop, Tablet, Phụ kiện)
Cập nhật hình ảnh, giá, số lượng tồn kho, mô tả
Quản lý đơn hàng:
    Xem toàn bộ đơn hàng (từ guest và user)
    Cập nhật trạng thái đơn hàng theo quy trình
    Xem thông tin khách hàng & địa chỉ giao hàng
Quản lý người dùng:
    Xem danh sách tài khoản đã đăng ký
    Khóa / mở tài khoản (nếu cần)
Thống kê cơ bản (tùy chọn):
    Doanh số theo ngày/tuần
    Sản phẩm bán chạy

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

Truy cập ứng dụng tại: `http://localhost:8000`

### Bước 6: Đăng nhập Admin Panel

Truy cập: `http://localhost:8000/admin/login`

**Thông tin đăng nhập mặc định:**
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
│   │   │       └── Admin/          # Controllers cho admin
│   │   └── Models/                 # Eloquent Models
│   ├── database/
│   │   ├── migrations/             # Database migrations
│   │   └── seeders/                # Database seeders
│   ├── resources/
│   │   └── views/
│   │       └── admin/              # Views cho admin panel
│   └── routes/
│       └── web.php                 # Web routes
└── README.md
```

## 🔑 Tài khoản mẫu

Sau khi chạy `php artisan db:seed`, bạn sẽ có:

**Admin:**
- Email: `admin@gmail.com`
- Password: `admin123`

**Customer:**
- Email: `customer@gmail.com`
- Password: `customer123`

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