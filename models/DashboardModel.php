<?php

namespace Models;

class DashboardModel extends BaseModel
{
    public function getStats()
    {
        $totalProducts = $this->getOne("SELECT COUNT(*) AS total FROM products")['total'];
        $totalUsers = $this->getOne("SELECT COUNT(*) AS total FROM users")['total'];
        $totalOrders = $this->getOne("SELECT COUNT(*) AS total FROM orders")['total'];

        // Note: ass database uses 'total_amount' not 'total'
        $row = $this->getOne("
            SELECT COALESCE(SUM(total_amount), 0) AS revenue
            FROM orders
            WHERE status = 'completed'
        ");
        $totalRevenue = $row ? (float) $row['revenue'] : 0;

        error_log("STATS => " . json_encode([
            'products' => $totalProducts,
            'users' => $totalUsers,
            'orders' => $totalOrders,
            'revenue' => $totalRevenue
        ]));

        return [
            'total_products' => $totalProducts,
            'total_users' => $totalUsers,
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue
        ];
    }
}
