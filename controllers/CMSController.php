<?php

namespace Controllers;

use Core\Auth;
use Models\ProductModel;
use Models\UserModel;
use Models\NewsModel;

class CMSController extends BaseController
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        Auth::requireAdminOrStaff();

        $productModel = new ProductModel();
        $userModel = new UserModel();
        $newsModel = new NewsModel();

        // Get statistics
        $productStats = $productModel->getStats();
        $userStats = $userModel->getStats();

        // TODO: Get order stats

        $this->view('admin/dashboard', [
            'pageTitle' => 'Dashboard',
            'productStats' => $productStats,
            'userStats' => $userStats
        ]);
    }
}
