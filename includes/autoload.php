<?php

/**
 * Autoloader for classes with namespaces
 *
 * This function automatically loads class files based on their namespace and class name.
 * It follows PSR-4 autoloading standard.
 */

spl_autoload_register(function (string $class_name) {
    // Convert namespace separator to directory separator
    $path = PATH_ROOT . DIRECTORY_SEPARATOR;
    $path .= str_replace("\\", DIRECTORY_SEPARATOR, $class_name) . ".php";

    // Get the real path
    $path = realpath($path);

    // If file exists, require it
    if ($path && file_exists($path)) {
        require $path;
        return true;
    }

    return false;
});
