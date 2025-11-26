<?php

// ROOT PATH
define('PATH_ROOT', __DIR__);

// Base URL Configuration
define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://');
$http_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('ROOT_URL', PROTOCOL . $http_host);

// Auto-detect if running on PHP built-in server or Apache/XAMPP
// If PHP built-in server (e.g., php -S localhost:8000), BASE_URL = http://localhost:8000
// If Apache/XAMPP (e.g., localhost/ass), BASE_URL = http://localhost/ass
$script_name = $_SERVER['SCRIPT_NAME'] ?? '';
$is_builtin_server = (php_sapi_name() === 'cli-server');

if ($is_builtin_server) {
    // Running on PHP built-in server
    define('BASE_URL', ROOT_URL);
} else {
    // Running on Apache/XAMPP - need to include /ass in URL
    define('BASE_URL', ROOT_URL . '/ass');
}

define('ADMIN_URL', BASE_URL . '/cms');

// Path Configuration
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('UPLOAD_URL', BASE_URL . '/public/uploads');

// Application Settings
define('SITE_NAME', 'Toy Model Shop');
define('SITE_DESCRIPTION', 'Cửa hàng mô hình đồ chơi chất lượng cao');

// Pagination
define('ITEMS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 10);

// Upload Settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp']);

// Security Settings
define('PASSWORD_HASH_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_HASH_COST', 10);

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'toy_shop');
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', '3306');

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error Reporting (Development mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ICONS (Unicode)
define('ICON_CHECK', '✔');
define('ICON_UNCHECK', '✖');
define('ICON_DOT', '•');
define('ICON_ARROW', '➜');

// STATUS ICONS
define('ICON_ACTIVE', '🟢');
define('ICON_INACTIVE', '🔴');
define('ICON_WARNING', '⚠️');
define('ICON_INFO', 'ℹ️');

// CMS BUTTON ICONS (Bootstrap Icons)
define('ICON_ADD', '<i class="bi bi-plus-circle"></i>');
define('ICON_EDIT', '<i class="bi bi-pencil-square"></i>');
define('ICON_DELETE', '<i class="bi bi-trash"></i>');
define('ICON_SAVE', '<i class="bi bi-save"></i>');
define('ICON_BACK', '<i class="bi bi-arrow-left"></i>');
