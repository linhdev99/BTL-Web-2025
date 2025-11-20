<?php

namespace Models;

class DashboardModel
{
    public function getStats()
    {
        // Giả lập dữ liệu
        return [
            "total_products" => 120,
            "total_users" => 45,
            "total_orders" => 87
        ];
    }
}
