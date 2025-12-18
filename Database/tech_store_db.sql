CREATE DATABASE IF NOT EXISTS tech_store_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tech_store_db;

-- ============================================================
-- PHẦN 1: XÁC THỰC & QUẢN TRỊ
-- ============================================================

-- 1. Bảng người dùng - Dùng cho cả Admin và Customer
CREATE TABLE nguoi_dung (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    email_da_xac_thuc_at TIMESTAMP NULL,
    mat_khau VARCHAR(255) NOT NULL,
    sdt VARCHAR(20) NULL,
    vai_tro ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    trang_thai ENUM('active', 'locked') NOT NULL DEFAULT 'active',
    token_ghi_nho VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_vai_tro (vai_tro),
    INDEX idx_trang_thai (trang_thai)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng nhật ký hoạt động - Ghi lại thao tác của Admin
CREATE TABLE nhat_ky_hoat_dong (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    hanh_dong VARCHAR(50) NOT NULL COMMENT 'create, update, delete',
    loai_model VARCHAR(100) NOT NULL COMMENT 'Tên model/table',
    id_model BIGINT UNSIGNED NULL COMMENT 'ID của record bị thay đổi',
    mo_ta TEXT NULL COMMENT 'Mô tả chi tiết',
    gia_tri_cu JSON NULL COMMENT 'Giá trị cũ (JSON)',
    gia_tri_moi JSON NULL COMMENT 'Giá trị mới (JSON)',
    dia_chi_ip VARCHAR(45) NULL,
    trinh_duyet TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_model (loai_model, id_model),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 2: QUẢN LÝ SẢN PHẨM & DANH MỤC
-- ============================================================

-- 3. Bảng thương hiệu
CREATE TABLE thuong_hieu (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL UNIQUE,
    mo_ta TEXT NULL,
    hinh_logo VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Bảng danh mục - Hỗ trợ phân cấp
CREATE TABLE danhmuc (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    id_cha BIGINT UNSIGNED NULL COMMENT 'Danh mục cha (NULL = danh mục gốc)',
    mo_ta TEXT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    thu_tu INT UNSIGNED DEFAULT 0 COMMENT 'Thứ tự hiển thị',
    hien_thi BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cha) REFERENCES danhmuc(id) ON DELETE SET NULL,
    INDEX idx_id_cha (id_cha),
    INDEX idx_slug (slug),
    INDEX idx_hien_thi (hien_thi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Bảng sản phẩm chính
CREATE TABLE sanpham (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    danhmuc_id BIGINT UNSIGNED NOT NULL,
    thuong_hieu_id BIGINT UNSIGNED NULL COMMENT 'Thương hiệu',
    mo_ta_ngan TEXT NULL COMMENT 'Mô tả ngắn',
    mo_ta_chi_tiet LONGTEXT NULL COMMENT 'Mô tả chi tiết',
    trang_thai ENUM('draft', 'active', 'inactive') NOT NULL DEFAULT 'draft' COMMENT 'Nháp, Hiển thị, Ẩn',
    luot_xem INT UNSIGNED DEFAULT 0,
    luot_ban INT UNSIGNED DEFAULT 0 COMMENT 'Số lượng đã bán',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (danhmuc_id) REFERENCES danhmuc(id) ON DELETE RESTRICT,
    FOREIGN KEY (thuong_hieu_id) REFERENCES thuong_hieu(id) ON DELETE SET NULL,
    INDEX idx_danhmuc_id (danhmuc_id),
    INDEX idx_thuong_hieu_id (thuong_hieu_id),
    INDEX idx_slug (slug),
    INDEX idx_trang_thai (trang_thai),
    INDEX idx_luot_ban (luot_ban)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Bảng thông số kỹ thuật sản phẩm (Key-Value)
CREATE TABLE thong_so_ky_thuat (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    ten_thong_so VARCHAR(150) NOT NULL COMMENT 'Tên thông số (key)',
    gia_tri VARCHAR(255) NOT NULL COMMENT 'Giá trị (value)',
    thu_tu INT UNSIGNED DEFAULT 0 COMMENT 'Thứ tự hiển thị',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    INDEX idx_sanpham_id (sanpham_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Bảng thuộc tính - Màu sắc, dung lượng, RAM...
CREATE TABLE thuoctinh (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL UNIQUE,
    mo_ta TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Bảng giá trị thuộc tính
CREATE TABLE giatri_thuoctinh (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    thuoctinh_id BIGINT UNSIGNED NOT NULL,
    giatri VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (thuoctinh_id) REFERENCES thuoctinh(id) ON DELETE CASCADE,
    UNIQUE KEY unique_giatri (thuoctinh_id, giatri),
    INDEX idx_thuoctinh_id (thuoctinh_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Liên kết sản phẩm - thuộc tính
CREATE TABLE sanpham_thuoctinh (
    sanpham_id BIGINT UNSIGNED NOT NULL,
    thuoctinh_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (sanpham_id, thuoctinh_id),
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (thuoctinh_id) REFERENCES thuoctinh(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Bảng biến thể sản phẩm (MỌI sản phẩm đều có ít nhất 1 biến thể)
CREATE TABLE bien_the (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    sku VARCHAR(100) NOT NULL UNIQUE,
    gia DECIMAL(13, 0) NOT NULL COMMENT 'Giá bán',
    gia_von DECIMAL(13, 0) NOT NULL COMMENT 'Giá vốn (dùng cho lợi nhuận)',
    so_luong_ton INT UNSIGNED NOT NULL DEFAULT 0,
    ngay_het_han TIMESTAMP NULL COMMENT 'Ngày hết hạn (nếu có)',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    INDEX idx_sanpham_id (sanpham_id),
    INDEX idx_sku (sku),
    INDEX idx_so_luong_ton (so_luong_ton)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Liên kết biến thể - giá trị thuộc tính
CREATE TABLE bien_the_giatri (
    bien_the_id BIGINT UNSIGNED NOT NULL,
    giatri_thuoctinh_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (bien_the_id, giatri_thuoctinh_id),
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE CASCADE,
    FOREIGN KEY (giatri_thuoctinh_id) REFERENCES giatri_thuoctinh(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Bảng hình ảnh sản phẩm
CREATE TABLE anh_sanpham (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    bien_the_id BIGINT UNSIGNED NULL COMMENT 'NULL = ảnh chung; có = ảnh biến thể',
    duong_dan VARCHAR(255) NOT NULL,
    la_anh_chinh BOOLEAN NOT NULL DEFAULT 0,
    thu_tu INT UNSIGNED DEFAULT 0 COMMENT 'Thứ tự hiển thị',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE CASCADE,
    INDEX idx_sanpham_id (sanpham_id),
    INDEX idx_bien_the_id (bien_the_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 3: QUẢN LÝ NHÀ CUNG CẤP & TỒN KHO
-- ============================================================

-- 13. Bảng nhà cung cấp
CREATE TABLE nha_cung_cap (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(150) NOT NULL,
    sdt VARCHAR(20) NULL,
    email VARCHAR(150) NULL,
    dia_chi TEXT NULL,
    mo_ta TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Bảng phiếu nhập hàng
CREATE TABLE phieu_nhap (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nha_cung_cap_id BIGINT UNSIGNED NULL,
    ma_phieu VARCHAR(50) NOT NULL UNIQUE,
    ghi_chu TEXT NULL,
    tong_tien DECIMAL(13, 0) DEFAULT 0,
    nguoi_tao_id BIGINT UNSIGNED NULL COMMENT 'Admin tạo phiếu',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nha_cung_cap_id) REFERENCES nha_cung_cap(id) ON DELETE SET NULL,
    FOREIGN KEY (nguoi_tao_id) REFERENCES nguoi_dung(id) ON DELETE SET NULL,
    INDEX idx_ma_phieu (ma_phieu),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Chi tiết phiếu nhập
CREATE TABLE chitiet_phieu_nhap (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    phieu_nhap_id BIGINT UNSIGNED NOT NULL,
    bien_the_id BIGINT UNSIGNED NOT NULL,
    so_luong_nhap INT UNSIGNED NOT NULL,
    gia_von_nhap DECIMAL(13, 0) NOT NULL COMMENT 'Giá vốn tại thời điểm nhập',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (phieu_nhap_id) REFERENCES phieu_nhap(id) ON DELETE CASCADE,
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE CASCADE,
    INDEX idx_phieu_nhap_id (phieu_nhap_id),
    INDEX idx_bien_the_id (bien_the_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Bảng cấu hình cảnh báo tồn kho
CREATE TABLE cau_hinh_ton_kho (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ngay_het_hang INT UNSIGNED NOT NULL DEFAULT 10 COMMENT 'Ngưỡng cảnh báo sắp hết hàng',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 4: QUẢN LÝ KHÁCH HÀNG & ĐỊA CHỈ
-- ============================================================

-- 17. Bảng địa chỉ giao hàng (Nhiều địa chỉ cho 1 user)
CREATE TABLE dia_chi_giao_hang (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    ten_nguoi_nhan VARCHAR(100) NOT NULL,
    sdt VARCHAR(20) NOT NULL,
    tinh_thanh VARCHAR(100) NOT NULL,
    quan_huyen VARCHAR(100) NOT NULL,
    phuong_xa VARCHAR(100) NOT NULL,
    dia_chi_chi_tiet TEXT NOT NULL,
    la_mac_dinh BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Địa chỉ mặc định',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_la_mac_dinh (la_mac_dinh)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 5: QUẢN LÝ ĐƠN HÀNG
-- ============================================================

-- 18. Bảng đơn hàng
CREATE TABLE donhang (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ma_don_hang VARCHAR(50) NOT NULL UNIQUE,
    nguoi_dung_id BIGINT UNSIGNED NULL COMMENT 'NULL = guest, có = customer',
    ten_khach VARCHAR(100) NOT NULL,
    sdt_khach VARCHAR(20) NOT NULL,
    email_khach VARCHAR(150) NULL,
    dia_chi_khach TEXT NOT NULL,
    phuong_thuc_thanh_toan ENUM('cod', 'online') NOT NULL DEFAULT 'cod' COMMENT 'COD hoặc thanh toán online',
    ma_giam_gia_id BIGINT UNSIGNED NULL COMMENT 'Mã giảm giá đã áp dụng',
    giam_gia DECIMAL(13, 0) DEFAULT 0 COMMENT 'Số tiền giảm từ voucher',
    tong_tien DECIMAL(13, 0) NOT NULL COMMENT 'Tổng tiền trước giảm',
    thanh_tien DECIMAL(13, 0) NOT NULL COMMENT 'Tổng tiền sau giảm',
    trang_thai ENUM('cho_xac_nhan', 'da_xac_nhan', 'dang_giao', 'hoan_thanh', 'da_huy') NOT NULL DEFAULT 'cho_xac_nhan',
    ghi_chu TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE SET NULL,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_ma_don_hang (ma_don_hang),
    INDEX idx_trang_thai (trang_thai),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 19. Chi tiết đơn hàng
CREATE TABLE chitiet_donhang (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donhang_id BIGINT UNSIGNED NOT NULL,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    bien_the_id BIGINT UNSIGNED NOT NULL COMMENT 'Bắt buộc (vì mọi SP đều có biến thể)',
    so_luong INT UNSIGNED NOT NULL,
    gia_luc_mua DECIMAL(13, 0) NOT NULL COMMENT 'Giá tại thời điểm mua',
    thanh_tien DECIMAL(13, 0) NOT NULL COMMENT 'Thành tiền = số lượng * giá',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donhang_id) REFERENCES donhang(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE RESTRICT,
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE RESTRICT,
    INDEX idx_donhang_id (donhang_id),
    INDEX idx_sanpham_id (sanpham_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 6: QUẢN LÝ KHUYẾN MÃI & VOUCHER
-- ============================================================

-- 20. Bảng mã giảm giá (Voucher/Coupon)
CREATE TABLE ma_giam_gia (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ma_voucher VARCHAR(50) NOT NULL UNIQUE,
    ten VARCHAR(150) NOT NULL,
    loai_giam_gia ENUM('percent', 'fixed') NOT NULL COMMENT 'Giảm theo % hoặc số tiền cố định',
    gia_tri_giam DECIMAL(13, 0) NOT NULL COMMENT 'Giá trị giảm (% hoặc số tiền)',
    don_toi_thieu DECIMAL(13, 0) DEFAULT 0 COMMENT 'Đơn tối thiểu để áp dụng',
    so_lan_su_dung_toi_da INT UNSIGNED NULL COMMENT 'NULL = không giới hạn',
    so_lan_da_su_dung INT UNSIGNED DEFAULT 0,
    ngay_bat_dau TIMESTAMP NULL,
    ngay_ket_thuc TIMESTAMP NULL,
    trang_thai ENUM('active', 'inactive', 'expired') NOT NULL DEFAULT 'active',
    mo_ta TEXT NULL,
    nguoi_tao_id BIGINT UNSIGNED NULL COMMENT 'Admin tạo voucher',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_tao_id) REFERENCES nguoi_dung(id) ON DELETE SET NULL,
    INDEX idx_ma_voucher (ma_voucher),
    INDEX idx_trang_thai (trang_thai),
    INDEX idx_ngay_ket_thuc (ngay_ket_thuc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 21. Bảng chương trình khuyến mãi
CREATE TABLE chuong_trinh_khuyen_mai (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(200) NOT NULL,
    mo_ta TEXT NULL,
    loai_khuyen_mai ENUM('mua_x_tang_y', 'giam_phan_tram', 'giam_tien_co_dinh', 'mua_x_giam_y') NOT NULL,
    dieu_kien JSON NOT NULL COMMENT 'Điều kiện khuyến mãi (JSON)',
    gia_tri_khuyen_mai DECIMAL(13, 0) NOT NULL,
    ngay_bat_dau TIMESTAMP NULL,
    ngay_ket_thuc TIMESTAMP NULL,
    trang_thai ENUM('active', 'inactive', 'expired') NOT NULL DEFAULT 'active',
    nguoi_tao_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_tao_id) REFERENCES nguoi_dung(id) ON DELETE SET NULL,
    INDEX idx_trang_thai (trang_thai),
    INDEX idx_ngay_ket_thuc (ngay_ket_thuc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 22. Liên kết chương trình khuyến mãi với sản phẩm/danh mục
CREATE TABLE khuyen_mai_sanpham (
    chuong_trinh_id BIGINT UNSIGNED NOT NULL,
    sanpham_id BIGINT UNSIGNED NULL,
    danhmuc_id BIGINT UNSIGNED NULL,
    PRIMARY KEY (chuong_trinh_id, sanpham_id, danhmuc_id),
    FOREIGN KEY (chuong_trinh_id) REFERENCES chuong_trinh_khuyen_mai(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (danhmuc_id) REFERENCES danhmuc(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 7: ĐÁNH GIÁ & BÌNH LUẬN
-- ============================================================

-- 23. Bảng đánh giá sản phẩm
CREATE TABLE danh_gia (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    donhang_id BIGINT UNSIGNED NULL COMMENT 'Đơn hàng đã mua (để xác minh)',
    so_sao TINYINT UNSIGNED NOT NULL CHECK (so_sao >= 1 AND so_sao <= 5),
    noi_dung TEXT NULL,
    trang_thai ENUM('pending', 'approved', 'hidden', 'rejected') NOT NULL DEFAULT 'pending' COMMENT 'Chờ duyệt, Đã duyệt, Ẩn, Từ chối',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (donhang_id) REFERENCES donhang(id) ON DELETE SET NULL,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_sanpham_id (sanpham_id),
    INDEX idx_trang_thai (trang_thai),
    INDEX idx_so_sao (so_sao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 24. Bảng hình ảnh đánh giá
CREATE TABLE anh_danh_gia (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    danh_gia_id BIGINT UNSIGNED NOT NULL,
    duong_dan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (danh_gia_id) REFERENCES danh_gia(id) ON DELETE CASCADE,
    INDEX idx_danh_gia_id (danh_gia_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 25. Bảng bình luận dưới đánh giá
CREATE TABLE binh_luan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    danh_gia_id BIGINT UNSIGNED NOT NULL,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    noi_dung TEXT NOT NULL,
    binh_luan_cha_id BIGINT UNSIGNED NULL COMMENT 'Bình luận cha (để reply)',
    trang_thai ENUM('pending', 'approved', 'hidden', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (danh_gia_id) REFERENCES danh_gia(id) ON DELETE CASCADE,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (binh_luan_cha_id) REFERENCES binh_luan(id) ON DELETE CASCADE,
    INDEX idx_danh_gia_id (danh_gia_id),
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_binh_luan_cha_id (binh_luan_cha_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 8: QUẢN LÝ BẢO HÀNH
-- ============================================================

-- 26. Bảng yêu cầu bảo hành
CREATE TABLE yeu_cau_bao_hanh (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    donhang_id BIGINT UNSIGNED NULL COMMENT 'Đơn hàng đã mua',
    bien_the_id BIGINT UNSIGNED NOT NULL COMMENT 'Biến thể sản phẩm cần bảo hành',
    ma_yeu_cau VARCHAR(50) NOT NULL UNIQUE,
    mo_ta_loi TEXT NOT NULL COMMENT 'Mô tả lỗi',
    hinh_thuc_bao_hanh ENUM('sua_chua', 'thay_the', 'doi_moi') NOT NULL COMMENT 'Sửa chữa, Thay thế, Đổi mới',
    trang_thai ENUM('cho_tiep_nhan', 'dang_xu_ly', 'hoan_tat', 'tu_choi') NOT NULL DEFAULT 'cho_tiep_nhan',
    ghi_chu_noi_bo TEXT NULL COMMENT 'Ghi chú nội bộ của admin',
    phieu_bao_hanh_chinh_hang VARCHAR(100) NULL COMMENT 'Số phiếu bảo hành chính hãng',
    ngay_tiep_nhan TIMESTAMP NULL,
    ngay_hoan_thanh TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (donhang_id) REFERENCES donhang(id) ON DELETE SET NULL,
    FOREIGN KEY (bien_the_id) REFERENCES bien_the(id) ON DELETE RESTRICT,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_ma_yeu_cau (ma_yeu_cau),
    INDEX idx_trang_thai (trang_thai)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 27. Bảng hình ảnh yêu cầu bảo hành
CREATE TABLE anh_bao_hanh (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    yeu_cau_id BIGINT UNSIGNED NOT NULL,
    duong_dan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (yeu_cau_id) REFERENCES yeu_cau_bao_hanh(id) ON DELETE CASCADE,
    INDEX idx_yeu_cau_id (yeu_cau_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 9: WISHLIST & SO SÁNH SẢN PHẨM
-- ============================================================

-- 28. Bảng danh sách yêu thích (Wishlist)
CREATE TABLE danh_sach_yeu_thich (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (nguoi_dung_id, sanpham_id),
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_sanpham_id (sanpham_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 29. Bảng so sánh sản phẩm (Lưu trong tài khoản)
CREATE TABLE so_sanh_sanpham (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NOT NULL,
    sanpham_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    UNIQUE KEY unique_compare (nguoi_dung_id, sanpham_id),
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_sanpham_id (sanpham_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 10: LỊCH SỬ XEM & GỢI Ý
-- ============================================================

-- 30. Bảng lịch sử xem sản phẩm (Để gợi ý "Sản phẩm bạn vừa xem")
CREATE TABLE lich_su_xem (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NULL COMMENT 'NULL = guest (session), có = customer',
    session_id VARCHAR(100) NULL COMMENT 'Session ID cho guest',
    sanpham_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (sanpham_id) REFERENCES sanpham(id) ON DELETE CASCADE,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_session_id (session_id),
    INDEX idx_sanpham_id (sanpham_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 11: THÔNG BÁO & EMAIL
-- ============================================================

-- 31. Bảng thông báo hệ thống
CREATE TABLE thong_bao (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id BIGINT UNSIGNED NULL COMMENT 'NULL = thông báo cho tất cả',
    loai ENUM('don_hang', 'danh_gia', 'bao_hanh', 'khuyen_mai', 'he_thong') NOT NULL,
    tieu_de VARCHAR(200) NOT NULL,
    noi_dung TEXT NOT NULL,
    lien_ket VARCHAR(255) NULL,
    da_doc BOOLEAN NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    INDEX idx_nguoi_dung_id (nguoi_dung_id),
    INDEX idx_da_doc (da_doc),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PHẦN 12: DỮ LIỆU MẪU
-- ============================================================

-- Thêm foreign key cho ma_giam_gia trong donhang (sau khi tạo bảng ma_giam_gia)
ALTER TABLE donhang ADD FOREIGN KEY (ma_giam_gia_id) REFERENCES ma_giam_gia(id) ON DELETE SET NULL;

-- Chèn dữ liệu mẫu

-- 1. Tạo tài khoản Admin
INSERT INTO nguoi_dung (ten, email, mat_khau, vai_tro, trang_thai) VALUES
('Admin', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active');
-- Password: admin123

-- 2. Tạo tài khoản Customer mẫu
INSERT INTO nguoi_dung (ten, email, mat_khau, sdt, vai_tro, trang_thai) VALUES
('Nguyễn Văn A', 'customer@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0909123456', 'customer', 'active');
-- Password: customer123

-- 3. Thương hiệu
INSERT INTO thuong_hieu (ten, mo_ta) VALUES
('Apple', 'Thương hiệu công nghệ hàng đầu'),
('Samsung', 'Thương hiệu điện tử Hàn Quốc'),
('Xiaomi', 'Thương hiệu công nghệ Trung Quốc'),
('Dell', 'Thương hiệu laptop'),
('HP', 'Thương hiệu máy tính');

-- 4. Danh mục
INSERT INTO danhmuc (ten, id_cha, slug, thu_tu, hien_thi) VALUES
('Điện Thoại', NULL, 'dien-thoai', 1, 1),
('Laptop', NULL, 'laptop', 2, 1),
('Máy Tính Bảng', NULL, 'may-tinh-bang', 3, 1),
('Phụ Kiện', NULL, 'phu-kien', 4, 1);

-- 5. Thuộc tính
INSERT INTO thuoctinh (ten, mo_ta) VALUES
('Màu sắc', 'Màu sắc sản phẩm'),
('Dung lượng lưu trữ', 'Dung lượng bộ nhớ'),
('RAM', 'Bộ nhớ RAM'),
('Kích thước màn hình', 'Kích thước màn hình (inch)');

-- 6. Giá trị thuộc tính
INSERT INTO giatri_thuoctinh (thuoctinh_id, giatri) VALUES
(1, 'Xanh Thiên Thạch'), (1, 'Đen'), (1, 'Trắng'), (1, 'Vàng'),
(2, '128GB'), (2, '256GB'), (2, '512GB'), (2, '1TB'),
(3, '4GB'), (3, '8GB'), (3, '16GB'), (3, '32GB'),
(4, '6.1 inch'), (4, '6.7 inch'), (4, '13.3 inch'), (4, '15.6 inch');

-- 7. Sản phẩm mẫu
INSERT INTO sanpham (ten, slug, danhmuc_id, thuong_hieu_id, mo_ta_ngan, mo_ta_chi_tiet, trang_thai) VALUES
('iPhone 15 Pro Max', 'iphone-15-pro-max', 1, 1, 'iPhone cao cấp 2023', 'iPhone 15 Pro Max với chip A17 Pro, camera 48MP, màn hình Super Retina XDR 6.7 inch', 'active'),
('MacBook Pro 14 inch', 'macbook-pro-14', 2, 1, 'Laptop chuyên nghiệp', 'MacBook Pro 14 inch với chip M3, màn hình Liquid Retina XDR', 'active'),
('Ốp lưng iPhone 15 Pro Max', 'op-lung-iphone-15-pro-max', 4, NULL, 'Ốp silicone cao cấp', 'Ốp lưng silicone chính hãng Apple cho iPhone 15 Pro Max', 'active');

-- 8. Thông số kỹ thuật
INSERT INTO thong_so_ky_thuat (sanpham_id, ten_thong_so, gia_tri, thu_tu) VALUES
(1, 'Chip', 'A17 Pro', 1),
(1, 'Camera chính', '48MP', 2),
(1, 'Camera trước', '12MP TrueDepth', 3),
(1, 'Pin', '4422 mAh', 4),
(1, 'Hệ điều hành', 'iOS 17', 5),
(2, 'Chip', 'Apple M3', 1),
(2, 'RAM', '18GB', 2),
(2, 'Ổ cứng', '512GB SSD', 3),
(2, 'Màn hình', '14.2 inch Liquid Retina XDR', 4);

-- 9. Gắn thuộc tính cho sản phẩm
INSERT INTO sanpham_thuoctinh (sanpham_id, thuoctinh_id) VALUES
(1, 1), (1, 2), (1, 4), -- iPhone: màu, dung lượng, kích thước màn hình
(2, 3), (2, 2), (2, 4); -- MacBook: RAM, dung lượng, kích thước màn hình

-- 10. Biến thể sản phẩm
INSERT INTO bien_the (sanpham_id, sku, gia, gia_von, so_luong_ton) VALUES
(1, 'IP15PM-XANH-128', 29990000, 25000000, 10),
(1, 'IP15PM-XANH-256', 32990000, 27000000, 8),
(1, 'IP15PM-DEN-128', 29990000, 25000000, 5),
(2, 'MBP14-M3-512', 45990000, 40000000, 5),
(3, 'OP15PM-001', 250000, 120000, 50);

-- 11. Gắn giá trị thuộc tính cho biến thể
INSERT INTO bien_the_giatri (bien_the_id, giatri_thuoctinh_id) VALUES
(1, 1), (1, 5), -- Xanh + 128GB
(2, 1), (2, 6), -- Xanh + 256GB
(3, 2), (3, 5), -- Đen + 128GB
(4, 11), (4, 6), (4, 13); -- MacBook: 8GB RAM, 256GB, 13.3 inch

-- 12. Hình ảnh sản phẩm
INSERT INTO anh_sanpham (sanpham_id, bien_the_id, duong_dan, la_anh_chinh, thu_tu) VALUES
(1, NULL, 'images/iphone15pm/main.jpg', 1, 1),
(1, 1, 'images/iphone15pm/xanh-128.jpg', 1, 1),
(1, 2, 'images/iphone15pm/xanh-256.jpg', 1, 1),
(1, 3, 'images/iphone15pm/den-128.jpg', 1, 1),
(2, NULL, 'images/macbook/mbp14.jpg', 1, 1),
(3, 5, 'images/phukien/op15pm.jpg', 1, 1);

-- 13. Nhà cung cấp
INSERT INTO nha_cung_cap (ten, sdt, email, dia_chi) VALUES
('Công ty ABC', '0909123456', 'contact@abc.com', 'Hà Nội'),
('Công ty XYZ', '0909987654', 'contact@xyz.com', 'TP.HCM');

-- 14. Cấu hình tồn kho
INSERT INTO cau_hinh_ton_kho (ngay_het_hang) VALUES (10);

-- 15. Mã giảm giá mẫu
INSERT INTO ma_giam_gia (ma_voucher, ten, loai_giam_gia, gia_tri_giam, don_toi_thieu, so_lan_su_dung_toi_da, ngay_bat_dau, ngay_ket_thuc, trang_thai, nguoi_tao_id) VALUES
('GIAM10', 'Giảm 10%', 'percent', 10, 1000000, 100, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active', 1),
('GIAM50K', 'Giảm 50.000đ', 'fixed', 50000, 500000, 50, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY), 'active', 1);

