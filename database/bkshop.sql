-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 21, 2025 lúc 05:29 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Cơ sở dữ liệu: `bkshop`
--

-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE DATABASE IF NOT EXISTS `bkshop` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bkshop`;


CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (
    `id`,
    `name`,
    `description`,
    `country`,
    `created_at`
  )
VALUES (
    1,
    'Bandai',
    'Nhà sản xuất Gundam, model kit',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    2,
    'Kotobukiya',
    'Hãng figure nổi tiếng Nhật Bản',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    3,
    'Good Smile Company',
    'Figma, Nendoroid, Scale Figure',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    4,
    'Tamiya',
    'Model xe, quân sự',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    5,
    'Max Factory',
    'Figma và figure chất lượng cao',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    6,
    'Banpresto',
    'Prize figure, affordable figures',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    7,
    'Furyu',
    'Nhà sản xuất prize figure',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    8,
    'HoYoverse',
    'Nhà phát triển Genshin Impact',
    'China',
    '2025-11-21 04:03:30'
  ),
  (
    9,
    'Toei Animation',
    'One Piece & anime brands',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    10,
    'Studio Pierrot',
    'Naruto, Bleach, Tokyo Ghoul',
    'Japan',
    '2025-11-21 04:03:30'
  ),
  (
    11,
    'Garena',
    'Liên Quân Mobile figure manufacturer',
    'Singapore',
    '2025-11-21 04:03:30'
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`)
VALUES (
    1,
    'Anime Figures',
    'Figures từ anime, manga',
    '2025-11-21 04:03:30'
  ),
  (
    2,
    'Game Figures',
    'Figures từ game',
    '2025-11-21 04:03:30'
  ),
  (
    3,
    'Robots / Mecha',
    'Robot, Gundam và mô hình cơ khí',
    '2025-11-21 04:03:30'
  ),
  (
    4,
    'Vehicles',
    'Mô hình xe, máy bay, tàu',
    '2025-11-21 04:03:30'
  ),
  (
    5,
    'PVC Figures',
    'Figures làm từ PVC',
    '2025-11-21 04:03:30'
  ),
  (
    6,
    'Scale Figure',
    'Figures tỷ lệ 1/6, 1/7, 1/4',
    '2025-11-21 04:03:30'
  ),
  (
    7,
    'Statue / Resin',
    'Tượng resin cao cấp',
    '2025-11-21 04:03:30'
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_type` enum('product', 'news') NOT NULL,
  `subject_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (
    `id`,
    `name`,
    `email`,
    `phone`,
    `subject`,
    `message`,
    `is_read`,
    `created_at`
  )
VALUES (
    1,
    'John Doe',
    'john@example.com',
    '0987654321',
    'Inquiry about Gundam',
    'Do you have MG Zaku II model available?',
    0,
    '2025-11-21 03:44:57'
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(512) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (
    `id`,
    `user_id`,
    `title`,
    `summary`,
    `content`,
    `thumbnail`,
    `published_at`,
    `is_published`,
    `created_at`,
    `updated_at`
  )
VALUES (
    1,
    NULL,
    'BKShop Grand Opening',
    'BKShop officially launches!',
    'We are thrilled to announce the opening of BKShop...',
    NULL,
    '2025-11-21 10:44:57',
    1,
    '2025-11-21 03:44:57',
    NULL
  ),
  (
    2,
    NULL,
    'Top 5 New Anime Figures in 2025',
    'A list of the most popular figures this year.',
    'Full article content here...',
    NULL,
    '2025-11-21 10:44:57',
    1,
    '2025-11-21 03:44:57',
    NULL
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum(
    'pending',
    'processing',
    'shipped',
    'completed',
    'cancelled'
  ) DEFAULT 'pending',
  `total` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `shipping_address` text DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (
    `id`,
    `user_id`,
    `status`,
    `total`,
    `shipping_address`,
    `payment_method`,
    `created_at`,
    `updated_at`
  )
VALUES (
    1,
    5,
    'completed',
    3600000.00,
    'HCM',
    'COD',
    '2025-11-21 04:26:00',
    NULL
  ),
  (
    2,
    6,
    'completed',
    2150000.00,
    'Đà Nẵng',
    'COD',
    '2025-11-21 04:27:38',
    NULL
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(12, 2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (
    `id`,
    `order_id`,
    `product_id`,
    `quantity`,
    `price`,
    `created_at`
  )
VALUES (1, 1, 1, 1, 360000.00, '2025-11-21 04:26:50'),
  (2, 2, 2, 1, 360000.00, '2025-11-21 04:28:03');
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `scale` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `price` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(12, 2) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (
    `id`,
    `category_id`,
    `brand_id`,
    `name`,
    `short_description`,
    `description`,
    `scale`,
    `material`,
    `price`,
    `sale_price`,
    `stock`,
    `is_active`,
    `created_at`,
    `updated_at`
  )
VALUES (
    1,
    NULL,
    NULL,
    'Hatsune Miku Figma',
    '1/7 scale figure of Hatsune Miku',
    NULL,
    '1/7',
    'PVC',
    2150000.00,
    1900000.00,
    30,
    1,
    '2025-11-21 03:44:57',
    NULL
  ),
  (
    2,
    NULL,
    NULL,
    'Cloud Strife Figure',
    'Final Fantasy VII hero 1/8 scale',
    NULL,
    '1/8',
    'ABS',
    2850000.00,
    NULL,
    20,
    1,
    '2025-11-21 03:44:57',
    NULL
  ),
  (
    3,
    NULL,
    NULL,
    'Gundam RX-78-2 Model Kit',
    'Master Grade Gundam model',
    NULL,
    '1/100',
    'Plastic',
    1450000.00,
    1180000.00,
    100,
    1,
    '2025-11-21 03:44:57',
    NULL
  ),
  (
    4,
    NULL,
    NULL,
    'Tamiya Porsche 911 GT3',
    'Detailed Porsche model kit',
    NULL,
    '1/24',
    'Resin',
    1650000.00,
    1380000.00,
    40,
    1,
    '2025-11-21 03:44:57',
    NULL
  ),
  (
    5,
    NULL,
    NULL,
    'Keqing Lightning Ver.',
    'Keqing 1/7 scale figure – Electro stance',
    NULL,
    '1/7',
    'PVC',
    1850000.00,
    1650000.00,
    25,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    6,
    NULL,
    NULL,
    'Ganyu Frostflake Bow',
    'Ganyu 1/7 scale with Ice Bow',
    NULL,
    '1/7',
    'PVC',
    2350000.00,
    2100000.00,
    18,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    7,
    NULL,
    NULL,
    'Ningguang Golden Court',
    'Ningguang luxurious dress edition',
    NULL,
    '1/6',
    'Resin',
    1950000.00,
    1750000.00,
    10,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    8,
    NULL,
    NULL,
    'Xiao Adeptus Yaksha',
    'Xiao spear attack pose',
    NULL,
    '1/7',
    'PVC',
    1550000.00,
    1350000.00,
    22,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    9,
    NULL,
    NULL,
    'Zhongli Vago Mundo',
    'Zhongli pillar stance figure',
    NULL,
    '1/7',
    'ABS',
    2450000.00,
    2200000.00,
    15,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    10,
    NULL,
    NULL,
    'Raiden Shogun Musou no Hitotachi',
    'Raiden Shogun sword strike edition',
    NULL,
    '1/6',
    'Resin',
    1750000.00,
    1500000.00,
    12,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    11,
    NULL,
    NULL,
    'Monkey D. Luffy Gear 5',
    'Luffy Gear Fifth white form',
    NULL,
    '1/6',
    'PVC',
    2100000.00,
    1950000.00,
    30,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    12,
    NULL,
    NULL,
    'Roronoa Zoro King of Hell',
    'Zoro Enma awakened mode',
    NULL,
    '1/6',
    'PVC',
    1650000.00,
    1400000.00,
    22,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    13,
    NULL,
    NULL,
    'Sanji Diable Jambe',
    'Sanji fire leg attack pose',
    NULL,
    '1/7',
    'PVC',
    2300000.00,
    2000000.00,
    18,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    14,
    NULL,
    NULL,
    'Shanks Red-Haired Emperor',
    'Shanks emperor stance with cape',
    NULL,
    '1/6',
    'ABS',
    2590000.00,
    2290000.00,
    12,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    15,
    NULL,
    NULL,
    'Trafalgar Law Room Ability',
    'Law with blue energy effect',
    NULL,
    '1/7',
    'PVC',
    1990000.00,
    1790000.00,
    20,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    16,
    NULL,
    NULL,
    'Uzumaki Naruto Sage Mode',
    'Naruto Sage Mode with scroll',
    NULL,
    '1/6',
    'PVC',
    1490000.00,
    NULL,
    30,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    17,
    NULL,
    NULL,
    'Sasuke Susanoo Awakening',
    'Sasuke Susanoo half-form',
    NULL,
    '1/6',
    'Resin',
    1650000.00,
    NULL,
    14,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    18,
    NULL,
    NULL,
    'Kakashi Raikiri',
    'Kakashi lightning blade attack',
    NULL,
    '1/7',
    'PVC',
    2350000.00,
    2100000.00,
    25,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    19,
    NULL,
    NULL,
    'Itachi Uchiha Crow Ver.',
    'Itachi with crow effect',
    NULL,
    '1/7',
    'PVC',
    1990000.00,
    1790000.00,
    18,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    20,
    NULL,
    NULL,
    'Madara Rinnegan War Form',
    'Madara war armor with scythe',
    NULL,
    '1/6',
    'ABS',
    2490000.00,
    2250000.00,
    15,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    21,
    NULL,
    NULL,
    'Butterfly Cyber Assassin',
    'Butterfly cyber warrior skin',
    NULL,
    '1/7',
    'PVC',
    2890000.00,
    2600000.00,
    35,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    22,
    NULL,
    NULL,
    'Murad Dimension Breaker',
    'Murad skill dash effect',
    NULL,
    '1/6',
    'ABS',
    1690000.00,
    1450000.00,
    20,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    23,
    NULL,
    NULL,
    'Ryoma Samurai Soul',
    'Ryoma katana stance',
    NULL,
    '1/7',
    'PVC',
    2050000.00,
    1850000.00,
    26,
    1,
    '2025-11-21 03:46:07',
    NULL
  ),
  (
    24,
    NULL,
    NULL,
    'Tel’Annas Twilight Archer',
    'Tel’Annas bow aim pose',
    NULL,
    '1/7',
    'PVC',
    2190000.00,
    1950000.00,
    24,
    1,
    '2025-11-21 03:46:07',
    NULL
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (
    `id`,
    `product_id`,
    `file_name`,
    `is_main`,
    `created_at`
  )
VALUES (
    1,
    1,
    'products/miku-main.jpg',
    1,
    '2025-11-21 03:44:57'
  ),
  (
    2,
    1,
    'products/miku-side.jpg',
    0,
    '2025-11-21 03:44:57'
  ),
  (
    3,
    3,
    'products/gundam-main.jpg',
    1,
    '2025-11-21 03:44:57'
  ),
  (
    4,
    4,
    'products/porsche-main.jpg',
    1,
    '2025-11-21 03:44:57'
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`)
VALUES (
    1,
    'admin',
    'Administrator',
    '2025-11-21 03:44:57'
  ),
  (
    2,
    'employee',
    'Shop staff',
    '2025-11-21 03:48:59'
  ),
  (
    3,
    'user',
    'Regular customer',
    '2025-11-21 03:48:59'
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(150) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`)
VALUES (
    1,
    'site_name',
    'BKShop – 3D Figures & Model Kits',
    '2025-11-21 03:44:57'
  ),
  (
    2,
    'site_email',
    'support@bkshop.com',
    '2025-11-21 03:44:57'
  ),
  (
    3,
    'site_phone',
    '+84-123-456-789',
    '2025-11-21 03:44:57'
  ),
  (
    4,
    'site_address',
    'Ho Chi Minh City, Vietnam',
    '2025-11-21 03:44:57'
  );
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (
    `id`,
    `role_id`,
    `email`,
    `password`,
    `full_name`,
    `avatar`,
    `phone`,
    `is_active`,
    `created_at`,
    `updated_at`
  )
VALUES (
    1,
    1,
    'admin@gmail.com',
    '$2y$10$S.qHEkoKiu.yEjG7Hf8UOumg9gBIq1lp.oeH9plNf3mSwSK67KB.2',
    'BKShop Admin',
    NULL,
    '0123456789',
    1,
    '2025-11-21 03:44:57',
    NULL
  ),
  (
    2,
    2,
    'nhanvien1@gmail.com',
    '$2y$10$1Bq3ZxM6YjJt52q8X9.8nuvCbOZ5uK4ZyIH.TxCL1Jq2V0YlKxXvW',
    'Nhân viên 1',
    NULL,
    '0901000001',
    1,
    '2025-11-21 03:49:37',
    NULL
  ),
  (
    3,
    2,
    'nhanvien2@gmail.com',
    '$2y$10$1Bq3ZxM6YjJt52q8X9.8nuvCbOZ5uK4ZyIH.TxCL1Jq2V0YlKxXvW',
    'Nhân viên 2',
    NULL,
    '0901000002',
    1,
    '2025-11-21 03:49:37',
    NULL
  ),
  (
    4,
    2,
    'nhanvien3@gmail.com',
    '$2y$10$1Bq3ZxM6YjJt52q8X9.8nuvCbOZ5uK4ZyIH.TxCL1Jq2V0YlKxXvW',
    'Nhân viên 3',
    NULL,
    '0901000003',
    1,
    '2025-11-21 03:49:37',
    NULL
  ),
  (
    5,
    3,
    'user1@gmail.com',
    '$2y$10$1Bq3ZxM6YjJt52q8X9.8nuvCbOZ5uK4ZyIH.TxCL1Jq2V0YlKxXvW',
    'Khách hàng 1',
    NULL,
    '0902000001',
    1,
    '2025-11-21 03:49:37',
    NULL
  ),
  (
    6,
    3,
    'user2@gmail.com',
    '$2y$10$1Bq3ZxM6YjJt52q8X9.8nuvCbOZ5uK4ZyIH.TxCL1Jq2V0YlKxXvW',
    'Khách hàng 2',
    NULL,
    '0902000002',
    1,
    '2025-11-21 03:49:37',
    NULL
  ),
  (
    7,
    3,
    'user3@gmail.com',
    '$2y$10$1Bq3ZxM6YjJt52q8X9.8nuvCbOZ5uK4ZyIH.TxCL1Jq2V0YlKxXvW',
    'Khách hàng 3',
    NULL,
    '0902000003',
    1,
    '2025-11-21 03:49:37',
    NULL
  );
--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
ADD PRIMARY KEY (`id`);
--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);
--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
ADD PRIMARY KEY (`id`);
--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `idx_comments_subject` (`subject_type`, `subject_id`);
--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
ADD PRIMARY KEY (`id`);
--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);
--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `idx_products_name` (`name`);
--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);
--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);
--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);
--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);
--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 12;
--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;
--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 25;
--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;
--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;
--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE
SET NULL;
--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE
SET NULL;
--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE
SET NULL;
--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE
SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE
SET NULL;
--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;