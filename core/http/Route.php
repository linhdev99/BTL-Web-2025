<?php

namespace Core\Http;

use Views\ErrorView;

/**
 * Class Route
 * Handles routing for the application
 */
class Route
{
    /**
     * Array to store routes
     * Each route contains url, method, action and params
     */
    private $__routes;

    public function __construct()
    {
        $this->__routes = [];
    }

    /**
     * Register a GET route
     *
     * @param string $url URL pattern to match
     * @param string|callable $action Action when URL is called (callback or Controller@method)
     * @return void
     */
    public function get(string $url, $action)
    {
        $this->__request($url, 'GET', $action);
    }

    /**
     * Register a POST route
     *
     * @param string $url URL pattern to match
     * @param string|callable $action Action when URL is called (callback or Controller@method)
     * @return void
     */
    public function post(string $url, $action)
    {
        $this->__request($url, 'POST', $action);
    }

    /**
     * Process and register a route
     *
     * @param string $url URL pattern to match
     * @param string $method HTTP method (GET or POST)
     * @param string|callable $action Action when URL is called
     * @return void
     */
    private function __request(string $url, string $method, $action)
    {
        // Check if URL contains parameters. Example: product/{slug}
        if (preg_match_all('/({([a-zA-Z]+)})/', $url, $params)) {
            // Replace parameters with regex pattern. Example: product/{slug} -> product/([^\?/]+)
            $url = preg_replace('/({([a-zA-Z]+)})/', '([^\?/]+)', $url);
        }

        // Escape forward slashes for regex
        $url = str_replace('/', '\/', $url);

        // Add query string support for GET requests
        if ($method === 'GET') {
            $url = $url . '(?:\?([^\/\n\s]*))?';
        }

        // Create route entry
        $route = [
            'url' => $url,
            'method' => $method,
            'action' => $action,
            'params' => $params[2] ?? []
        ];

        // Add route to routes array
        array_push($this->__routes, $route);
    }

    /**
     * Map incoming request to registered routes
     *
     * @param string $url The requested URL
     * @param string $method The request method (GET or POST)
     * @return void
     */
    public function map(string $url, string $method)
    {
        // Loop through all registered routes
        foreach ($this->__routes as $route) {
            // Check if method matches
            if ($route['method'] == $method) {
                // Check if URL matches the route pattern
                $reg = '/^' . $route['url'] . '$/';
                if (preg_match($reg, $url, $params)) {
                    $this->__call_action_route($route['action'], $params);
                    return;
                }
            }
        }

        // No matching route found - show 404 error
        $this->show404();
    }

    /**
     * Call the action for a matched route
     *
     * @param string|callable $action The action to execute
     * @param array $params URL parameters
     * @return void
     */
    private function __call_action_route($action, $params)
    {
        // Remove the first element (full match) from params
        // We only want captured groups (actual parameter values)
        array_shift($params);

        // If action is a callback function
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        // If action is a Controller@method string
        if (is_string($action)) {
            $action = explode('@', $action);
            $controller_name = 'Controllers\\' . $action[0];

            // Check if controller class exists
            if (!class_exists($controller_name)) {
                die("Controller not found: {$controller_name}");
            }

            $controller = new $controller_name();

            // Check if method exists
            if (!method_exists($controller, $action[1])) {
                die("Method not found: {$action[1]} in {$controller_name}");
            }

            call_user_func_array([$controller, $action[1]], $params);
            return;
        }
    }

    /**
     * Show 404 error page
     */
    private function show404()
    {
        http_response_code(404);
        echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="display-1">404</h1>
                <h2>Không tìm thấy trang</h2>
                <p class="lead">Xin lỗi, trang bạn tìm kiếm không tồn tại.</p>
                <a href="' . BASE_URL . '" class="btn btn-primary">Về trang chủ</a>
            </div>
        </div>
    </div>
</body>
</html>';
        exit;
    }
}
