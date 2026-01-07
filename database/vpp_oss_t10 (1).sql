-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 06:53 AM
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
-- Database: `vpp_oss_t10`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bút viết', 'but-viet', 'Các loại bút bi, bút mực, bút chì...', 'images/products/butviet.jpg', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(2, 'Giấy tờ', 'giay-to', 'Giấy in, giấy photo, giấy note...', 'images/products/giayto.jpg', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(3, 'Sổ tay', 'so-tay', 'Sổ tay, sổ ghi chú, sổ bìa da...', 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=600&h=600&fit=crop', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(4, 'Dụng cụ học tập', 'dung-cu-hoc-tap', 'Thước kẻ, compa, tẩy, gọt bút chì...', 'images/products/dungcuhoctap.jpg', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(5, 'Thiết bị văn phòng', 'thiet-bi-van-phong', 'Máy tính, bàn phím, chuột, máy in...', 'images/products/thietbivanphong.jpg', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(6, 'Kẹp & Bấm', 'kep-bam', 'Kẹp giấy, bấm ghim, kim bấm...', 'images/products/kepbam.jpg', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(7, 'File & Folder', 'file-folder', 'Bìa đựng tài liệu, file tài liệu...', 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600&h=600&fit=crop', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(8, 'Băng keo & Keo dán', 'bang-keo-keo-dan', 'Băng keo trong, keo dán giấy...', 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=600&h=600&fit=crop', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000001_create_users_table', 1),
(3, '2024_01_01_000002_create_categories_table', 1),
(4, '2024_01_01_000003_create_suppliers_table', 1),
(5, '2024_01_01_000004_create_products_table', 1),
(6, '2024_01_01_000005_create_orders_table', 1),
(7, '2024_01_01_000006_create_order_details_table', 1),
(8, '2024_01_01_000007_create_carts_table', 1),
(9, '2024_01_01_000008_create_chats_table', 1),
(10, '2024_01_01_000009_create_stock_movements_table', 1),
(11, '2024_01_01_000010_add_payment_method_to_orders_table', 2),
(12, '2024_01_01_000011_add_reference_to_stock_movements_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `notes` text DEFAULT NULL,
  `payment_method` varchar(20) NOT NULL DEFAULT 'cod',
  `reject_reason` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `total_amount`, `status`, `shipping_address`, `phone`, `notes`, `payment_method`, `reject_reason`, `approved_at`, `rejected_at`, `completed_at`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 'ORD-1767337922-1', 1, 150000.00, 'pending', 'bndnfdg', '0909099999', NULL, 'cod', NULL, NULL, NULL, NULL, NULL, '2026-01-02 07:12:02', '2026-01-02 07:12:02'),
(2, 'ORD-1767575844-1', 1, 36000.00, 'pending', 'gds', '0909099999', 'sgd', 'cod', NULL, NULL, NULL, NULL, NULL, '2026-01-05 01:17:24', '2026-01-05 01:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 2, 75000.00, 150000.00, '2026-01-02 07:12:02', '2026-01-02 07:12:02'),
(2, 2, 22, 2, 18000.00, 36000.00, '2026-01-05 01:17:24', '2026-01-05 01:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'Cái',
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `slug`, `description`, `unit`, `price`, `stock_quantity`, `image`, `images`, `category_id`, `supplier_id`, `is_active`, `is_featured`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BV001', 'Bút bi Thiên Long TL-079', 'but-bi-thien-long-tl-079', 'Bút bi nước cao cấp, mực đen, viết trơn mượt. Thân bút trong suốt, độ bền cao', 'Cây', 5000.00, 500, '/images/products/but-bi-thien-long.jpg', NULL, 1, 1, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(2, 'BV002', 'Bút bi Bic Cristal', 'but-bi-bic-cristal', 'Bút bi đầu tròn 1.0mm, mực xanh. Thiết kế cổ điển, viết êm tay', 'Cây', 3500.00, 800, '/images/products/but-bi-cristal.jpg', NULL, 1, 2, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(3, 'BV003', 'Bút chì 2B Thiên Long', 'but-chi-2b-thien-long', 'Bút chì gỗ cao cấp, độ đậm 2B. Ruột chì không gẫy, dễ tẩy xóa', 'Cây', 2000.00, 1000, '/images/products/but-chi-2b.jpg', NULL, 1, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(4, 'BV004', 'Bút gel Thiên Long GEL-08', 'but-gel-thien-long-gel-08', 'Bút gel mực nước cao cấp 0.5mm, màu đen. Mực không lem, khô nhanh', 'Cây', 7000.00, 450, '/images/products/but-gel.jpg', NULL, 1, 1, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(5, 'BV005', 'Bút lông dầu Artline 700', 'but-long-dau-artline-700', 'Bút lông dầu màu đen, không phai. Thích hợp viết trên nhiều bề mặt', 'Cây', 15000.00, 200, '/images/products/but-long-dau.jpg', NULL, 1, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(6, 'BV006', 'Bút dạ quang Stabilo Boss', 'but-da-quang-stabilo-boss', 'Bút highlight màu vàng neon, không thấm qua giấy. Đầu bút dẹt tiện lợi', 'Cây', 25000.00, 300, '/images/products/but-da-quang.jpg', NULL, 1, 2, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(7, 'BV007', 'Bút máy Thiên Long Lửa Thiêng', 'but-may-thien-long-lua-thieng', 'Bút máy cao cấp,촉 inox bền đẹp. Thiết kế sang trọng, viết êm', 'Cây', 120000.00, 80, '/images/products/but-thien-long-lua-thien.jpg', NULL, 1, 1, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(8, 'GT001', 'Giấy A4 Paper.One 70gsm', 'giay-a4-paperone-70gsm', 'Giấy in A4 trắng, 500 tờ/ream. Độ trắng cao, thích hợp in văn bản', 'Ream', 75000.00, 200, '/images/products/giay-a4.jpg', NULL, 2, 3, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(9, 'GT002', 'Giấy note vàng 3x3', 'giay-note-vang-3x3', 'Giấy note dán màu vàng 76x76mm. Keo dán không để lại vết, 100 tờ/xấp', 'Xấp', 15000.00, 300, '/images/products/note-vang.jpg', NULL, 2, 3, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(10, 'GT003', 'Giấy A4 màu IK Plus', 'giay-a4-mau-ik-plus', 'Giấy màu A4 đa sắc, 100 tờ/ream. Thích hợp in tờ rơi, thiệp', 'Ream', 95000.00, 150, '/images/products/giay-a4-mau.jpg', NULL, 2, 3, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(11, 'GT004', 'Giấy bìa A4 cứng 250gsm', 'giay-bia-a4-cung-250gsm', 'Giấy bìa cứng màu trắng A4, 100 tờ. Dùng làm bìa tài liệu, danh thiếp', 'Tập', 120000.00, 100, '/images/products/giay-bia-a4.jpg', NULL, 2, 3, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(12, 'GT005', 'Giấy photo A3', 'giay-photo-a3', 'Giấy photocopy A3 80gsm, 500 tờ/ream. Trắng mịn, thích hợp in ấn', 'Ream', 135000.00, 120, '/images/products/giay-a3.jpg', NULL, 2, 3, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(13, 'ST001', 'Sổ tay bìa da A5', 'so-tay-bia-da-a5', 'Sổ tay bìa da sang trọng, 200 trang giấy kem. Có dây đánh dấu trang', 'Quyển', 85000.00, 150, '/images/products/so-tay-bia-da.jpg', NULL, 3, 1, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(14, 'ST002', 'Sổ lò xo A4 200 trang', 'so-lo-xo-a4-200-trang', 'Sổ lò xo gáy đôi, giấy trắng kẻ ngang. Bìa cứng màu đen sang trọng', 'Quyển', 35000.00, 250, '/images/products/so-lo-xo.jpg', NULL, 3, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(15, 'ST003', 'Sổ tay Moleskine Classic', 'so-tay-moleskine-classic', 'Sổ tay Moleskine bìa cứng A5, 240 trang. Giấy không lem, chất lượng cao', 'Quyển', 250000.00, 60, '/images/products/so-tay-monleskin.jpg', NULL, 3, 3, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(16, 'ST004', 'Planner 2026 kế hoạch năm', 'planner-2026-ke-hoach-nam', 'Sổ lập kế hoạch 2026, có lịch tháng và tuần. Bìa cứng chống nước', 'Quyển', 95000.00, 180, '/images/products/planner.jpg', NULL, 3, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(17, 'ST005', 'Sổ vẽ Sketch A4', 'so-ve-sketch-a4', 'Sổ vẽ chuyên dụng A4, giấy dày 180gsm. 50 trang, thích hợp vẽ màu nước', 'Quyển', 65000.00, 100, '/images/products/so-tay-sketch.jpg', NULL, 3, 3, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(18, 'DC001', 'Thước kẻ nhựa 30cm', 'thuoc-ke-nhua-30cm', 'Thước kẻ trong suốt, vạch chia mm chính xác. Không cong vênh', 'Cái', 8000.00, 400, '/images/products/thuot-ke-nhua.jpg.jpg', NULL, 4, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(19, 'DC002', 'Tẩy trắng Thiên Long E-044', 'tay-trang-thien-long-e-044', 'Tẩy không bụi, không làm rách giấy. Tẩy sạch mực chì và bút bi', 'Cái', 4000.00, 600, '/images/products/tay-trang-thien-long.jpg', NULL, 4, 1, 1, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(20, 'DC003', 'Gọt bút chì kim loại', 'got-but-chi-kim-loai', 'Gọt bút chì 2 lỗ, có hộp chứa phoi. Lưỡi dao sắc bén, bền', 'Cái', 12000.00, 350, '/images/products/got-but-chi.jpg', NULL, 4, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(21, 'DC004', 'Bộ compa học sinh', 'bo-compa-hoc-sinh', 'Bộ compa kim loại 4 món: compa, thước đo góc, thước kẻ, bút chì', 'Bộ', 45000.00, 180, '/images/products/bo-compa.jpg', NULL, 4, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(22, 'DC005', 'Bấm kim số 10', 'bam-kim-so-10', 'Bấm ghim số 10 cỡ nhỏ, dễ cầm nắm. Bấm được 20 tờ giấy', 'Cái', 18000.00, 220, '/images/products/bam-kim-so-10.jpg', NULL, 4, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(23, 'DC006', 'Hộp bút nhựa trong suốt', 'hop-but-nhua-trong-suot', 'Hộp đựng bút trong suốt có nắp đậy. Đựng được 20-30 cây bút', 'Cái', 22000.00, 280, '/images/products/hop-but-nhua.jpg', NULL, 4, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(24, 'DC007', 'Kéo cắt văn phòng 21cm', 'keo-cat-van-phong-21cm', 'Kéo inox cán nhựa ABS, lưỡi sắc bén. Cắt được giấy dày và vải', 'Cái', 35000.00, 160, '/images/products/keo-cat-van-phong.jpg', NULL, 4, 1, 1, 0, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(25, 'TBVP001', 'Máy in Canon LBP 2900', 'may-in-canon-lbp-2900', 'Máy in laser đen trắng, tốc độ 12 trang/phút, kết nối USB.', 'Cái', 2500000.00, 10, '/images/products/may-in-canon.jpg', NULL, 5, 1, 1, 1, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(26, 'TBVP002', 'Máy tính Casio FX-580VN X', 'may-tinh-casio-fx-580vn-x', 'Máy tính khoa học, 521 chức năng, màn hình lớn.', 'Cái', 550000.00, 30, '/images/products/may-tinh-casio.jpg', NULL, 5, 1, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(27, 'TBVP003', 'Bàn phím Logitech K120', 'ban-phim-logitech-k120', 'Bàn phím có dây, thiết kế chống nước, phím bấm êm.', 'Cái', 180000.00, 20, '/images/products/ban-phim-logitech.jpg', NULL, 5, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(28, 'TBVP004', 'Chuột không dây Logitech M185', 'chuot-khong-day-logitech-m185', 'Chuột không dây, kết nối USB, pin lâu dài.', 'Cái', 220000.00, 25, '/images/products/chuot-khong-day.jpg', NULL, 5, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(29, 'TBVP005', 'Máy hủy giấy Silicon PS-800C', 'may-huy-giay-silicon-ps-800c', 'Máy hủy giấy mini, công suất 8 tờ/lần, an toàn cho văn phòng.', 'Cái', 1200000.00, 8, '/images/products/may-huy-giay.jpg', NULL, 5, 1, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(30, 'KB001', 'Kẹp giấy 32mm', 'kep-giay-32mm', 'Kẹp giấy kim loại, bản rộng 32mm, 12 cái/hộp.', 'Hộp', 15000.00, 100, '/images/products/kep-giay-32mm.jpg', NULL, 6, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(31, 'KB002', 'Bấm kim số 3', 'bam-kim-so-3', 'Bấm ghim số 3, bấm được 30 tờ, nhỏ gọn.', 'Cái', 25000.00, 60, '/images/products/bam-kim-so-3.jpg', NULL, 6, 1, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(32, 'KB003', 'Kim bấm số 10', 'kim-bam-so-10', 'Kim bấm số 10, 1000 kim/hộp, dùng cho bấm kim nhỏ.', 'Hộp', 12000.00, 200, '/images/products/kim-bam-so-10.jpg', NULL, 6, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(33, 'KB004', 'Kẹp bướm 19mm', 'kep-buom-19mm', 'Kẹp bướm thép, bản rộng 19mm, 12 cái/hộp.', 'Hộp', 10000.00, 150, '/images/products/kep-buom-19mm.jpg', NULL, 6, 1, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(34, 'KB005', 'Gỡ kim bấm', 'go-kim-bam', 'Dụng cụ gỡ kim bấm, nhựa ABS, lò xo thép.', 'Cái', 8000.00, 90, '/images/products/go-kim-bam.jpg', NULL, 6, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(35, 'FF001', 'Bìa lá A4', 'bia-la-a4', 'Bìa lá nhựa trong suốt, đựng tài liệu A4.', 'Cái', 3000.00, 300, '/images/products/bia-la-a4.jpg', NULL, 7, 3, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(36, 'FF002', 'Bìa còng A4 5cm', 'bia-cong-a4-5cm', 'Bìa còng nhựa, gáy 5cm, kẹp chắc chắn.', 'Cái', 35000.00, 80, '/images/products/bia-cong-a4.jpg', NULL, 7, 3, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(37, 'FF003', 'File 20 lá A4', 'file-20-la-a4', 'File nhựa 20 lá, đựng hồ sơ, tài liệu.', 'Cái', 18000.00, 120, '/images/products/file-20-la.jpg', NULL, 7, 3, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(38, 'FF004', 'Bìa trình ký A4', 'bia-trinh-ky-a4', 'Bìa trình ký nhựa, kẹp inox, khổ A4.', 'Cái', 12000.00, 110, '/images/products/bia-trinh-ky.jpg', NULL, 7, 3, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(39, 'FF005', 'Bìa nút A4', 'bia-nut-a4', 'Bìa nút nhựa, khổ A4, nhiều màu sắc.', 'Cái', 9000.00, 140, '/images/products/bia-nut-a4.jpg', NULL, 7, 3, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(40, 'BKD001', 'Băng keo trong 100Y', 'bang-keo-trong-100y', 'Băng keo trong suốt, dài 100Y, dán chắc chắn.', 'Cuộn', 12000.00, 180, '/images/products/bang-keo-trong.jpg', NULL, 8, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(41, 'BKD002', 'Băng keo giấy 2cm', 'bang-keo-giay-2cm', 'Băng keo giấy, rộng 2cm, dễ xé tay.', 'Cuộn', 8000.00, 160, '/images/products/bang-keo-giay.jpg', NULL, 8, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(42, 'BKD003', 'Keo dán giấy Thiên Long', 'keo-dan-giay-thien-long', 'Keo dán giấy dạng thỏi, không độc hại, an toàn cho trẻ em.', 'Thỏi', 10000.00, 200, '/images/products/keo-dan-giay.jpg', NULL, 8, 1, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(43, 'BKD004', 'Keo dán đa năng 60ml', 'keo-dan-da-nang-60ml', 'Keo dán đa năng, dung tích 60ml, dán được nhiều chất liệu.', 'Tuýp', 15000.00, 120, '/images/products/keo-da-nang.jpg', NULL, 8, 1, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL),
(44, 'BKD005', 'Băng keo 2 mặt 1cm', 'bang-keo-2-mat-1cm', 'Băng keo 2 mặt, rộng 1cm, dán chắc chắn.', 'Cuộn', 18000.00, 90, '/images/products/bang-keo-2-mat.jpg', NULL, 8, 2, 1, 0, '2026-01-07 05:51:35', '2026-01-07 05:51:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_before` int(11) NOT NULL,
  `quantity_after` int(11) NOT NULL,
  `reference_type` varchar(50) DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `company_name`, `email`, `phone`, `address`, `notes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Thiên Long', 'Công ty Cổ phần Thiên Long', 'contact@thienlong.com', '02838362639', 'TP. Hồ Chí Minh', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(2, 'Bic', 'Công ty TNHH Bic Việt Nam', 'info@bic.vn', '02838123456', 'TP. Hồ Chí Minh', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02'),
(3, 'Paper.vn', 'Công ty TNHH Giấy Việt', 'sales@paper.vn', '02437654321', 'Hà Nội', NULL, 1, '2026-01-01 13:16:02', '2026-01-01 13:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `gender`, `date_of_birth`, `address`, `phone`, `avatar`, `role`, `is_verified`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin@vpp.com', '$2y$10$5SJigLdReqfdRwYROBgQc.v0Lh7xaZF4igWxVV3YKhZCXP0LAEhyu', 'Administrator', NULL, NULL, NULL, NULL, NULL, 'admin', 1, '2026-01-01 13:16:02', NULL, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(2, 'khachhang1', 'customer1@example.com', '$2y$10$1vjDjQDNsw.XKGlIBmy6eeXhpGwmosb52tAZorhWH8Wj5Olq9EjkO', 'Nguyễn Văn A', 'male', NULL, '123 Đường ABC, Quận 1, TP.HCM', '0901234567', NULL, 'customer', 1, '2026-01-01 13:16:02', NULL, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL),
(3, 'khachhang2', 'customer2@example.com', '$2y$10$GD8C2Mpkuq96Gzhi.QDq1eZ1kZM/eaR.kw/MttBaw6vVCoPX6eq.S', 'Trần Thị B', 'female', NULL, '456 Đường XYZ, Quận 2, TP.HCM', '0907654321', NULL, 'customer', 1, '2026-01-01 13:16:02', NULL, '2026-01-01 13:16:02', '2026-01-01 13:16:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`),
  ADD KEY `chats_sender_id_receiver_id_index` (`sender_id`,`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_product_id_foreign` (`product_id`),
  ADD KEY `stock_movements_created_by_foreign` (`created_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
