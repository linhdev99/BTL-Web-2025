<?php

namespace Controllers;

use Core\Auth;
use Models\DashboardModel;
use Models\OrderModel;
use Models\ProductModel;
use Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        Auth::requireAdminOrStaff();

        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $userModel = new UserModel();

        // Get order statistics
        $orderStats = $orderModel->getStats();

        // Get sales statistics (last 30 days)
        $startDate = date('Y-m-d', strtotime('-30 days'));
        $endDate = date('Y-m-d');
        $salesStats = $orderModel->getSalesStats($startDate, $endDate);

        // Get revenue by date (last 7 days)
        $revenueData = $orderModel->getRevenueByDateRange(7);

        // Get recent orders
        $recentOrders = $orderModel->getAllOrders(1, 5);

        // Get low stock products
        $lowStockProducts = $productModel->getAll("SELECT * FROM products WHERE stock < 10 AND is_active = 1 ORDER BY stock ASC LIMIT 5");

        // Total products
        $totalProducts = $productModel->getOne("SELECT COUNT(*) as total FROM products WHERE is_active = 1")['total'] ?? 0;

        // Total users
        $totalUsers = $userModel->getOne("SELECT COUNT(*) as total FROM users")['total'] ?? 0;

        // Render with Tabler UI
        $this->view('admin/home/dashboard', [
            'pageTitle' => 'Dashboard',
            'orderStats' => $orderStats,
            'salesStats' => $salesStats,
            'revenueData' => $revenueData,
            'recentOrders' => $recentOrders['orders'] ?? [],
            'lowStockProducts' => $lowStockProducts,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers
        ]);
    }
}
