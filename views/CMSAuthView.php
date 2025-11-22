<?php

namespace Views;

class CMSAuthView
{
    public function render(string $view, array $data = [])
    {
        if (!empty($data))
            extract($data);
        require PATH_ROOT . "/views/admin/auth/{$view}.php";
    }
}
