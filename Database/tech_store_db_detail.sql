-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 01:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tech_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `anh_bao_hanh`
--

CREATE TABLE `anh_bao_hanh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `yeu_cau_id` bigint(20) UNSIGNED NOT NULL,
  `duong_dan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anh_danh_gia`
--

CREATE TABLE `anh_danh_gia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `danh_gia_id` bigint(20) UNSIGNED NOT NULL,
  `duong_dan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anh_sanpham`
--

CREATE TABLE `anh_sanpham` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `bien_the_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'NULL = ảnh chung; có = ảnh biến thể',
  `duong_dan` varchar(255) NOT NULL,
  `la_anh_chinh` tinyint(1) NOT NULL DEFAULT 0,
  `thu_tu` int(10) UNSIGNED DEFAULT 0 COMMENT 'Thứ tự hiển thị',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anh_sanpham`
--

INSERT INTO `anh_sanpham` (`id`, `sanpham_id`, `bien_the_id`, `duong_dan`, `la_anh_chinh`, `thu_tu`, `created_at`) VALUES
(9, 5, 7, 'products/qFVwFps4lZYbrXsXx7qNvCMzjytfaq0Sp7H6pKlr.png', 1, 0, '2026-01-12 05:06:35'),
(10, 5, 8, 'products/zRyCctWGS7VKzOcZQHjeQRDt1C2TyK0EzZnMLGwL.png', 0, 0, '2026-01-12 05:06:35'),
(11, 5, 9, 'products/lHZMSkvmtrUqXcrv6Ir4aSFSjosSwMZok0siYl7V.png', 0, 0, '2026-01-12 05:06:35'),
(12, 5, NULL, 'products/OzKT9619i5vRghFEwcr5oK6fegnTJsd2fPLFd2P5.png', 1, 0, '2026-01-12 05:06:35'),
(13, 9, 13, 'products/GLqogn8p2bBRedNVN7a6xUZmDk9jmsPVM1WIL73f.png', 1, 0, '2026-01-12 05:12:28'),
(14, 9, NULL, 'products/VT1buxDMxeM7WiqjmSIXAlPzLd0x559Snnc0fyUf.png', 1, 0, '2026-01-12 05:12:28'),
(17, 10, NULL, 'products/tYHyxVL6Tj8Al2W4LNvd6P9Qvjal7b88kON0Oz8D.jpg', 1, 0, '2026-01-12 05:16:36'),
(18, 11, 16, 'products/smWlgO1OVFbr0649DANV2BYGF9iCnBd25ZM5czAf.png', 1, 0, '2026-01-12 05:30:30'),
(19, 11, 17, 'products/HrVFrQVPtliGznKUCxjG2KQz7RwLEGK5cHygkXe3.png', 0, 0, '2026-01-12 05:30:30'),
(20, 11, NULL, 'products/T8L94PlT8ksoCYxKsNggPaFsKrExPswVtx9vjYoJ.png', 1, 0, '2026-01-12 05:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `bien_the`
--

CREATE TABLE `bien_the` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(100) NOT NULL,
  `gia` decimal(13,0) NOT NULL COMMENT 'Giá bán',
  `gia_von` decimal(13,0) NOT NULL COMMENT 'Giá vốn (dùng cho lợi nhuận)',
  `so_luong_ton` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ngay_het_han` timestamp NULL DEFAULT NULL COMMENT 'Ngày hết hạn (nếu có)',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bien_the`
--

INSERT INTO `bien_the` (`id`, `sanpham_id`, `sku`, `gia`, `gia_von`, `so_luong_ton`, `ngay_het_han`, `created_at`, `updated_at`) VALUES
(6, 4, '123', 5000000, 4000000, 6, NULL, '2026-01-12 03:47:44', '2026-01-12 04:51:34'),
(7, 5, '1', 12000000, 11000000, 50, NULL, '2026-01-12 05:06:35', '2026-01-12 05:06:35'),
(8, 5, '2', 15000000, 14000000, 12, NULL, '2026-01-12 05:06:35', '2026-01-12 05:06:35'),
(9, 5, '3', 16000000, 15000000, 22, NULL, '2026-01-12 05:06:35', '2026-01-12 05:06:35'),
(13, 9, '3-8FPP', 12000000, 11000000, 33, NULL, '2026-01-12 05:12:28', '2026-01-12 05:12:28'),
(14, 10, '12', 35000000, 30000000, 32, NULL, '2026-01-12 05:16:36', '2026-01-12 05:16:36'),
(15, 10, '1234', 30000000, 29000000, 23, NULL, '2026-01-12 05:16:36', '2026-01-12 05:16:36'),
(16, 11, '123-IXVK', 8000000, 7000000, 12, NULL, '2026-01-12 05:30:30', '2026-01-12 05:30:30'),
(17, 11, '1234-EZA2', 9000000, 8000000, 33, NULL, '2026-01-12 05:30:30', '2026-01-12 05:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `bien_the_giatri`
--

CREATE TABLE `bien_the_giatri` (
  `bien_the_id` bigint(20) UNSIGNED NOT NULL,
  `giatri_thuoctinh_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bien_the_giatri`
--

INSERT INTO `bien_the_giatri` (`bien_the_id`, `giatri_thuoctinh_id`) VALUES
(6, 2),
(6, 5),
(6, 9),
(6, 13),
(7, 4),
(7, 7),
(7, 9),
(7, 13),
(8, 2),
(8, 5),
(8, 11),
(8, 14),
(9, 3),
(9, 7),
(9, 11),
(9, 14),
(13, 2),
(13, 5),
(13, 9),
(13, 14),
(14, 2),
(14, 5),
(14, 10),
(14, 15),
(15, 3),
(15, 5),
(15, 10),
(15, 13),
(16, 3),
(16, 5),
(16, 9),
(16, 15),
(17, 2),
(17, 5),
(17, 11),
(17, 15);

-- --------------------------------------------------------

--
-- Table structure for table `binh_luan`
--

CREATE TABLE `binh_luan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `danh_gia_id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `noi_dung` text NOT NULL,
  `binh_luan_cha_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Bình luận cha (để reply)',
  `trang_thai` enum('pending','approved','hidden','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cau_hinh_ton_kho`
--

CREATE TABLE `cau_hinh_ton_kho` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ngay_het_hang` int(10) UNSIGNED NOT NULL DEFAULT 10 COMMENT 'Ngưỡng cảnh báo sắp hết hàng',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cau_hinh_ton_kho`
--

INSERT INTO `cau_hinh_ton_kho` (`id`, `ngay_het_hang`, `created_at`, `updated_at`) VALUES
(1, 10, '2025-12-19 08:55:13', '2025-12-19 08:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_donhang`
--

CREATE TABLE `chitiet_donhang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `donhang_id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `bien_the_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Bắt buộc (vì mọi SP đều có biến thể)',
  `so_luong` int(10) UNSIGNED NOT NULL,
  `gia_luc_mua` decimal(13,0) NOT NULL COMMENT 'Giá tại thời điểm mua',
  `thanh_tien` decimal(13,0) NOT NULL COMMENT 'Thành tiền = số lượng * giá',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitiet_donhang`
--

INSERT INTO `chitiet_donhang` (`id`, `donhang_id`, `sanpham_id`, `bien_the_id`, `so_luong`, `gia_luc_mua`, `thanh_tien`, `created_at`) VALUES
(1, 1, 4, 6, 1, 5000000, 5000000, '2026-01-12 11:11:01'),
(2, 2, 4, 6, 1, 5000000, 5000000, '2026-01-12 11:42:31'),
(3, 3, 4, 6, 1, 5000000, 5000000, '2026-01-12 11:51:09'),
(4, 4, 4, 6, 1, 5000000, 5000000, '2026-01-12 11:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieu_nhap`
--

CREATE TABLE `chitiet_phieu_nhap` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phieu_nhap_id` bigint(20) UNSIGNED NOT NULL,
  `bien_the_id` bigint(20) UNSIGNED NOT NULL,
  `so_luong_nhap` int(10) UNSIGNED NOT NULL,
  `gia_von_nhap` decimal(13,0) NOT NULL COMMENT 'Giá vốn tại thời điểm nhập',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chuong_trinh_khuyen_mai`
--

CREATE TABLE `chuong_trinh_khuyen_mai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(200) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `loai_khuyen_mai` enum('mua_x_tang_y','giam_phan_tram','giam_tien_co_dinh','mua_x_giam_y') NOT NULL,
  `dieu_kien` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Điều kiện khuyến mãi (JSON)' CHECK (json_valid(`dieu_kien`)),
  `gia_tri_khuyen_mai` decimal(13,0) NOT NULL,
  `ngay_bat_dau` timestamp NULL DEFAULT NULL,
  `ngay_ket_thuc` timestamp NULL DEFAULT NULL,
  `trang_thai` enum('active','inactive','expired') NOT NULL DEFAULT 'active',
  `nguoi_tao_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `id_cha` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Danh mục cha (NULL = danh mục gốc)',
  `mo_ta` text DEFAULT NULL,
  `slug` varchar(150) NOT NULL,
  `thu_tu` int(10) UNSIGNED DEFAULT 0 COMMENT 'Thứ tự hiển thị',
  `hien_thi` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `ten`, `id_cha`, `mo_ta`, `slug`, `thu_tu`, `hien_thi`, `created_at`, `updated_at`) VALUES
(1, 'Điện Thoại', NULL, NULL, 'dien-thoai', 1, 1, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(2, 'Laptop', NULL, NULL, 'laptop', 2, 1, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(3, 'Máy Tính Bảng', NULL, NULL, 'may-tinh-bang', 3, 1, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(4, 'Phụ Kiện', NULL, NULL, 'phu-kien', 4, 1, '2025-12-19 08:55:12', '2025-12-19 08:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `donhang_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Đơn hàng đã mua (để xác minh)',
  `so_sao` tinyint(3) UNSIGNED NOT NULL CHECK (`so_sao` >= 1 and `so_sao` <= 5),
  `noi_dung` text DEFAULT NULL,
  `trang_thai` enum('pending','approved','hidden','rejected') NOT NULL DEFAULT 'pending' COMMENT 'Chờ duyệt, Đã duyệt, Ẩn, Từ chối',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_sach_yeu_thich`
--

CREATE TABLE `danh_sach_yeu_thich` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dia_chi_giao_hang`
--

CREATE TABLE `dia_chi_giao_hang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `ten_nguoi_nhan` varchar(100) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `tinh_thanh` varchar(100) NOT NULL,
  `quan_huyen` varchar(100) NOT NULL,
  `phuong_xa` varchar(100) NOT NULL,
  `dia_chi_chi_tiet` text NOT NULL,
  `la_mac_dinh` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Địa chỉ mặc định',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ma_don_hang` varchar(50) NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'NULL = guest, có = customer',
  `ten_khach` varchar(100) NOT NULL,
  `sdt_khach` varchar(20) NOT NULL,
  `email_khach` varchar(150) DEFAULT NULL,
  `dia_chi_khach` text NOT NULL,
  `phuong_thuc_thanh_toan` enum('cod','online') NOT NULL DEFAULT 'cod' COMMENT 'COD hoặc thanh toán online',
  `ma_giam_gia_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Mã giảm giá đã áp dụng',
  `giam_gia` decimal(13,0) DEFAULT 0 COMMENT 'Số tiền giảm từ voucher',
  `tong_tien` decimal(13,0) NOT NULL COMMENT 'Tổng tiền trước giảm',
  `thanh_tien` decimal(13,0) NOT NULL COMMENT 'Tổng tiền sau giảm',
  `trang_thai` enum('cho_xac_nhan','da_xac_nhan','dang_giao','hoan_thanh','da_huy') NOT NULL DEFAULT 'cho_xac_nhan',
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`id`, `ma_don_hang`, `nguoi_dung_id`, `ten_khach`, `sdt_khach`, `email_khach`, `dia_chi_khach`, `phuong_thuc_thanh_toan`, `ma_giam_gia_id`, `giam_gia`, `tong_tien`, `thanh_tien`, `trang_thai`, `ghi_chu`, `created_at`, `updated_at`) VALUES
(1, 'DH202601128325', NULL, 'Admin', '09710102891', 'admin@gmail.com', 'ádasd', 'cod', NULL, 0, 5000000, 5000000, 'da_huy', 'áda', '2026-01-12 04:11:01', '2026-01-12 04:43:26'),
(2, 'DH202601126101', NULL, 'Nhật Minh', '09710102891', 'minh@gmail.com', '123 Test', 'cod', NULL, 0, 5000000, 5000000, 'da_xac_nhan', 'Đóng gói cẩn thận cho tôi nhé', '2026-01-12 04:42:31', '2026-01-12 04:42:57'),
(3, 'DH202601125867', 4, 'Văn A', '09710102891', 'a@gmail.com', '123 Test', 'cod', NULL, 0, 5000000, 5000000, 'cho_xac_nhan', 'Đóng gói cẩn thận nha shop', '2026-01-12 04:51:09', '2026-01-12 04:51:09'),
(4, 'DH202601122546', 4, 'Văn A', '09710102891', 'a@gmail.com', 'sadasd 234', 'cod', NULL, 0, 5000000, 5000000, 'dang_giao', 'tests 1', '2026-01-12 04:51:34', '2026-01-12 04:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `giatri_thuoctinh`
--

CREATE TABLE `giatri_thuoctinh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thuoctinh_id` bigint(20) UNSIGNED NOT NULL,
  `giatri` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `giatri_thuoctinh`
--

INSERT INTO `giatri_thuoctinh` (`id`, `thuoctinh_id`, `giatri`, `created_at`) VALUES
(1, 1, 'Xanh Thiên Thạch', '2025-12-19 08:55:12'),
(2, 1, 'Đen', '2025-12-19 08:55:12'),
(3, 1, 'Trắng', '2025-12-19 08:55:12'),
(4, 1, 'Vàng', '2025-12-19 08:55:12'),
(5, 2, '128GB', '2025-12-19 08:55:12'),
(6, 2, '256GB', '2025-12-19 08:55:12'),
(7, 2, '512GB', '2025-12-19 08:55:12'),
(8, 2, '1TB', '2025-12-19 08:55:12'),
(9, 3, '4GB', '2025-12-19 08:55:12'),
(10, 3, '8GB', '2025-12-19 08:55:12'),
(11, 3, '16GB', '2025-12-19 08:55:12'),
(12, 3, '32GB', '2025-12-19 08:55:12'),
(13, 4, '6.1 inch', '2025-12-19 08:55:12'),
(14, 4, '6.7 inch', '2025-12-19 08:55:12'),
(15, 4, '13.3 inch', '2025-12-19 08:55:12'),
(16, 4, '15.6 inch', '2025-12-19 08:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `khuyen_mai_sanpham`
--

CREATE TABLE `khuyen_mai_sanpham` (
  `chuong_trinh_id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `danhmuc_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lich_su_xem`
--

CREATE TABLE `lich_su_xem` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'NULL = guest (session), có = customer',
  `session_id` varchar(100) DEFAULT NULL COMMENT 'Session ID cho guest',
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ma_giam_gia`
--

CREATE TABLE `ma_giam_gia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ma_voucher` varchar(50) NOT NULL,
  `ten` varchar(150) NOT NULL,
  `loai_giam_gia` enum('percent','fixed') NOT NULL COMMENT 'Giảm theo % hoặc số tiền cố định',
  `gia_tri_giam` decimal(13,0) NOT NULL COMMENT 'Giá trị giảm (% hoặc số tiền)',
  `don_toi_thieu` decimal(13,0) DEFAULT 0 COMMENT 'Đơn tối thiểu để áp dụng',
  `so_lan_su_dung_toi_da` int(10) UNSIGNED DEFAULT NULL COMMENT 'NULL = không giới hạn',
  `so_lan_da_su_dung` int(10) UNSIGNED DEFAULT 0,
  `ngay_bat_dau` timestamp NULL DEFAULT NULL,
  `ngay_ket_thuc` timestamp NULL DEFAULT NULL,
  `trang_thai` enum('active','inactive','expired') NOT NULL DEFAULT 'active',
  `mo_ta` text DEFAULT NULL,
  `nguoi_tao_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Admin tạo voucher',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ma_giam_gia`
--

INSERT INTO `ma_giam_gia` (`id`, `ma_voucher`, `ten`, `loai_giam_gia`, `gia_tri_giam`, `don_toi_thieu`, `so_lan_su_dung_toi_da`, `so_lan_da_su_dung`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`, `mo_ta`, `nguoi_tao_id`, `created_at`, `updated_at`) VALUES
(1, 'GIAM10', 'Giảm 10%', 'percent', 10, 1000000, 100, 0, '2025-12-19 08:55:13', '2026-01-18 08:55:13', 'active', NULL, 1, '2025-12-19 08:55:13', '2026-01-12 02:18:13'),
(2, 'GIAM50K', 'Giảm 50.000đ', 'fixed', 50000, 500000, 50, 0, '2025-12-19 08:55:13', '2026-01-03 08:55:13', 'active', NULL, 1, '2025-12-19 08:55:13', '2025-12-19 02:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `email_da_xac_thuc_at` timestamp NULL DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `vai_tro` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `trang_thai` enum('active','locked') NOT NULL DEFAULT 'active',
  `token_ghi_nho` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ten`, `email`, `email_da_xac_thuc_at`, `mat_khau`, `sdt`, `vai_tro`, `trang_thai`, `token_ghi_nho`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$GiOzk6TUzs7qvqMn.0DKb.WeA2KDuCpXC0YP5nFBqenWAs7kGWfPK', NULL, 'admin', 'active', NULL, '2025-12-19 08:55:12', '2026-01-12 09:05:14'),
(2, 'Nguyễn Văn A', 'customer@gmail.com', NULL, '$2y$10$WBfE/VgqGwft5KhGbqzkr.LVDTyl/PcXyF0kC4K2tn4X2BYJFmaHy', '0909123456', 'customer', 'active', NULL, '2025-12-19 08:55:12', '2025-12-19 09:02:35'),
(3, 'Nhật Minh', 'minh@gmail.com', NULL, '$2y$12$2sf5C72QzlMmAoTJ7YhxDepCLzqxLuSIzKC1QT5VrvZh.VWF.uoRC', NULL, 'customer', 'active', NULL, '2026-01-12 04:33:19', '2026-01-12 04:33:19'),
(4, 'Văn A', 'a@gmail.com', NULL, '$2y$12$qGWsXLuwi7LutXZStFgpteQeW2vCrQb2pxQ3srzslLiJWd6/ewzLm', '09710102891', 'customer', 'active', NULL, '2026-01-12 04:47:15', '2026-01-12 04:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `nhat_ky_hoat_dong`
--

CREATE TABLE `nhat_ky_hoat_dong` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `hanh_dong` varchar(50) NOT NULL COMMENT 'create, update, delete',
  `loai_model` varchar(100) NOT NULL COMMENT 'Tên model/table',
  `id_model` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID của record bị thay đổi',
  `mo_ta` text DEFAULT NULL COMMENT 'Mô tả chi tiết',
  `gia_tri_cu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Giá trị cũ (JSON)' CHECK (json_valid(`gia_tri_cu`)),
  `gia_tri_moi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Giá trị mới (JSON)' CHECK (json_valid(`gia_tri_moi`)),
  `dia_chi_ip` varchar(45) DEFAULT NULL,
  `trinh_duyet` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhat_ky_hoat_dong`
--

INSERT INTO `nhat_ky_hoat_dong` (`id`, `nguoi_dung_id`, `hanh_dong`, `loai_model`, `id_model`, `mo_ta`, `gia_tri_cu`, `gia_tri_moi`, `dia_chi_ip`, `trinh_duyet`, `created_at`) VALUES
(1, 1, 'update', 'ma_giam_gia', 2, 'Đổi trạng thái mã giảm giá: GIAM50K', '{\"trang_thai\":\"active\"}', '{\"trang_thai\":\"inactive\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-19 09:10:19'),
(2, 1, 'update', 'ma_giam_gia', 2, 'Đổi trạng thái mã giảm giá: GIAM50K', '{\"trang_thai\":\"inactive\"}', '{\"trang_thai\":\"active\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-19 09:10:21'),
(3, 1, 'create', 'thuong_hieu', 6, 'Thêm thương hiệu: HTC', NULL, '{\"ten\":\"HTC\",\"mo_ta\":\"\\u0110i\\u1ec7n tho\\u1ea1i HTC\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-12 09:14:58'),
(4, 1, 'update', 'thuong_hieu', 6, 'Cập nhật thương hiệu: HTC', '{\"id\":6,\"ten\":\"HTC\",\"mo_ta\":\"\\u0110i\\u1ec7n tho\\u1ea1i HTC\",\"hinh_logo\":null,\"created_at\":\"2026-01-12T09:14:58.000000Z\",\"updated_at\":\"2026-01-12T09:14:58.000000Z\"}', '{\"ten\":\"HTC\",\"mo_ta\":\"\\u0110i\\u1ec7n tho\\u1ea1i HTC\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-12 09:15:10'),
(5, 1, 'delete', 'thuong_hieu', 6, 'Xóa thương hiệu: HTC', '{\"id\":6,\"ten\":\"HTC\",\"mo_ta\":\"\\u0110i\\u1ec7n tho\\u1ea1i HTC\",\"hinh_logo\":null,\"created_at\":\"2026-01-12T09:14:58.000000Z\",\"updated_at\":\"2026-01-12T09:14:58.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-12 09:15:13'),
(6, 1, 'update', 'ma_giam_gia', 1, 'Đổi trạng thái mã giảm giá: GIAM10', '{\"trang_thai\":\"active\"}', '{\"trang_thai\":\"inactive\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-12 09:18:05'),
(7, 1, 'update', 'ma_giam_gia', 1, 'Đổi trạng thái mã giảm giá: GIAM10', '{\"trang_thai\":\"inactive\"}', '{\"trang_thai\":\"active\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-12 09:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(150) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id`, `ten`, `sdt`, `email`, `dia_chi`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Thế Giới Di Động', '0909123456', 'contact@tgdd.com', 'Hà Nội', NULL, '2025-12-19 08:55:13', '2026-01-12 09:31:05'),
(2, 'Công ty Nokia-VN', '0909987654', 'contact@nokia.com', 'TP.HCM', NULL, '2025-12-19 08:55:13', '2026-01-12 09:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nha_cung_cap_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ma_phieu` varchar(50) NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `tong_tien` decimal(13,0) DEFAULT 0,
  `nguoi_tao_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Admin tạo phiếu',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `danhmuc_id` bigint(20) UNSIGNED NOT NULL,
  `thuong_hieu_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Thương hiệu',
  `mo_ta_ngan` text DEFAULT NULL COMMENT 'Mô tả ngắn',
  `mo_ta_chi_tiet` longtext DEFAULT NULL COMMENT 'Mô tả chi tiết',
  `trang_thai` enum('draft','active','inactive') NOT NULL DEFAULT 'draft' COMMENT 'Nháp, Hiển thị, Ẩn',
  `luot_xem` int(10) UNSIGNED DEFAULT 0,
  `luot_ban` int(10) UNSIGNED DEFAULT 0 COMMENT 'Số lượng đã bán',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `ten`, `slug`, `danhmuc_id`, `thuong_hieu_id`, `mo_ta_ngan`, `mo_ta_chi_tiet`, `trang_thai`, `luot_xem`, `luot_ban`, `created_at`, `updated_at`) VALUES
(4, 'Samsung Galaxy A17', 'samsung-galaxy-a17', 1, NULL, NULL, 'Hệ điều hành: Android 15\r\nChip xử lý (CPU): Exynos 1330\r\nTốc độ CPU: 2 nhân 2.4 GHz & 6 nhân 2 GHz\r\nChip đồ họa (GPU): Đang cập nhật\r\nRAM: 8 GB\r\nDung lượng lưu trữ: 128 GB\r\nDung lượng còn lại (khả dụng) khoảng: 107 GB\r\nThẻ nhớ: MicroSD, hỗ trợ tối đa 2 TB\r\nDanh bạ: Không giới hạn', 'draft', 0, 0, '2026-01-12 03:47:44', '2026-01-12 03:47:44'),
(5, 'OPPO Reno15 Pro', 'oppo-reno15-pro', 1, NULL, NULL, 'OPPO Reno 15F là smartphone dành cho người trẻ năng động, yêu công nghệ. Máy nổi bật với thiết kế bền bỉ chuẩn IP69, màn hình AMOLED 120 Hz sắc nét và camera AI linh hoạt, cho ảnh chân dung ấn tượng. Pin 7000 mAh kèm sạc nhanh 80W giúp dùng cả ngày không gián đoạn. Reno 15F mang đến trải nghiệm giải trí, làm việc và kết nối thuận tiện, hiện đại.', 'draft', 0, 0, '2026-01-12 05:06:35', '2026-01-12 05:06:35'),
(9, 'Xiaomi Redmi Note 15 Pro+', 'xiaomi-redmi-note-15-pro', 1, NULL, NULL, 'Giải mã Xiaomi Redmi Note 15 Series: 5 phiên bản đâu là chọn lựa tối ưu nhất?\r\nVới sự ra mắt của 5 phiên bản Xiaomi Redmi Note 15 series', 'draft', 0, 0, '2026-01-12 05:12:28', '2026-01-12 05:12:28'),
(10, 'Điện thoại iPhone 17 Pro', 'dien-thoai-iphone-17-pro', 1, NULL, NULL, 'Khẳng định đẳng cấp với khung nhôm nguyên khối chắc chắn và diện mạo mới.\r\nHình ảnh hiển thị hoàn hảo, siêu mượt trên màn hình ProMotion viền mỏng hơn.\r\nNhiếp ảnh chuyên nghiệp với bộ ba camera 48 MP và khả năng zoom quang học 8x.\r\nChinh phục mọi giới hạn với chip A19 Pro được tối ưu bởi tản nhiệt buồng hơi.\r\nDuy trì hiệu suất đỉnh cao nhờ viên pin lớn, xem video đến 31 giờ.', 'draft', 0, 0, '2026-01-12 05:16:36', '2026-01-12 05:16:36'),
(11, 'vivo Y31d', 'vivo-y31d', 1, NULL, NULL, 'vivo Y31d là mẫu smartphone mới, tập trung vào độ bền và thời lượng pin dài. Thiết bị đạt chuẩn kháng nước, bụi IP68/69/69+, đồng thời sở hữu pin BlueVolt 7200 mAh phục vụ nhu cầu sử dụng liên tục. Bên cạnh đó, màn hình 6.75 inch 120 Hz cùng Snapdragon 6s Gen 2 4G đáp ứng tốt các tác vụ hằng ngày.', 'draft', 0, 0, '2026-01-12 05:30:30', '2026-01-12 05:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham_thuoctinh`
--

CREATE TABLE `sanpham_thuoctinh` (
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `thuoctinh_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanpham_thuoctinh`
--

INSERT INTO `sanpham_thuoctinh` (`sanpham_id`, `thuoctinh_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(11, 1),
(11, 2),
(11, 3),
(11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `so_sanh_sanpham`
--

CREATE TABLE `so_sanh_sanpham` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thong_bao`
--

CREATE TABLE `thong_bao` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'NULL = thông báo cho tất cả',
  `loai` enum('don_hang','danh_gia','bao_hanh','khuyen_mai','he_thong') NOT NULL,
  `tieu_de` varchar(200) NOT NULL,
  `noi_dung` text NOT NULL,
  `lien_ket` varchar(255) DEFAULT NULL,
  `da_doc` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thong_so_ky_thuat`
--

CREATE TABLE `thong_so_ky_thuat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `ten_thong_so` varchar(150) NOT NULL COMMENT 'Tên thông số (key)',
  `gia_tri` varchar(255) NOT NULL COMMENT 'Giá trị (value)',
  `thu_tu` int(10) UNSIGNED DEFAULT 0 COMMENT 'Thứ tự hiển thị',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thuoctinh`
--

CREATE TABLE `thuoctinh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thuoctinh`
--

INSERT INTO `thuoctinh` (`id`, `ten`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Màu sắc', 'Màu sắc sản phẩm', '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(2, 'Dung lượng lưu trữ', 'Dung lượng bộ nhớ', '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(3, 'RAM', 'Bộ nhớ RAM', '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(4, 'Kích thước màn hình', 'Kích thước màn hình (inch)', '2025-12-19 08:55:12', '2025-12-19 08:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `thuong_hieu`
--

CREATE TABLE `thuong_hieu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thuong_hieu`
--

INSERT INTO `thuong_hieu` (`id`, `ten`, `mo_ta`, `hinh_logo`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'Thương hiệu công nghệ hàng đầu', NULL, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(2, 'Samsung', 'Thương hiệu điện tử Hàn Quốc', NULL, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(3, 'Xiaomi', 'Thương hiệu công nghệ Trung Quốc', NULL, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(4, 'Dell', 'Thương hiệu laptop', NULL, '2025-12-19 08:55:12', '2025-12-19 08:55:12'),
(5, 'HP', 'Thương hiệu máy tính', NULL, '2025-12-19 08:55:12', '2025-12-19 08:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `yeu_cau_bao_hanh`
--

CREATE TABLE `yeu_cau_bao_hanh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoi_dung_id` bigint(20) UNSIGNED NOT NULL,
  `donhang_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Đơn hàng đã mua',
  `bien_the_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Biến thể sản phẩm cần bảo hành',
  `ma_yeu_cau` varchar(50) NOT NULL,
  `mo_ta_loi` text NOT NULL COMMENT 'Mô tả lỗi',
  `hinh_thuc_bao_hanh` enum('sua_chua','thay_the','doi_moi') NOT NULL COMMENT 'Sửa chữa, Thay thế, Đổi mới',
  `trang_thai` enum('cho_tiep_nhan','dang_xu_ly','hoan_tat','tu_choi') NOT NULL DEFAULT 'cho_tiep_nhan',
  `ghi_chu_noi_bo` text DEFAULT NULL COMMENT 'Ghi chú nội bộ của admin',
  `phieu_bao_hanh_chinh_hang` varchar(100) DEFAULT NULL COMMENT 'Số phiếu bảo hành chính hãng',
  `ngay_tiep_nhan` timestamp NULL DEFAULT NULL,
  `ngay_hoan_thanh` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anh_bao_hanh`
--
ALTER TABLE `anh_bao_hanh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_yeu_cau_id` (`yeu_cau_id`);

--
-- Indexes for table `anh_danh_gia`
--
ALTER TABLE `anh_danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_danh_gia_id` (`danh_gia_id`);

--
-- Indexes for table `anh_sanpham`
--
ALTER TABLE `anh_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`),
  ADD KEY `idx_bien_the_id` (`bien_the_id`);

--
-- Indexes for table `bien_the`
--
ALTER TABLE `bien_the`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`),
  ADD KEY `idx_sku` (`sku`),
  ADD KEY `idx_so_luong_ton` (`so_luong_ton`);

--
-- Indexes for table `bien_the_giatri`
--
ALTER TABLE `bien_the_giatri`
  ADD PRIMARY KEY (`bien_the_id`,`giatri_thuoctinh_id`),
  ADD KEY `giatri_thuoctinh_id` (`giatri_thuoctinh_id`);

--
-- Indexes for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_danh_gia_id` (`danh_gia_id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_binh_luan_cha_id` (`binh_luan_cha_id`);

--
-- Indexes for table `cau_hinh_ton_kho`
--
ALTER TABLE `cau_hinh_ton_kho`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bien_the_id` (`bien_the_id`),
  ADD KEY `idx_donhang_id` (`donhang_id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`);

--
-- Indexes for table `chitiet_phieu_nhap`
--
ALTER TABLE `chitiet_phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_phieu_nhap_id` (`phieu_nhap_id`),
  ADD KEY `idx_bien_the_id` (`bien_the_id`);

--
-- Indexes for table `chuong_trinh_khuyen_mai`
--
ALTER TABLE `chuong_trinh_khuyen_mai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_tao_id` (`nguoi_tao_id`),
  ADD KEY `idx_trang_thai` (`trang_thai`),
  ADD KEY `idx_ngay_ket_thuc` (`ngay_ket_thuc`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_id_cha` (`id_cha`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_hien_thi` (`hien_thi`);

--
-- Indexes for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donhang_id` (`donhang_id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`),
  ADD KEY `idx_trang_thai` (`trang_thai`),
  ADD KEY `idx_so_sao` (`so_sao`);

--
-- Indexes for table `danh_sach_yeu_thich`
--
ALTER TABLE `danh_sach_yeu_thich`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`nguoi_dung_id`,`sanpham_id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`);

--
-- Indexes for table `dia_chi_giao_hang`
--
ALTER TABLE `dia_chi_giao_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_la_mac_dinh` (`la_mac_dinh`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_don_hang` (`ma_don_hang`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_ma_don_hang` (`ma_don_hang`),
  ADD KEY `idx_trang_thai` (`trang_thai`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `ma_giam_gia_id` (`ma_giam_gia_id`);

--
-- Indexes for table `giatri_thuoctinh`
--
ALTER TABLE `giatri_thuoctinh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_giatri` (`thuoctinh_id`,`giatri`),
  ADD KEY `idx_thuoctinh_id` (`thuoctinh_id`);

--
-- Indexes for table `khuyen_mai_sanpham`
--
ALTER TABLE `khuyen_mai_sanpham`
  ADD PRIMARY KEY (`chuong_trinh_id`,`sanpham_id`,`danhmuc_id`),
  ADD KEY `sanpham_id` (`sanpham_id`),
  ADD KEY `danhmuc_id` (`danhmuc_id`);

--
-- Indexes for table `lich_su_xem`
--
ALTER TABLE `lich_su_xem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_session_id` (`session_id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_voucher` (`ma_voucher`),
  ADD KEY `nguoi_tao_id` (`nguoi_tao_id`),
  ADD KEY `idx_ma_voucher` (`ma_voucher`),
  ADD KEY `idx_trang_thai` (`trang_thai`),
  ADD KEY `idx_ngay_ket_thuc` (`ngay_ket_thuc`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_vai_tro` (`vai_tro`),
  ADD KEY `idx_trang_thai` (`trang_thai`);

--
-- Indexes for table `nhat_ky_hoat_dong`
--
ALTER TABLE `nhat_ky_hoat_dong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_model` (`loai_model`,`id_model`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_phieu` (`ma_phieu`),
  ADD KEY `nha_cung_cap_id` (`nha_cung_cap_id`),
  ADD KEY `nguoi_tao_id` (`nguoi_tao_id`),
  ADD KEY `idx_ma_phieu` (`ma_phieu`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_danhmuc_id` (`danhmuc_id`),
  ADD KEY `idx_thuong_hieu_id` (`thuong_hieu_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_trang_thai` (`trang_thai`),
  ADD KEY `idx_luot_ban` (`luot_ban`);

--
-- Indexes for table `sanpham_thuoctinh`
--
ALTER TABLE `sanpham_thuoctinh`
  ADD PRIMARY KEY (`sanpham_id`,`thuoctinh_id`),
  ADD KEY `thuoctinh_id` (`thuoctinh_id`);

--
-- Indexes for table `so_sanh_sanpham`
--
ALTER TABLE `so_sanh_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_compare` (`nguoi_dung_id`,`sanpham_id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`);

--
-- Indexes for table `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_da_doc` (`da_doc`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `thong_so_ky_thuat`
--
ALTER TABLE `thong_so_ky_thuat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sanpham_id` (`sanpham_id`);

--
-- Indexes for table `thuoctinh`
--
ALTER TABLE `thuoctinh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Indexes for table `thuong_hieu`
--
ALTER TABLE `thuong_hieu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Indexes for table `yeu_cau_bao_hanh`
--
ALTER TABLE `yeu_cau_bao_hanh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_yeu_cau` (`ma_yeu_cau`),
  ADD KEY `donhang_id` (`donhang_id`),
  ADD KEY `bien_the_id` (`bien_the_id`),
  ADD KEY `idx_nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `idx_ma_yeu_cau` (`ma_yeu_cau`),
  ADD KEY `idx_trang_thai` (`trang_thai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anh_bao_hanh`
--
ALTER TABLE `anh_bao_hanh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anh_danh_gia`
--
ALTER TABLE `anh_danh_gia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anh_sanpham`
--
ALTER TABLE `anh_sanpham`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bien_the`
--
ALTER TABLE `bien_the`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cau_hinh_ton_kho`
--
ALTER TABLE `cau_hinh_ton_kho`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chitiet_phieu_nhap`
--
ALTER TABLE `chitiet_phieu_nhap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chuong_trinh_khuyen_mai`
--
ALTER TABLE `chuong_trinh_khuyen_mai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danh_sach_yeu_thich`
--
ALTER TABLE `danh_sach_yeu_thich`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dia_chi_giao_hang`
--
ALTER TABLE `dia_chi_giao_hang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `giatri_thuoctinh`
--
ALTER TABLE `giatri_thuoctinh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `lich_su_xem`
--
ALTER TABLE `lich_su_xem`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nhat_ky_hoat_dong`
--
ALTER TABLE `nhat_ky_hoat_dong`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `so_sanh_sanpham`
--
ALTER TABLE `so_sanh_sanpham`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thong_bao`
--
ALTER TABLE `thong_bao`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thong_so_ky_thuat`
--
ALTER TABLE `thong_so_ky_thuat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `thuoctinh`
--
ALTER TABLE `thuoctinh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thuong_hieu`
--
ALTER TABLE `thuong_hieu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `yeu_cau_bao_hanh`
--
ALTER TABLE `yeu_cau_bao_hanh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anh_bao_hanh`
--
ALTER TABLE `anh_bao_hanh`
  ADD CONSTRAINT `anh_bao_hanh_ibfk_1` FOREIGN KEY (`yeu_cau_id`) REFERENCES `yeu_cau_bao_hanh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `anh_danh_gia`
--
ALTER TABLE `anh_danh_gia`
  ADD CONSTRAINT `anh_danh_gia_ibfk_1` FOREIGN KEY (`danh_gia_id`) REFERENCES `danh_gia` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `anh_sanpham`
--
ALTER TABLE `anh_sanpham`
  ADD CONSTRAINT `anh_sanpham_ibfk_1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anh_sanpham_ibfk_2` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bien_the`
--
ALTER TABLE `bien_the`
  ADD CONSTRAINT `bien_the_ibfk_1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bien_the_giatri`
--
ALTER TABLE `bien_the_giatri`
  ADD CONSTRAINT `bien_the_giatri_ibfk_1` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bien_the_giatri_ibfk_2` FOREIGN KEY (`giatri_thuoctinh_id`) REFERENCES `giatri_thuoctinh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`danh_gia_id`) REFERENCES `danh_gia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binh_luan_ibfk_3` FOREIGN KEY (`binh_luan_cha_id`) REFERENCES `binh_luan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitiet_donhang_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`),
  ADD CONSTRAINT `chitiet_donhang_ibfk_3` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`);

--
-- Constraints for table `chitiet_phieu_nhap`
--
ALTER TABLE `chitiet_phieu_nhap`
  ADD CONSTRAINT `chitiet_phieu_nhap_ibfk_1` FOREIGN KEY (`phieu_nhap_id`) REFERENCES `phieu_nhap` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitiet_phieu_nhap_ibfk_2` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chuong_trinh_khuyen_mai`
--
ALTER TABLE `chuong_trinh_khuyen_mai`
  ADD CONSTRAINT `chuong_trinh_khuyen_mai_ibfk_1` FOREIGN KEY (`nguoi_tao_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD CONSTRAINT `danhmuc_ibfk_1` FOREIGN KEY (`id_cha`) REFERENCES `danhmuc` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_3` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `danh_sach_yeu_thich`
--
ALTER TABLE `danh_sach_yeu_thich`
  ADD CONSTRAINT `danh_sach_yeu_thich_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_sach_yeu_thich_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dia_chi_giao_hang`
--
ALTER TABLE `dia_chi_giao_hang`
  ADD CONSTRAINT `dia_chi_giao_hang_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`ma_giam_gia_id`) REFERENCES `ma_giam_gia` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `giatri_thuoctinh`
--
ALTER TABLE `giatri_thuoctinh`
  ADD CONSTRAINT `giatri_thuoctinh_ibfk_1` FOREIGN KEY (`thuoctinh_id`) REFERENCES `thuoctinh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `khuyen_mai_sanpham`
--
ALTER TABLE `khuyen_mai_sanpham`
  ADD CONSTRAINT `khuyen_mai_sanpham_ibfk_1` FOREIGN KEY (`chuong_trinh_id`) REFERENCES `chuong_trinh_khuyen_mai` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `khuyen_mai_sanpham_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `khuyen_mai_sanpham_ibfk_3` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lich_su_xem`
--
ALTER TABLE `lich_su_xem`
  ADD CONSTRAINT `lich_su_xem_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lich_su_xem_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  ADD CONSTRAINT `ma_giam_gia_ibfk_1` FOREIGN KEY (`nguoi_tao_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `nhat_ky_hoat_dong`
--
ALTER TABLE `nhat_ky_hoat_dong`
  ADD CONSTRAINT `nhat_ky_hoat_dong_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD CONSTRAINT `phieu_nhap_ibfk_1` FOREIGN KEY (`nha_cung_cap_id`) REFERENCES `nha_cung_cap` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `phieu_nhap_ibfk_2` FOREIGN KEY (`nguoi_tao_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`thuong_hieu_id`) REFERENCES `thuong_hieu` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sanpham_thuoctinh`
--
ALTER TABLE `sanpham_thuoctinh`
  ADD CONSTRAINT `sanpham_thuoctinh_ibfk_1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sanpham_thuoctinh_ibfk_2` FOREIGN KEY (`thuoctinh_id`) REFERENCES `thuoctinh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `so_sanh_sanpham`
--
ALTER TABLE `so_sanh_sanpham`
  ADD CONSTRAINT `so_sanh_sanpham_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `so_sanh_sanpham_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD CONSTRAINT `thong_bao_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thong_so_ky_thuat`
--
ALTER TABLE `thong_so_ky_thuat`
  ADD CONSTRAINT `thong_so_ky_thuat_ibfk_1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `yeu_cau_bao_hanh`
--
ALTER TABLE `yeu_cau_bao_hanh`
  ADD CONSTRAINT `yeu_cau_bao_hanh_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `yeu_cau_bao_hanh_ibfk_2` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `yeu_cau_bao_hanh_ibfk_3` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
