<?php

namespace Views;

class AuthView
{
    public function render(string $view, array $data = [])
    {
        if (!empty($data))
            extract($data);

        $file = PATH_ROOT . "/views/auth/{$view}.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }
        require $file;
    }
}
