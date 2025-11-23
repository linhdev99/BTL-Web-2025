<?php

namespace Views;

class AuthView
{
    public function render(string $view, array $data = [])
    {
        if (!empty($data))
            extract($data);
        require PATH_ROOT . "/views/auth/{$view}.php";
    }
}
