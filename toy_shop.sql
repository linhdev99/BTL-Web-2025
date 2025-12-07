-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 07, 2025 lúc 05:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `toy_shop`
--
CREATE DATABASE IF NOT EXISTS toy_shop;
-- --------------------------------------------------------
USE `toy_shop`;
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `about`
--

INSERT INTO `about` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'name1', 'Nguyễn Văn A', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(2, 'mssv1', '22120001', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(3, 'mission1', 'Trưởng nhóm - Thiết kế giao diện & Lập trình Frontend', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(4, 'name2', 'Huỳnh Phạm Phước Linh', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(5, 'mssv2', '1710165', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(6, 'mission2', 'Phát triển Backend - Quản lý CSDL', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(7, 'name3', 'Lê Văn C', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(8, 'mssv3', '22120003', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(9, 'mission3', 'Tester - Viết tài liệu & Báo cáo', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(10, 'about', '<div class=\"about-content bg-white shadow-sm rounded-4 p-5 mb-5 border border-light-subtle\">\r\n    <div class=\"text-center mb-4\">\r\n      <div class=\"mb-3\">\r\n        <i class=\"bi bi-gem text-primary display-5\"></i>\r\n      </div>\r\n      <h2 class=\"fw-bold text-primary\">BK Figure Lab - Nơi hội tụ đam mê</h2>\r\n      <p class=\"text-muted mt-2 fs-5\">\r\n        Cùng nhau kiến tạo thế giới figure chính hãng đầy cảm hứng và sáng tạo!\r\n      </p>\r\n    </div>\r\n\r\n    <div class=\"row align-items-center\">\r\n      <div class=\"col-lg-6 mb-4 mb-lg-0\">\r\n        <p class=\"lead\">\r\n          <strong>BK Figure Lab</strong> là cửa hàng chuyên cung cấp các sản phẩm figure và mô hình sưu tầm chính hãng,\r\n          dành cho cộng đồng người yêu thích văn hóa Nhật Bản, anime, game và nghệ thuật mô hình.\r\n        </p>\r\n        <p>\r\n          Chúng tôi mang đến cho bạn những sản phẩm đến từ các thương hiệu hàng đầu như\r\n          <strong>Bandai</strong>, <strong>Good Smile Company</strong>, <strong>Kotobukiya</strong> và nhiều thương hiệu danh tiếng khác.\r\n        </p>\r\n        <p>\r\n          Không chỉ là nơi mua sắm, BK Figure Lab còn là <strong>cộng đồng của đam mê</strong>,\r\n          nơi bạn có thể chia sẻ sở thích, học hỏi và giao lưu cùng những người cùng chí hướng.\r\n        </p>\r\n      </div>\r\n\r\n      <div class=\"col-lg-6 text-center\">\r\n        <img src=\"https://picsum.photos/800/400?random=20\" alt=\"BK Figure Lab About\" class=\"img-fluid rounded-4 shadow-sm\">\r\n      </div>\r\n    </div>\r\n\r\n    <hr class=\"my-5\">\r\n\r\n    <div class=\"row gy-4\">\r\n      <div class=\"col-md-6\">\r\n        <div class=\"p-4 bg-light rounded-4 h-100 shadow-sm\">\r\n          <h3 class=\"text-primary fw-bold mb-3\">\r\n            <i class=\"bi bi-bullseye me-2\"></i>Tầm nhìn\r\n          </h3>\r\n          <p>\r\n            Trở thành cửa hàng figure uy tín hàng đầu Việt Nam, nơi các fan hâm mộ\r\n            có thể tìm thấy những sản phẩm yêu thích và kết nối với cộng đồng cùng đam mê.\r\n          </p>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-md-6\">\r\n        <div class=\"p-4 bg-light rounded-4 h-100 shadow-sm\">\r\n          <h3 class=\"text-primary fw-bold mb-3\">\r\n            <i class=\"bi bi-lightning-charge-fill me-2\"></i>Sứ mệnh\r\n          </h3>\r\n          <p>\r\n            Cung cấp sản phẩm chính hãng, chất lượng cao với giá cả hợp lý — đồng thời lan tỏa\r\n            tinh thần sáng tạo, đam mê và gắn kết trong cộng đồng người yêu figure tại Việt Nam.\r\n          </p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n    <div class=\"text-center mt-5\">\r\n      <img src=\"https://picsum.photos/1000/400?random=4\" alt=\"About BK Figure Lab\" class=\"img-fluid rounded-4 shadow\">\r\n      <p class=\"mt-3 text-muted small fst-italic\">\r\n        “Đam mê không chỉ để ngắm nhìn — mà để sẻ chia.”\r\n      </p>\r\n    </div>\r\n  </div>', '2025-12-07 02:52:52', '2025-12-07 04:15:54'),
(11, 'title1', 'Nhóm phát triển BK Figure Lab', '2025-12-07 03:09:43', '2025-12-07 04:15:54'),
(12, 'subtitle1', 'Chúng tôi là những sinh viên đam mê công nghệ và yêu thích thế giới mô hình.', '2025-12-07 03:09:43', '2025-12-07 04:15:54'),
(13, 'subtitle2', 'BK Figure Lab - Nơi hội tụ đam mê', '2025-12-07 03:09:43', '2025-12-07 04:15:54'),
(14, 'files', '', '2025-12-07 03:59:41', '2025-12-07 04:15:54'),
(15, 'avatar1', 'https://i.ibb.co/RkD9VHSL/Capybara.jpg', '2025-12-07 04:05:37', '2025-12-07 04:15:54'),
(16, 'avatar2', 'https://i.ibb.co/zWPgx4SP/461442910-843306404623312-6429687454985045364-n.jpg', '2025-12-07 04:05:37', '2025-12-07 04:15:54'),
(17, 'avatar3', 'https://i.ibb.co/RkD9VHSL/Capybara.jpg', '2025-12-07 04:05:37', '2025-12-07 04:15:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `parent_id`, `ordering`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mô hình Gundam', 'mo-hinh-gundam', 'Các mô hình Gundam chính hãng từ Bandai', NULL, 1, 1, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(2, 'Mô hình xe hơi', 'mo-hinh-xe-hoi', 'Mô hình xe hơi tỉ lệ 1:18, 1:24, 1:64', NULL, 2, 1, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(3, 'Mô hình nhân vật', 'mo-hinh-nhan-vat', 'Figure và mô hình nhân vật anime, game', NULL, 3, 1, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(4, 'Mô hình máy bay', 'mo-hinh-may-bay', 'Mô hình máy bay quân sự và dân dụng', NULL, 4, 1, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(5, 'Mô hình tàu thuyền', 'mo-hinh-tau-thuyen', 'Mô hình tàu chiến và tàu thuyền', NULL, 5, 1, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(6, 'mo1', 'mo1', '', NULL, 0, 1, '2025-11-26 09:21:29', '2025-11-26 09:21:29'),
(7, 'mo1', 'mo1-1764148941', '', NULL, 0, 1, '2025-11-26 09:22:21', '2025-11-26 09:22:21'),
(8, 'mo2', 'mo2', '', NULL, 0, 1, '2025-11-26 09:22:35', '2025-11-26 09:22:35'),
(9, 'ak1', 'ak1', '', NULL, 0, 1, '2025-11-26 09:36:35', '2025-11-26 09:36:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `admin_reply` text DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `replied_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `status`, `admin_reply`, `replied_at`, `replied_by`, `created_at`, `updated_at`) VALUES
(1, '123', '123@gmail.com', '', '1', '1', 1, 'unread', NULL, NULL, NULL, '2025-11-26 16:25:24', '2025-11-26 16:28:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `ordering` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faq`
--

INSERT INTO `faq` (`id`, `category_id`, `question`, `answer`, `ordering`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, '<b><u>Shop có hỗ trợ ship COD toàn quốc không?</u></b>', '<font color=\"#b5d6a5\"><b><u>Có</u></b></font>. Shop hỗ trợ ship COD toàn quốc và khách được kiểm tra hàng trước khi thanh toán.', 1, 1, '2025-12-06 08:45:08', '2025-11-22 09:59:49'),
(2, 2, 'Thời gian giao hàng mất bao lâu?', 'TP.HCM: 1-2 ngày. Miền Nam: 2-4 ngày. Miền Trung và Miền Bắc: 3-6 ngày.', 2, 1, '2025-12-06 08:45:08', '2025-11-22 08:53:39'),
(3, 6, 'Figure tại shop có phải hàng chính hãng không?', 'Shop chỉ bán hàng chính hãng 100%, đầy đủ tem mác và kiểm định chất lượng.', 3, 1, '2025-12-06 08:45:08', '2025-11-22 08:53:50'),
(4, 4, 'Sản phẩm lỗi có được đổi trả không?', 'Bạn có thể đổi sản phẩm trong 24 giờ nếu lỗi do nhà sản xuất.', 4, 1, '2025-12-06 08:45:08', '2025-11-22 09:57:29'),
(5, 2, 'Shop có cho kiểm tra hàng trước khi nhận không?', 'Tất cả đơn hàng đều được phép xem hàng trước khi thanh toán với shipper.', 5, 1, '2025-12-06 08:45:08', '2025-11-22 09:57:38'),
(6, 6, 'Giá sản phẩm có thay đổi theo thị trường không?', 'Shop cam kết giữ giá ổn định, không tự ý tăng giá kể cả khi thị trường biến động.', 6, 1, '2025-12-06 08:45:08', '2025-11-22 09:57:53'),
(7, 3, 'Shop có chương trình giảm giá không?', 'Có. Các chương trình giảm giá sẽ được cập nhật thường xuyên dành cho khách thân thiết.', 7, 1, '2025-12-06 08:45:08', '2025-11-22 09:57:58'),
(8, 6, 'Những loại figure nào shop đang bán?', 'Shop bán Anime figure, Game figure, Nendoroid, Scale figure, Resin figure và model kit.', 8, 1, '2025-12-06 08:45:08', '2025-11-22 09:58:08'),
(9, 6, 'Shop có nhận order sản phẩm không có sẵn không?', '<font color=\"#6ba54a\">Có. Shop nhận order theo yêu cầu, chỉ cần gửi hình hoặc link sản phẩm.</font>', 9, 1, '2025-12-06 08:45:08', '2025-11-22 09:58:32'),
(10, 5, '<font color=\"#b5d6a5\">Địa chỉ cửa hàng là ở đâu?</font>', '<font color=\"#c67ba5\" style=\"\">Lý Thường Kiệt, Phường 14, Quận 10, TP.HCM.</font>', 10, 0, '2025-12-06 08:45:08', '2025-11-23 22:45:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `name`, `slug`, `color`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Khác', 'khac', '#9b59b6', 1, '2025-12-06 08:45:01', '2025-12-06 08:53:34'),
(2, 'Vận chuyển - Giao hàng', 'van-chuyen-giao-hang', '#3498db', 1, '2025-12-06 08:45:01', '2025-12-06 08:53:34'),
(3, 'Thanh toán', 'thanh-toan', '#e67e22', 1, '2025-12-06 08:45:01', '2025-12-06 08:53:34'),
(4, 'Đổi trả - Bảo hành', 'doi-tra-bao-hanh', '#2ecc71', 1, '2025-12-06 08:45:01', '2025-12-06 08:53:34'),
(5, 'Thông tin cửa hàng', 'thong-tin-cua-hang', '#f1c40f', 1, '2025-12-06 08:45:01', '2025-12-06 08:53:34'),
(6, 'Về sản phẩm', 've-san-pham', '#e74c3c', 1, '2025-12-06 08:45:01', '2025-12-06 08:53:34'),
(9, 'Testing!', 'testing', '#52b9c7', 1, '2025-12-06 09:35:54', '2025-12-06 09:50:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faq_comments`
--

CREATE TABLE `faq_comments` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faq_comments`
--

INSERT INTO `faq_comments` (`id`, `question_id`, `user_id`, `content`, `is_admin`, `created_at`) VALUES
(1, 1, 1, 'Dạ shop có giao toàn quốc nha bạn ❤️', 0, '2025-11-22 03:05:00'),
(2, 1, 3, 'Mình ở Đà Nẵng nhận hàng trong 3 ngày thôi, khá nhanh 👍', 0, '2025-11-22 03:06:10'),
(3, 1, 2, 'Ship COD được kiểm tra hàng trước ạ?', 0, '2025-11-22 03:07:42'),
(4, 2, 1, 'Dạ thời gian giao hàng tùy khu vực, TP.HCM tầm 1–2 ngày ạ 🚚', 0, '2025-11-22 04:01:02'),
(5, 2, 8, 'Mình nhận hàng ở Huế sau 4 ngày, hàng nguyên vẹn 💯', 0, '2025-11-22 04:02:40'),
(6, 3, 6, 'Shop có bán figure chính hãng Bandai không?', 0, '2025-11-22 05:00:00'),
(7, 3, 1, 'Tất cả đều chính hãng 100%, có tem kiểm định rõ ràng ạ ✅', 0, '2025-11-22 05:00:50'),
(8, 4, 8, 'Nếu sản phẩm lỗi thì đổi như thế nào ạ?', 0, '2025-11-22 06:00:00'),
(9, 5, 1, 'Dạ có ạ, bạn được mở hộp kiểm tra trước khi thanh toán nha ✨', 0, '2025-11-22 07:00:40'),
(10, 6, 1, 'Dạ shop giữ giá ổn định, không tăng dù khan hàng nha 🔒', 0, '2025-11-22 08:00:40'),
(11, 9, 5, 'có nhe', 0, '2025-12-06 12:27:53'),
(12, 9, 5, 'quạc quạc', 0, '2025-12-06 12:27:59'),
(15, 10, 5, 'abc', 0, '2025-12-06 17:37:16'),
(16, 10, 5, 'thêm comment ', 0, '2025-12-06 19:44:10'),
(17, 10, 5, '123123xczxc', 0, '2025-12-06 19:44:22'),
(18, 1, 5, '❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️', 0, '2025-12-06 19:45:22'),
(19, 10, 5, '❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️', 0, '2025-12-06 19:45:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faq_questions`
--

CREATE TABLE `faq_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `status` enum('pending','answered','closed') DEFAULT 'pending',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faq_questions`
--

INSERT INTO `faq_questions` (`id`, `user_id`, `category_id`, `question`, `status`, `views`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Shop có hỗ trợ ship COD toàn quốc không ạ?', 'answered', 47, '2025-11-22 03:00:00', '2025-12-06 19:45:22'),
(2, 3, 2, 'Nếu mình ở Hà Nội thì bao lâu nhận được hàng?', 'answered', 33, '2025-11-22 03:01:00', '2025-12-06 08:45:19'),
(3, 5, 2, 'Có thể chọn đơn vị vận chuyển không vậy shop?', 'pending', 0, '2025-11-22 03:02:00', '2025-12-06 08:45:19'),
(4, 2, 2, 'Phí ship được tính như thế nào ạ?', 'answered', 27, '2025-11-22 03:03:00', '2025-12-06 08:45:19'),
(5, 6, 2, 'Shop có giao hàng vào Chủ Nhật không?', 'answered', 19, '2025-11-22 03:04:00', '2025-12-06 08:45:19'),
(6, 7, 3, 'Shop chấp nhận thanh toán qua những hình thức nào?', 'answered', 54, '2025-11-22 04:00:00', '2025-12-06 08:45:19'),
(7, 4, 3, 'Có thể thanh toán khi nhận hàng (COD) không?', 'answered', 42, '2025-11-22 04:01:00', '2025-12-06 08:45:19'),
(8, 3, 3, 'Shop có hỗ trợ chuyển khoản ngân hàng không ạ?', 'answered', 35, '2025-11-22 04:02:00', '2025-12-06 08:45:19'),
(9, 5, 3, 'Có thể dùng ví MOMO để thanh toán không?', 'closed', 38, '2025-11-22 04:03:00', '2025-12-06 12:28:15'),
(10, 2, 3, 'Khi thanh toán online mà lỗi thì xử lý thế nào?', 'pending', 21, '2025-11-22 04:04:00', '2025-12-07 03:48:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `user_id`, `title`, `slug`, `summary`, `content`, `thumbnail`, `published_at`, `is_published`, `created_at`, `updated_at`) VALUES
(2, 1, 'Hướng dẫn lắp ráp Gundam', 'huong-dan-lap-rap-gundam', 'Hướng dẫn chi tiết lắp ráp Gundam', '<p>Bước 1: Chuẩn bị dụng cụ</p><p>Bước 2: Lắp ráp</p>', NULL, '2025-11-25 20:17:44', 1, '2025-11-25 13:17:44', '2025-11-25 13:17:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `total_amount` decimal(20,2) NOT NULL,
  `payment_method` enum('cod','bank_transfer','momo','vnpay') DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_amount`, `payment_method`, `payment_status`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'ORD-20251126-2E3DBF', '123', '234234234@gmail.com', '0987654321', '123', 6260000.00, 'cod', 'pending', 'cancelled', '', '2025-11-26 08:50:24', '2025-11-26 08:51:12'),
(2, 4, 'ORD-20251126-D474B3', '123', '123@gmail.com', '123', '123', 100000001050000.00, 'cod', 'paid', 'pending', '', '2025-11-26 09:56:18', '2025-11-26 09:59:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(50) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(20,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `product_image`, `price`, `quantity`, `total`, `created_at`) VALUES
(1, 1, 2, 'RG Gundam Unicorn', NULL, NULL, 650000.00, 8, 5200000.00, '2025-11-26 08:50:24'),
(2, 1, 3, 'Lamborghini Aventador 1:18', NULL, NULL, 1050000.00, 1, 1050000.00, '2025-11-26 08:50:24'),
(3, 1, 6, 'mô hình đồ chơi 1', NULL, NULL, 10000.00, 1, 10000.00, '2025-11-26 08:50:24'),
(4, 2, 7, 'Đồ chơi nguyên khối', NULL, NULL, 100000000000000.00, 1, 100000000000000.00, '2025-11-26 09:56:18'),
(5, 2, 3, 'Lamborghini Aventador 1:18', NULL, NULL, 1050000.00, 1, 1050000.00, '2025-11-26 09:56:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `price` decimal(20,2) NOT NULL,
  `sale_price` decimal(20,2) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_new` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `status` enum('active','inactive') DEFAULT 'active',
  `views` int(11) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `description`, `content`, `price`, `sale_price`, `stock`, `image`, `is_featured`, `is_new`, `is_active`, `status`, `views`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(2, 1, 'RG Gundam Unicorn', 'rg-gundam-unicorn', 'GUNDAM-002', 'Real Grade Unicorn Gundam', '<p>Khung nội bộ chi tiết</p>', 650000.00, NULL, 15, NULL, 1, 0, 1, 'active', 0, NULL, NULL, NULL, '2025-11-25 13:17:44', '2025-11-26 08:51:12'),
(3, 2, 'Lamborghini Aventador 1:18', 'lamborghini-aventador-1-18', 'CAR-001', 'Mô hình xe Lamborghini Aventador', '<p>Hợp kim cao cấp</p>', 1200000.00, 1050000.00, 9, NULL, 1, 1, 1, 'active', 0, NULL, NULL, NULL, '2025-11-25 13:17:44', '2025-11-26 09:56:18'),
(4, 3, 'Nendoroid Naruto Uzumaki', 'nendoroid-naruto-uzumaki', 'FIG-001', 'Figure Nendoroid Naruto', '<p>Nhiều phụ kiện</p>', 550000.00, 500000.00, 30, NULL, 1, 0, 1, 'active', 0, NULL, NULL, NULL, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(5, 4, 'F-16 Fighting Falcon 1:48', 'f-16-fighting-falcon-1-48', 'PLANE-001', 'Mô hình máy bay chiến đấu F-16', '<p>Chi tiết cao</p>', 950000.00, 850000.00, 8, NULL, 0, 1, 1, 'active', 0, NULL, NULL, NULL, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(6, 4, 'mô hình đồ chơi 1', 'mo-hinh-do-choi-1', 'BanhMI_001', '', '', 10000.00, NULL, 10000, 'products/6926bf01ca300_1764146945.jpg', 0, 0, 1, 'active', 0, NULL, NULL, NULL, '2025-11-26 08:49:05', '2025-11-26 08:51:12'),
(7, 1, 'Đồ chơi nguyên khối', 'do-choi-nguyen-khoi', '3123', '123', '123', 100000000000000.00, NULL, 999999, NULL, 0, 0, 1, 'active', 0, NULL, NULL, NULL, '2025-11-26 09:06:19', '2025-11-26 09:56:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Toy Model Shop', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(2, 'site_email', 'contact@toyshop.com', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(3, 'site_phone', '0123456789', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(4, 'site_address', '123 Đường ABC, Quận 1, TP.HCM', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(5, 'site_description', 'Cửa hàng mô hình đồ chơi chất lượng cao', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(6, 'facebook_url', 'https://facebook.com/toyshop', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(7, 'instagram_url', 'https://instagram.com/toyshop', '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(8, 'youtube_url', 'https://youtube.com/toyshop', '2025-11-25 13:17:44', '2025-11-25 13:17:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text' COMMENT 'text, textarea, image, email, phone, url',
  `setting_group` varchar(50) DEFAULT 'general' COMMENT 'general, contact, about, social',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `setting_group`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Toy shop', 'text', 'general', 'Tên cửa hàng', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(2, 'site_tagline', 'For True Figure Lovers', 'text', 'general', 'Slogan cửa hàng', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(3, 'site_logo', '/assets/img/logo.png', 'image', 'general', 'Logo cửa hàng', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(4, 'contact_address', '268 Lý Thường Kiệt, Phường 14, Quận 10, TP.HCM', 'text', 'contact', 'Địa chỉ cửa hàng', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(5, 'contact_phone', '0123 456 789', 'phone', 'contact', 'Số điện thoại', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(6, 'contact_email', 'contact@bkfigurelab.vn', 'email', 'contact', 'Email liên hệ', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(7, 'contact_hotline', '1900 xxxx', 'phone', 'contact', 'Hotline hỗ trợ', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(8, 'contact_working_hours', 'Thứ 2 - Thứ 7: 9:00 - 21:00\r\nChủ nhật: 10:00 - 20:00', 'textarea', 'contact', 'Giờ làm việc', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(9, 'about_title', 'Về chúng tôi', 'text', 'about', 'Tiêu đề trang giới thiệu', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(10, 'about_content', '<h3>BK Figure Lab - Nơi hội tụ đam mê</h3>\r\n<p>Chào mừng bạn đến với BK Figure Lab - cửa hàng chuyên cung cấp các sản phẩm figure, mô hình chính hãng chất lượng cao!</p>\r\n<p>Với niềm đam mê và tình yêu với các sản phẩm figure, chúng tôi cam kết mang đến cho khách hàng những sản phẩm tốt nhất từ các thương hiệu nổi tiếng như Bandai, Good Smile Company, Kotobukiya...</p>\r\n<h4>Tầm nhìn</h4>\r\n<p>Trở thành cửa hàng figure uy tín hàng đầu Việt Nam, nơi các fan hâm mộ có thể tìm thấy những sản phẩm yêu thích của mình.</p>\r\n<h4>Sứ mệnh</h4>\r\n<p>Cung cấp sản phẩm chính hãng, chất lượng cao với giá cả hợp lý. Tạo dựng cộng đồng người yêu thích figure tại Việt Nam.</p>', 'textarea', 'about', 'Nội dung trang giới thiệu (HTML)', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(11, 'social_facebook', 'https://facebook.com/bkfigurelab', 'url', 'social', 'Link Facebook', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(12, 'social_instagram', 'https://instagram.com/bkfigurelab', 'url', 'social', 'Link Instagram', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(13, 'social_youtube', '', 'url', 'social', 'Link Youtube', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(14, 'social_tiktok', '', 'url', 'social', 'Link TikTok', '2025-11-26 15:56:57', '2025-11-26 16:21:28'),
(15, 'footer_copyright', '© {year} BK Figure Lab. All rights reserved.', 'text', 'general', 'Bản quyền footer ({year} sẽ được thay bằng năm hiện tại)', '2025-11-26 15:56:57', '2025-11-26 16:21:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role_id` tinyint(4) DEFAULT 3 COMMENT '1=admin, 2=staff, 3=customer',
  `role` enum('admin','staff','customer') DEFAULT 'customer',
  `is_active` tinyint(1) DEFAULT 1,
  `rememberToken` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `avatar`, `password`, `full_name`, `phone`, `address`, `role_id`, `role`, `is_active`, `rememberToken`, `username`, `created_at`, `updated_at`) VALUES
(1, 'admin@toyshop.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', NULL, NULL, 1, 'admin', 1, NULL, NULL, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(2, 'staff@toyshop.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff User', NULL, NULL, 2, 'staff', 1, NULL, NULL, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(3, 'customer@toyshop.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Customer User', NULL, NULL, 3, 'customer', 1, NULL, NULL, '2025-11-25 13:17:44', '2025-11-25 13:17:44'),
(4, '123@gmail.com', NULL, '$2y$12$TI1yMA.fC6h02jLhBxBSe.5EXX/cO6zqQF1rm8OE0l7XHw4d/V9cK', 'Quách Nguyễn Hoàng', NULL, NULL, 3, 'customer', 1, NULL, NULL, '2025-11-26 09:55:48', '2025-11-26 09:55:48'),
(5, 'admin@gmail.com', NULL, '$2y$10$ZxTOmh11/UA1vqtW6GGm4uu7h5pRAd0NhNeJ6P.S1sdgAsa3w9RG.', 'Huynh Pham Phuoc Linh', NULL, NULL, 1, 'admin', 1, NULL, NULL, '2025-12-06 08:03:58', '2025-12-06 08:04:25'),
(6, 'linh@gmail.com', NULL, '$2y$10$JLUobHzlbCmqwTsINcF1FeDG1HZjngfpNXnaz3ISGl5.zhHOHgrDu', 'Linh Huynh', NULL, NULL, 3, 'customer', 1, NULL, NULL, '2025-12-06 18:47:11', '2025-12-06 18:47:11');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_product` (`user_id`,`product_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_replied_by` (`replied_by`);

--
-- Chỉ mục cho bảng `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_ordering` (`ordering`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Chỉ mục cho bảng `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Chỉ mục cho bảng `faq_comments`
--
ALTER TABLE `faq_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_question_id` (`question_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Chỉ mục cho bảng `faq_questions`
--
ALTER TABLE `faq_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_is_published` (`is_published`),
  ADD KEY `idx_published_at` (`published_at`);
ALTER TABLE `news` ADD FULLTEXT KEY `ft_search` (`title`,`content`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD UNIQUE KEY `uq_order_code` (`order_code`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_is_featured` (`is_featured`),
  ADD KEY `idx_is_new` (`is_new`),
  ADD KEY `idx_is_active` (`is_active`);
ALTER TABLE `products` ADD FULLTEXT KEY `ft_search` (`name`,`description`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD UNIQUE KEY `uq_setting_key` (`setting_key`);

--
-- Chỉ mục cho bảng `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uq_email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_role_id` (`role_id`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `faq_comments`
--
ALTER TABLE `faq_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `faq_questions`
--
ALTER TABLE `faq_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_replied_by` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
