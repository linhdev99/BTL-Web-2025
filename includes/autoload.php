<?php

spl_autoload_register(function ($class) {

    // Chuyển namespace -> đường dẫn
    $class = str_replace('\\', '/', $class);

    $file = __DIR__ . '/../' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
