<?php

/**
 * Application Entry Point
 * All requests are routed through this file
 */

// Load configuration and constants
require 'define-params.php';

// Autoload classes
require 'includes/autoload.php';

// Start session
session_start();

// Enable output buffering
ob_start();

// Load validation utilities
require 'utils/validate.php';

// Load helper functions
require 'includes/functions.php';

// Load settings helper
require 'utils/settings_helper.php';

// Initialize router
$router = new Core\Http\Route();

// Load route definitions
require PATH_ROOT . '/core/route/routes.php';

// Get request URL and method
$request_url = $_SERVER['REQUEST_URI'] ?? '/';
$method_url = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Remove query string from URL
$request_url = strtok($request_url, '?');

// Remove base path from URL if exists
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
if ($base_path && strpos($request_url, $base_path) === 0) {
    $request_url = substr($request_url, strlen($base_path));
}

// Ensure URL starts with /
if (empty($request_url) || $request_url[0] !== '/') {
    $request_url = '/' . $request_url;
}

// Remove trailing slash (except for root)
if ($request_url !== '/' && substr($request_url, -1) === '/') {
    $request_url = substr($request_url, 0, -1);
}

// Map the request to a route
$router->map($request_url, $method_url);

// Flush output buffer
ob_end_flush();
