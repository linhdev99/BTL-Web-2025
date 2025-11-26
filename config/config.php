<?php
/**
 * Application Configuration
 */

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL Configuration
// QUAN TRỌNG: Thay đổi 'ass' thành tên thư mục của bạn trong htdocs
// Ví dụ: 'ass1', 'toy-shop', 'website', etc.
define('BASE_URL', 'http://localhost/ass1');
define('ADMIN_URL', BASE_URL . '/admin');

// Path Configuration
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

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

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error Reporting (Development mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database config
require_once ROOT_PATH . '/config/database.php';

// Autoload function for classes
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/models/',
        APP_PATH . '/controllers/',
        ROOT_PATH . '/includes/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});
