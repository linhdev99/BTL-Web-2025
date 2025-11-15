<?php
//Is this the production server or not?
if (str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
    define('PRODUCTION', false);
} else {
    define('PRODUCTION', true);
}

if (!defined('ENVIRONMENT')) {
    if (PRODUCTION) {
        define('ENVIRONMENT', 'production');
    } else {
        define('ENVIRONMENT', 'development');
    }
}

// Load in default configuration values
require_once 'config.default.php';

$configLocal = 'config.' . ENVIRONMENT . '.php';
if (file_exists('configs/' . $configLocal)) {
    require_once $configLocal;
}
