-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS tech_store_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tech_store_db;

-- 1. Bảng danh mục
CREATE TABLE danhmuc (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Bảng sản phẩm chính
CREATE TABLE sanpham (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    danhmuc_id INT UNSIGNED NOT NULL,
    mota TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (danhmuc_id) REFERENCES danhmuc(id) ON DELETE CASCADE
);

-- 3. Bảng thuộc tính (màu sắc, dung lượng...)
CREATE TABLE thuoctinh (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Bảng giá trị thuộc tính
CREATE TABLE giatri_thuoctinh (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    thuoctinh_id INT UNSIGNED NOT NULL,
    giatri VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (thuoctinh_id) REFERENCES thuoctinh(id) ON DELETE CASCADE,
    UNIQUE KEY unique_giatri (thuoctinh_id, giatri)
);

-- 5. Liên kết sản phẩm - thuộc tính
CREATE TABLE sanpham_thuoctinh (
    sanpham_id INT UNSIGNED NOT NULL,
    thuoctinh_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (sanpham_id, thuoctinh_id),
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (thuoctinh_id) REFERENCES thuoctinh(id) ON DELETE CASCADE
);

-- 6. Bảng biến thể sản phẩm (MỌI sản phẩm đều có ít nhất 1 biến thể)
CREATE TABLE bien_the (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanpham_id INT UNSIGNED NOT NULL,
    sku VARCHAR(100) NOT NULL UNIQUE,
    gia DECIMAL(13, 0) NOT NULL,          -- Giá bán
    gia_von DECIMAL(13, 0) NOT NULL,     -- Giá vốn (dùng cho lợi nhuận)
    so_luong_ton INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE
);

-- 7. Liên kết biến thể - giá trị thuộc tính
CREATE TABLE bien_the_giatri (
    bien_the_id INT UNSIGNED NOT NULL,
    giatri_thuoctinh_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (bien_the_id, giatri_thuoctinh_id),
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE CASCADE,
    FOREIGN KEY (giatri_thuoctinh_id) REFERENCES giatri_thuoctinh(id) ON DELETE CASCADE
);

-- 8. Bảng hình ảnh sản phẩm
CREATE TABLE anh_sanpham (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanpham_id INT UNSIGNED NOT NULL,
    bien_the_id INT UNSIGNED NULL, -- NULL = ảnh chung; có = ảnh biến thể
    duong_dan VARCHAR(255) NOT NULL,
    la_anh_chinh BOOLEAN NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE CASCADE
);

-- 9. Bảng người dùng
CREATE TABLE nguoidung (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL,
    sdt VARCHAR(20),
    dia_chi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 10. Bảng đơn hàng
CREATE TABLE donhang (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoidung_id INT UNSIGNED NULL,
    ten_khach VARCHAR(100) NOT NULL,
    sdt_khach VARCHAR(20) NOT NULL,
    email_khach VARCHAR(150),
    dia_chi_khach TEXT NOT NULL,
    tong_tien DECIMAL(13, 0) NOT NULL,
    trang_thai ENUM('cho_xac_nhan', 'da_xac_nhan', 'dang_giao', 'hoan_thanh', 'da_huy') DEFAULT 'cho_xac_nhan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoidung_id) REFERENCES nguoidung(id) ON DELETE SET NULL
);

-- 11. Chi tiết đơn hàng
CREATE TABLE chitiet_donhang (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donhang_id INT UNSIGNED NOT NULL,
    sanpham_id INT UNSIGNED NOT NULL,
    bien_the_id INT UNSIGNED NOT NULL, -- Bắt buộc (vì mọi SP đều có biến thể)
    so_luong INT UNSIGNED NOT NULL,
    gia_luc_mua DECIMAL(13, 0) NOT NULL,
    FOREIGN KEY (donhang_id) REFERENCES donhang(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id),
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id)
);

-- 12. Bảng nhà cung cấp (tùy chọn nhưng nên có)
CREATE TABLE nha_cung_cap (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(150) NOT NULL,
    sdt VARCHAR(20),
    email VARCHAR(150),
    dia_chi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 13. Bảng phiếu nhập hàng
CREATE TABLE phieu_nhap (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nha_cung_cap_id INT UNSIGNED NULL,
    ghi_chu TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nha_cung_cap_id) REFERENCES nha_cung_cap(id) ON DELETE SET NULL
);

-- 14. Chi tiết phiếu nhập
CREATE TABLE chitiet_phieu_nhap (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    phieu_nhap_id INT UNSIGNED NOT NULL,
    bien_the_id INT UNSIGNED NOT NULL,
    so_luong_nhap INT UNSIGNED NOT NULL,
    gia_von_nhap DECIMAL(13, 0) NOT NULL, -- Giá vốn tại thời điểm nhập
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (phieu_nhap_id) REFERENCES phieu_nhap(id) ON DELETE CASCADE,
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE CASCADE
);

-- ============= DỮ LIỆU MẪU =============

-- Danh mục
INSERT INTO danhmuc (ten) VALUES 
('Dien thoai'), 
('May tinh xach tay'), 
('May tinh bang'), 
('Phu kien');

-- Thuộc tính
INSERT INTO thuoctinh (ten) VALUES 
('Mau sac'), 
('Dung luong luu tru');

-- Sản phẩm 1: iPhone 15 Pro Max (có biến thể)
INSERT INTO sanpham (ten, danhmuc_id, mota) 
VALUES ('iPhone 15 Pro Max', 1, 'iPhone cao cap 2023');

-- Gắn thuộc tính cho iPhone
INSERT INTO sanpham_thuoctinh (sanpham_id, thuoctinh_id) 
VALUES (1, 1), (1, 2);

-- Giá trị thuộc tính
INSERT INTO giatri_thuoctinh (thuoctinh_id, giatri) VALUES 
(1, 'Xanh Thien Thach'), (1, 'Den'),
(2, '128GB'), (2, '256GB');

-- Biến thể iPhone
INSERT INTO bien_the (sanpham_id, sku, gia, gia_von, so_luong_ton) VALUES
(1, 'IP15PM-XANH-128', 29990000, 25000000, 10),
(1, 'IP15PM-XANH-256', 32990000, 27000000, 8),
(1, 'IP15PM-DEN-128', 29990000, 25000000, 5);

-- Gắn giá trị thuộc tính cho biến thể
INSERT INTO bien_the_giatri (bien_the_id, giatri_thuoctinh_id) VALUES
(1, 1), (1, 3), -- Xanh + 128GB
(2, 1), (2, 4), -- Xanh + 256GB
(3, 2), (3, 3); -- Den + 128GB

-- Sản phẩm 2: Phụ kiện (Ốp lưng) → vẫn có 1 biến thể
INSERT INTO sanpham (ten, danhmuc_id, mota) 
VALUES ('Op lung iPhone 15 Pro Max', 4, 'Op silicone cao cap');

-- Không gắn thuộc tính (vì là phụ kiện đơn)

-- Biến thể cho phụ kiện (1 biến thể duy nhất)
INSERT INTO bien_the (sanpham_id, sku, gia, gia_von, so_luong_ton) 
VALUES (2, 'OP15PM-001', 250000, 120000, 50);

-- Hình ảnh
INSERT INTO anh_sanpham (sanpham_id, bien_the_id, duong_dan, la_anh_chinh) VALUES
(1, NULL, 'images/iphone15pm/main.jpg', 1),
(1, 1, 'images/iphone15pm/xanh-128.jpg', 1),
(2, 4, 'images/phukien/op15pm.jpg', 1);

-- Nhà cung cấp
INSERT INTO nha_cung_cap (ten, sdt, dia_chi) 
VALUES ('Cong ty ABC', '0909123456', 'Ha Noi');

-- Phiếu nhập mẫu
INSERT INTO phieu_nhap (nha_cung_cap_id, ghi_chu) 
VALUES (1, 'Nhap lan dau');

INSERT INTO chitiet_phieu_nhap (phieu_nhap_id, bien_the_id, so_luong_nhap, gia_von_nhap) VALUES
(1, 1, 10, 25000000),
(1, 4, 50, 120000);