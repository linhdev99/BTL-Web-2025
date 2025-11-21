<?php

namespace Views;

class CMSAuthView
{
    public function render(string $view, array $data = [])
    {
        if (!empty($data))
            extract($data);
        // require __DIR__ . "/admin/auth/{$view}.php";
        require PATH_ROOT . "/views/admin/auth/{$view}.php";
    }
}
