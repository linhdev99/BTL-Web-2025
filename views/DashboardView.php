<?php

namespace Views;

class DashboardView
{
    public function render(array $data = [])
    {
        extract($data);
        require __DIR__ . '/admin/cmsDashboard.php';
    }
}
