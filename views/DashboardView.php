<?php

namespace Views;

class DashboardView
{
    public function render(array $data = [])
    {
        extract($data);
        $file = PATH_ROOT . '/views/admin/home/dashboard.php';
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }
        require $file;
    }
}
