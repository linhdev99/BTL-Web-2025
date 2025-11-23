<?php

require 'define-params.php';

function include_class($class)
{
    $path = PATH_ROOT . DIRECTORY_SEPARATOR;
    $path .= str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    $path = realpath($path);
    if (file_exists($path)) {
        require $path;
        return true;
    }
}

spl_autoload_register(function (string $class_name) {
    include_class($class_name);
});

require 'configs/index.php';

session_start();
ob_start();

require 'utils/validate.php';
?>

<?php

$router = new Core\Http\Route();
include_once PATH_ROOT . '/core/route/routes.php';

$request_url = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

$method_url = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

$router->map($request_url, $method_url);
?>