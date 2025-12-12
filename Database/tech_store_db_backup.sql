-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 06:33 PM
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
-- Table structure for table `anh_sanpham`
--

CREATE TABLE `anh_sanpham` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `bien_the_id` bigint(20) UNSIGNED DEFAULT NULL,
  `duong_dan` varchar(255) NOT NULL,
  `la_anh_chinh` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anh_sanpham`
--

INSERT INTO `anh_sanpham` (`id`, `sanpham_id`, `bien_the_id`, `duong_dan`, `la_anh_chinh`, `created_at`) VALUES
(4, 3, 5, 'products/YVWqT7m7VMak5XD3yVUCbrF9PlVg6tJ7xI3bv1he.jpg', 1, '2025-12-12 10:05:46'),
(5, 3, 6, 'products/2t7E9At5agOT36WKCqJwjHrciOmzutrsTbno2iXf.jpg', 0, '2025-12-12 10:05:46'),
(6, 3, NULL, 'products/1bJIBcOmZUDvAHOrhFC4dI8tdYL8vIICCHNzXlZq.jpg', 1, '2025-12-12 10:05:46'),
(10, 1, NULL, 'products/gzgveMeGkOBHZPjaMacaby7ErVtqym7Sx9TlFfCS.jpg', 0, '2025-12-12 10:15:01'),
(11, 1, NULL, 'products/mvRrG8llctZsYsRIAMwW9vPQlpgsk8TiiVY97rQQ.jpg', 0, '2025-12-12 10:15:07'),
(12, 1, NULL, 'products/yUbMTI7F1Wi9ryCInNe1gRzpbGIlSAB8cYMfwLWt.jpg', 0, '2025-12-12 10:15:12'),
(13, 2, NULL, 'products/m4Pau733tGnZf7zgHhgRnUGlju4kAKsNy7yX9rde.jpg', 1, '2025-12-12 10:17:25'),
(14, 2, NULL, 'products/Y8afFwpTEgYrByTDdn4J4bK3x076VN2cOjia8gDX.jpg', 0, '2025-12-12 10:17:37'),
(15, 2, NULL, 'products/tztxU3kdJbJ0GXwYo6SjPcbV15I8cSVmL5szHtfn.jpg', 0, '2025-12-12 10:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `bien_the`
--

CREATE TABLE `bien_the` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(100) NOT NULL,
  `gia` decimal(13,0) NOT NULL,
  `gia_von` decimal(13,0) NOT NULL,
  `so_luong_ton` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bien_the`
--

INSERT INTO `bien_the` (`id`, `sanpham_id`, `sku`, `gia`, `gia_von`, `so_luong_ton`, `created_at`, `updated_at`) VALUES
(1, 1, 'IP15PM-XANH-128', 29990000, 25000000, 8, '2025-12-12 06:30:24', '2025-12-12 10:26:41'),
(2, 1, 'IP15PM-XANH-256', 32990000, 27000000, 8, '2025-12-12 06:30:24', '2025-12-12 06:30:24'),
(3, 1, 'IP15PM-DEN-128', 29990000, 25000000, 5, '2025-12-12 06:30:24', '2025-12-12 06:30:24'),
(4, 2, 'OP15PM-001', 250000, 120000, 50, '2025-12-12 06:30:25', '2025-12-12 06:30:25'),
(5, 3, '123', 37000000, 35000000, 10, '2025-12-12 10:05:46', '2025-12-12 10:05:46'),
(6, 3, '1234', 36000000, 35000000, 11, '2025-12-12 10:05:46', '2025-12-12 10:26:41');

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
(1, 1),
(1, 3),
(2, 1),
(2, 4),
(3, 2),
(3, 3),
(5, 1),
(5, 3),
(6, 2),
(6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_donhang`
--

CREATE TABLE `chitiet_donhang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `donhang_id` bigint(20) UNSIGNED NOT NULL,
  `sanpham_id` bigint(20) UNSIGNED NOT NULL,
  `bien_the_id` bigint(20) UNSIGNED NOT NULL,
  `so_luong` int(10) UNSIGNED NOT NULL,
  `gia_luc_mua` decimal(13,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitiet_donhang`
--

INSERT INTO `chitiet_donhang` (`id`, `donhang_id`, `sanpham_id`, `bien_the_id`, `so_luong`, `gia_luc_mua`) VALUES
(1, 3, 1, 1, 2, 29990000),
(2, 3, 3, 6, 1, 36000000);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieu_nhap`
--

CREATE TABLE `chitiet_phieu_nhap` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phieu_nhap_id` bigint(20) UNSIGNED NOT NULL,
  `bien_the_id` bigint(20) UNSIGNED NOT NULL,
  `so_luong_nhap` int(10) UNSIGNED NOT NULL,
  `gia_von_nhap` decimal(13,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitiet_phieu_nhap`
--

INSERT INTO `chitiet_phieu_nhap` (`id`, `phieu_nhap_id`, `bien_the_id`, `so_luong_nhap`, `gia_von_nhap`, `created_at`) VALUES
(1, 1, 1, 10, 25000000, '2025-12-12 06:30:25'),
(2, 1, 4, 50, 120000, '2025-12-12 06:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `ten`, `created_at`, `updated_at`) VALUES
(1, 'Điện Thoại', '2025-12-12 06:27:02', '2025-12-12 10:13:30'),
(2, 'Máy Tính', '2025-12-12 06:27:02', '2025-12-12 10:13:37'),
(3, 'Máy Tính Bảng', '2025-12-12 06:27:02', '2025-12-12 10:13:46'),
(4, 'Phụ Kiện', '2025-12-12 06:27:02', '2025-12-12 10:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoidung_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ten_khach` varchar(100) NOT NULL,
  `sdt_khach` varchar(20) NOT NULL,
  `email_khach` varchar(150) DEFAULT NULL,
  `dia_chi_khach` text NOT NULL,
  `tong_tien` decimal(13,0) NOT NULL,
  `trang_thai` enum('cho_xac_nhan','da_xac_nhan','dang_giao','hoan_thanh','da_huy') NOT NULL DEFAULT 'cho_xac_nhan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`id`, `nguoidung_id`, `ten_khach`, `sdt_khach`, `email_khach`, `dia_chi_khach`, `tong_tien`, `trang_thai`, `created_at`, `updated_at`) VALUES
(3, 2, 'Admin', '09710102891', 'admin@gmail.com', 'dsdf', 95980000, 'cho_xac_nhan', '2025-12-12 10:26:41', '2025-12-12 10:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `giatri_thuoctinh`
--

CREATE TABLE `giatri_thuoctinh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thuoctinh_id` bigint(20) UNSIGNED NOT NULL,
  `giatri` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `giatri_thuoctinh`
--

INSERT INTO `giatri_thuoctinh` (`id`, `thuoctinh_id`, `giatri`, `created_at`) VALUES
(1, 1, 'Xanh Thien Thach', '2025-12-12 06:30:24'),
(2, 1, 'Den', '2025-12-12 06:30:24'),
(3, 2, '128GB', '2025-12-12 06:30:24'),
(4, 2, '256GB', '2025-12-12 06:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_danhmuc_table', 1),
(5, '2024_01_01_000002_create_thuoctinh_table', 1),
(6, '2024_01_01_000003_create_sanpham_table', 1),
(7, '2024_01_01_000004_create_giatri_thuoctinh_table', 1),
(8, '2024_01_01_000005_create_sanpham_thuoctinh_table', 1),
(9, '2024_01_01_000006_create_bien_the_table', 1),
(10, '2024_01_01_000007_create_bien_the_giatri_table', 1),
(11, '2024_01_01_000008_create_anh_sanpham_table', 1),
(12, '2024_01_01_000009_create_nguoidung_table', 1),
(13, '2024_01_01_000010_create_donhang_table', 1),
(14, '2024_01_01_000011_create_chitiet_donhang_table', 1),
(15, '2024_01_01_000012_create_nha_cung_cap_table', 1),
(16, '2024_01_01_000013_create_phieu_nhap_table', 1),
(17, '2024_01_01_000014_create_chitiet_phieu_nhap_table', 1),
(18, '2024_01_01_000015_add_role_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `ten`, `email`, `mat_khau`, `sdt`, `dia_chi`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'admin@gmail.com', '$2y$12$7vY5UOdn8A8bB6cs/gI5.u926nKEKYNh6eQYpHe3MPZn4i4mkI9wu', NULL, NULL, '2025-12-12 10:26:41', '2025-12-12 10:26:41');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id`, `ten`, `sdt`, `email`, `dia_chi`, `created_at`) VALUES
(1, 'Cong ty ABC', '0909123456', NULL, 'Ha Noi', '2025-12-12 06:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nha_cung_cap_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phieu_nhap`
--

INSERT INTO `phieu_nhap` (`id`, `nha_cung_cap_id`, `ghi_chu`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nhap lan dau', '2025-12-12 06:30:25', '2025-12-12 06:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(255) NOT NULL,
  `danhmuc_id` bigint(20) UNSIGNED NOT NULL,
  `mota` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `ten`, `danhmuc_id`, `mota`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 15 Pro Max', 1, 'ỘI DUNG BẢO HÀNH	\r\nBảo hành 1 tháng\r\n(Miễn phí)\r\n21,490,000 ₫\r\n1 đổi 1 12 tháng\r\n( +1,600,000 ₫ )\r\n23,090,000 ₫\r\nThời gian bao test	1 tháng	12 tháng\r\nThời gian bảo hành	1 tháng	12 tháng\r\nMất nguồn, vân tay, Face ID	Đổi máy tương đương	Đổi máy tương đương\r\nMàn hình	0-1 tháng: Đổi máy tương đương	0-12 tháng: Đổi máy tương đương\r\n13-24 tháng: Thay màn hỗ trợ 20% ( Linh kiện khác không bảo hành)\r\nLinh kiện phần cứng: Main, ổ cứng, camera, wifi, loa thoại…	Đổi máy tương đương	Đổi máy tương đương\r\nPin và phím bấm vật lý (âm lượng, phím nguồn, gạt rung)	Bảo hành sửa chữa	Bảo hành sửa chữa\r\nBảo hành trọn đời iPhone cũ	Reset thời gian bảo hành lại từ đầu nếu máy lỗi.	Reset thời gian bảo hành lại từ đầu nếu máy lỗi.\r\nBảo hành rơi vỡ (trầy, móp), vào nước 12 tháng	Không áp dụng	\r\nSửa chữa miễn phí không giới hạn số lần\r\n\r\nMàn hình hỗ trợ 30% phí thay màn\r\n\r\nMáy không sửa được hoàn lại 20% giá trị máy\r\n\r\nCam kết không zin tặng máy	Có áp dụng	Có áp dụng', '2025-12-12 06:30:24', '2025-12-12 10:15:35'),
(2, 'Ốp lưng MagSafe iPhone 15 Pro Max', 1, 'Samsung Galaxy A36 – Smartphone tầm trung đáng mua nhất 2025!\r\nNếu bạn đang tìm một chiếc điện thoại ngon bổ rẻ nhưng vẫn phải có thiết kế xịn sò, màn hình đẹp, hiệu năng mạnh để chiến game và camera ổn định để sống ảo? Samsung Galaxy A36 chính là một ứng cử viên sáng giá! Sở hữu con chip Snapdragon hiện đại, màn hình Super AMOLED sáng nhất phân khúc và sạc siêu nhanh 45W, liệu A36 có thực sự bá đạo như lời đồn, hãy cùng mình bóc tách em nó trong bài biết này nhé!', '2025-12-12 06:30:25', '2025-12-12 10:17:55'),
(3, 'iPhone 17 Pro Max', 1, 'iPhone 17 Pro Max 2TB vừa là một chiếc điện thoại, vừa là một tuyên ngôn về công nghệ và sự đột phá. Với dung lượng lưu trữ khổng lồ chưa từng có và những cải tiến vượt bậc, phiên bản này được kỳ vọng sẽ trở thành \"ông vua\" trong phân khúc smartphone cao cấp. Nếu bạn là một nhà sáng tạo nội dung, một người đam mê công nghệ hay đơn giản chỉ muốn sở hữu một thiết bị không giới hạn, đây chính là lựa chọn hoàn hảo.', '2025-12-12 10:05:46', '2025-12-12 10:05:46');

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
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bI4zQGOMoXb6owkCOmMm2GhzsPddHjI6UsMiw18t', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ0dTdGVueU9Ya2paT0czRWdSRmRUT0FjVTBBQXFtcjBvdVdhNG9IQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjQ6ImNhcnQiO2E6MDp7fX0=', 1765560749);

-- --------------------------------------------------------

--
-- Table structure for table `thuoctinh`
--

CREATE TABLE `thuoctinh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thuoctinh`
--

INSERT INTO `thuoctinh` (`id`, `ten`, `created_at`) VALUES
(1, 'Mau sac', '2025-12-12 06:30:24'),
(2, 'Dung luong luu tru', '2025-12-12 06:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@techstore.com', 'admin', NULL, '$2y$12$wWkCDQNVB7.zBs5ajmtL6OlnN6.v.o./Hr9Ywiv7fFwy4/y0Zoq2G', NULL, '2025-12-12 06:27:02', '2025-12-12 06:27:02'),
(2, 'Nguyễn Văn A', 'customer@techstore.com', 'customer', NULL, '$2y$12$HYCsx70zG1Ya4u4i/vy1Jef77r37/ZLZQH0f3VeHALJDvoQFmJLAi', NULL, '2025-12-12 06:27:02', '2025-12-12 06:30:24'),
(4, 'Admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$7vY5UOdn8A8bB6cs/gI5.u926nKEKYNh6eQYpHe3MPZn4i4mkI9wu', 'Qfr5uMBVQRDk9ta4DsFMwpT8dd3sMKDwVdCoWapGYbUJMOGRNJjpEAWX5wqy', '2025-12-12 06:30:24', '2025-12-12 06:30:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anh_sanpham`
--
ALTER TABLE `anh_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anh_sanpham_sanpham_id_foreign` (`sanpham_id`),
  ADD KEY `anh_sanpham_bien_the_id_foreign` (`bien_the_id`);

--
-- Indexes for table `bien_the`
--
ALTER TABLE `bien_the`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bien_the_sku_unique` (`sku`),
  ADD KEY `bien_the_sanpham_id_foreign` (`sanpham_id`);

--
-- Indexes for table `bien_the_giatri`
--
ALTER TABLE `bien_the_giatri`
  ADD PRIMARY KEY (`bien_the_id`,`giatri_thuoctinh_id`),
  ADD KEY `bien_the_giatri_giatri_thuoctinh_id_foreign` (`giatri_thuoctinh_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chitiet_donhang_donhang_id_foreign` (`donhang_id`),
  ADD KEY `chitiet_donhang_sanpham_id_foreign` (`sanpham_id`),
  ADD KEY `chitiet_donhang_bien_the_id_foreign` (`bien_the_id`);

--
-- Indexes for table `chitiet_phieu_nhap`
--
ALTER TABLE `chitiet_phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chitiet_phieu_nhap_phieu_nhap_id_foreign` (`phieu_nhap_id`),
  ADD KEY `chitiet_phieu_nhap_bien_the_id_foreign` (`bien_the_id`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `danhmuc_ten_unique` (`ten`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donhang_nguoidung_id_foreign` (`nguoidung_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `giatri_thuoctinh`
--
ALTER TABLE `giatri_thuoctinh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_giatri` (`thuoctinh_id`,`giatri`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nguoidung_email_unique` (`email`);

--
-- Indexes for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phieu_nhap_nha_cung_cap_id_foreign` (`nha_cung_cap_id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sanpham_danhmuc_id_foreign` (`danhmuc_id`);

--
-- Indexes for table `sanpham_thuoctinh`
--
ALTER TABLE `sanpham_thuoctinh`
  ADD PRIMARY KEY (`sanpham_id`,`thuoctinh_id`),
  ADD KEY `sanpham_thuoctinh_thuoctinh_id_foreign` (`thuoctinh_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `thuoctinh`
--
ALTER TABLE `thuoctinh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `thuoctinh_ten_unique` (`ten`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anh_sanpham`
--
ALTER TABLE `anh_sanpham`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bien_the`
--
ALTER TABLE `bien_the`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chitiet_phieu_nhap`
--
ALTER TABLE `chitiet_phieu_nhap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giatri_thuoctinh`
--
ALTER TABLE `giatri_thuoctinh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thuoctinh`
--
ALTER TABLE `thuoctinh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anh_sanpham`
--
ALTER TABLE `anh_sanpham`
  ADD CONSTRAINT `anh_sanpham_bien_the_id_foreign` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anh_sanpham_sanpham_id_foreign` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bien_the`
--
ALTER TABLE `bien_the`
  ADD CONSTRAINT `bien_the_sanpham_id_foreign` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bien_the_giatri`
--
ALTER TABLE `bien_the_giatri`
  ADD CONSTRAINT `bien_the_giatri_bien_the_id_foreign` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bien_the_giatri_giatri_thuoctinh_id_foreign` FOREIGN KEY (`giatri_thuoctinh_id`) REFERENCES `giatri_thuoctinh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_bien_the_id_foreign` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`),
  ADD CONSTRAINT `chitiet_donhang_donhang_id_foreign` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitiet_donhang_sanpham_id_foreign` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Constraints for table `chitiet_phieu_nhap`
--
ALTER TABLE `chitiet_phieu_nhap`
  ADD CONSTRAINT `chitiet_phieu_nhap_bien_the_id_foreign` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitiet_phieu_nhap_phieu_nhap_id_foreign` FOREIGN KEY (`phieu_nhap_id`) REFERENCES `phieu_nhap` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_nguoidung_id_foreign` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `giatri_thuoctinh`
--
ALTER TABLE `giatri_thuoctinh`
  ADD CONSTRAINT `giatri_thuoctinh_thuoctinh_id_foreign` FOREIGN KEY (`thuoctinh_id`) REFERENCES `thuoctinh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD CONSTRAINT `phieu_nhap_nha_cung_cap_id_foreign` FOREIGN KEY (`nha_cung_cap_id`) REFERENCES `nha_cung_cap` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_danhmuc_id_foreign` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sanpham_thuoctinh`
--
ALTER TABLE `sanpham_thuoctinh`
  ADD CONSTRAINT `sanpham_thuoctinh_sanpham_id_foreign` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sanpham_thuoctinh_thuoctinh_id_foreign` FOREIGN KEY (`thuoctinh_id`) REFERENCES `thuoctinh` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
