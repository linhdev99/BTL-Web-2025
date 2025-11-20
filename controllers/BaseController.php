<?php

namespace Controllers;

class BaseController
{
    protected function view(string $path, array $data = [])
    {
        extract($data);
        $file = __DIR__ . '/../views/' . $path . '.php';

        if (!file_exists($file)) {
            echo "View not found: $file";
            return;
        }

        require $file;
    }
}
