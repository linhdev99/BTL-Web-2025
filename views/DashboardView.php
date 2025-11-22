<?php

namespace Views;

class DashboardView
{
    public function render(array $data = [])
    {
        extract($data);
        require PATH_ROOT . '/views/admin/home/dashboard.php';
    }
}
