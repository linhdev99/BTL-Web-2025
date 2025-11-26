-- ============================================================================
-- COMPLETE DATABASE SETUP FOR BTL-Web-2025 (TOY SHOP)
-- ============================================================================
-- Database Name: toy_shop
-- Collation: utf8mb4_unicode_ci
-- Created: 2025-11-25
-- ============================================================================

DROP DATABASE IF EXISTS toy_shop;
CREATE DATABASE toy_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE toy_shop;

-- ============================================================================
-- TABLE 1: users
-- ============================================================================
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20),
  `address` TEXT,
  `role_id` TINYINT DEFAULT 3 COMMENT '1=admin, 2=staff, 3=customer',
  `role` ENUM('admin','staff','customer') DEFAULT 'customer',
  `is_active` TINYINT(1) DEFAULT 1,
  `rememberToken` VARCHAR(255),
  `username` VARCHAR(100) UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 2: categories
-- ============================================================================
CREATE TABLE `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT,
  `parent_id` INT,
  `ordering` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_slug` (`slug`),
  KEY `idx_parent_id` (`parent_id`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 3: products
-- ============================================================================
CREATE TABLE `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `sku` VARCHAR(50) UNIQUE,
  `description` TEXT,
  `content` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `sale_price` DECIMAL(10,2),
  `stock` INT DEFAULT 0,
  `image` VARCHAR(255),
  `is_featured` TINYINT(1) DEFAULT 0,
  `is_new` TINYINT(1) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `status` ENUM('active','inactive') DEFAULT 'active',
  `views` INT DEFAULT 0,
  `meta_title` VARCHAR(255),
  `meta_description` TEXT,
  `meta_keywords` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_slug` (`slug`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_is_featured` (`is_featured`),
  KEY `idx_is_new` (`is_new`),
  KEY `idx_is_active` (`is_active`),
  FULLTEXT `ft_search` (`name`, `description`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 4: orders
-- ============================================================================
CREATE TABLE `orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT,
  `order_code` VARCHAR(50) NOT NULL UNIQUE,
  `customer_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_phone` VARCHAR(20) NOT NULL,
  `customer_address` TEXT NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `payment_method` ENUM('cod','bank_transfer','momo','vnpay') DEFAULT 'cod',
  `payment_status` ENUM('pending','paid','failed') DEFAULT 'pending',
  `status` ENUM('pending','processing','completed','cancelled') DEFAULT 'pending',
  `note` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_order_code` (`order_code`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 5: order_items
-- ============================================================================
CREATE TABLE `order_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `product_id` INT,
  `product_name` VARCHAR(255) NOT NULL,
  `product_sku` VARCHAR(50),
  `product_image` VARCHAR(255),
  `price` DECIMAL(10,2) NOT NULL,
  `quantity` INT NOT NULL,
  `total` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 6: carts
-- ============================================================================
CREATE TABLE `carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_product` (`user_id`, `product_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_carts_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 7: news
-- ============================================================================
CREATE TABLE `news` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `summary` TEXT,
  `content` TEXT NOT NULL,
  `thumbnail` VARCHAR(255),
  `published_at` DATETIME,
  `is_published` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_slug` (`slug`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_published_at` (`published_at`),
  FULLTEXT `ft_search` (`title`, `content`),
  CONSTRAINT `fk_news_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 8: contacts
-- ============================================================================
CREATE TABLE `contacts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20),
  `subject` VARCHAR(255),
  `message` TEXT NOT NULL,
  `status` ENUM('unread','read','replied') DEFAULT 'unread',
  `admin_reply` TEXT,
  `replied_at` DATETIME,
  `replied_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_email` (`email`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_replied_by` (`replied_by`),
  CONSTRAINT `fk_contacts_replied_by` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 9: faq_categories
-- ============================================================================
CREATE TABLE `faq_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_slug` (`slug`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 10: faq (Static FAQ)
-- ============================================================================
CREATE TABLE `faq` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT,
  `question` TEXT NOT NULL,
  `answer` TEXT NOT NULL,
  `ordering` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_ordering` (`ordering`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_faq_category` FOREIGN KEY (`category_id`) REFERENCES `faq_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 11: faq_questions (User Questions)
-- ============================================================================
CREATE TABLE `faq_questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT,
  `category_id` INT,
  `question` TEXT NOT NULL,
  `status` ENUM('pending','answered','closed') DEFAULT 'pending',
  `views` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_faq_questions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_faq_questions_category` FOREIGN KEY (`category_id`) REFERENCES `faq_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 12: faq_comments (Comments/Answers for FAQ Questions)
-- ============================================================================
CREATE TABLE `faq_comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question_id` INT NOT NULL,
  `user_id` INT,
  `content` TEXT NOT NULL,
  `is_admin` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_question_id` (`question_id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_faq_comments_question` FOREIGN KEY (`question_id`) REFERENCES `faq_questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_faq_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE 13: settings
-- ============================================================================
CREATE TABLE `settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(255) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SAMPLE DATA
-- ============================================================================

-- Insert admin, staff, and customer users
INSERT INTO `users` (`email`, `password`, `full_name`, `role_id`, `role`, `is_active`) VALUES
('admin@toyshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 1, 'admin', 1),
('staff@toyshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff User', 2, 'staff', 1),
('customer@toyshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Customer User', 3, 'customer', 1);

-- Insert sample categories
INSERT INTO `categories` (`name`, `slug`, `description`, `ordering`, `is_active`) VALUES
('Mô hình Gundam', 'mo-hinh-gundam', 'Các mô hình Gundam chính hãng từ Bandai', 1, 1),
('Mô hình xe hơi', 'mo-hinh-xe-hoi', 'Mô hình xe hơi tỉ lệ 1:18, 1:24, 1:64', 2, 1),
('Mô hình nhân vật', 'mo-hinh-nhan-vat', 'Figure và mô hình nhân vật anime, game', 3, 1),
('Mô hình máy bay', 'mo-hinh-may-bay', 'Mô hình máy bay quân sự và dân dụng', 4, 1),
('Mô hình tàu thuyền', 'mo-hinh-tau-thuyen', 'Mô hình tàu chiến và tàu thuyền', 5, 1);

-- Insert sample products
INSERT INTO `products` (`category_id`, `name`, `slug`, `sku`, `description`, `content`, `price`, `sale_price`, `stock`, `is_featured`, `is_new`, `is_active`) VALUES
(1, 'MG Gundam RX-78-2 Ver 3.0', 'mg-gundam-rx-78-2-ver-3-0', 'GUNDAM-001', 'Mô hình Gundam tỉ lệ 1/100 Master Grade', '<p>Chi tiết cao, dễ lắp ráp</p>', 850000, 750000, 20, 1, 1, 1),
(1, 'RG Gundam Unicorn', 'rg-gundam-unicorn', 'GUNDAM-002', 'Real Grade Unicorn Gundam', '<p>Khung nội bộ chi tiết</p>', 650000, NULL, 15, 1, 0, 1),
(2, 'Lamborghini Aventador 1:18', 'lamborghini-aventador-1-18', 'CAR-001', 'Mô hình xe Lamborghini Aventador', '<p>Hợp kim cao cấp</p>', 1200000, 1050000, 10, 1, 1, 1),
(3, 'Nendoroid Naruto Uzumaki', 'nendoroid-naruto-uzumaki', 'FIG-001', 'Figure Nendoroid Naruto', '<p>Nhiều phụ kiện</p>', 550000, 500000, 30, 1, 0, 1),
(4, 'F-16 Fighting Falcon 1:48', 'f-16-fighting-falcon-1-48', 'PLANE-001', 'Mô hình máy bay chiến đấu F-16', '<p>Chi tiết cao</p>', 950000, 850000, 8, 0, 1, 1);

-- Insert sample news
INSERT INTO `news` (`user_id`, `title`, `slug`, `summary`, `content`, `is_published`, `published_at`) VALUES
(1, 'Khai trương cửa hàng mô hình', 'khai-truong-cua-hang-mo-hinh', 'Chúng tôi vui mừng khai trương cửa hàng mô hình', '<p>Khai trương cửa hàng mô hình với nhiều ưu đãi</p>', 1, NOW()),
(1, 'Hướng dẫn lắp ráp Gundam', 'huong-dan-lap-rap-gundam', 'Hướng dẫn chi tiết lắp ráp Gundam', '<p>Bước 1: Chuẩn bị dụng cụ</p><p>Bước 2: Lắp ráp</p>', 1, NOW());

-- Insert FAQ categories
INSERT INTO `faq_categories` (`name`, `slug`, `is_active`) VALUES
('Sản phẩm', 'san-pham', 1),
('Đặt hàng', 'dat-hang', 1),
('Thanh toán', 'thanh-toan', 1),
('Vận chuyển', 'van-chuyen', 1),
('Chính sách', 'chinh-sach', 1);

-- Insert sample FAQ
INSERT INTO `faq` (`category_id`, `question`, `answer`, `ordering`, `is_active`) VALUES
(1, 'Sản phẩm có bảo hành không?', 'Tất cả sản phẩm được bảo hành từ 6-12 tháng', 1, 1),
(2, 'Làm thế nào để đặt hàng?', 'Bạn có thể đặt hàng qua website hoặc gọi hotline', 1, 1),
(3, 'Hỗ trợ thanh toán nào?', 'Hỗ trợ COD, chuyển khoản, MoMo, ZaloPay', 1, 1),
(4, 'Thời gian giao hàng?', 'Giao hàng từ 2-5 ngày tùy theo khu vực', 1, 1),
(5, 'Chính sách đổi trả?', 'Đổi trả trong 7 ngày nếu sản phẩm còn nguyên vẹn', 1, 1);

-- Insert settings
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Toy Model Shop'),
('site_email', 'contact@toyshop.com'),
('site_phone', '0123456789'),
('site_address', '123 Đường ABC, Quận 1, TP.HCM'),
('site_description', 'Cửa hàng mô hình đồ chơi chất lượng cao'),
('facebook_url', 'https://facebook.com/toyshop'),
('instagram_url', 'https://instagram.com/toyshop'),
('youtube_url', 'https://youtube.com/toyshop');

-- ============================================================================
-- DONE!
-- ============================================================================
