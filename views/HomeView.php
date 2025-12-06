<?php

namespace Views;

class HomeView
{
    public function render(array $data = [])
    {
        extract($data);
        $file = PATH_ROOT . '/views/client/home/index.php';
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }
        require $file;
    }
}
