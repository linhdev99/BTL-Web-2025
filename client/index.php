<?php
require_once './core/http/Route.php';
require_once './core/route/routes.php';
use Core\Http\Route;
$router = new Route();
$url = $_GET['url'] ?? '/';
$router->map($url, $_SERVER['REQUEST_METHOD']);
?>