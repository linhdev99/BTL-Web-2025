<?php

namespace Controllers;

use Views\DashboardView;
use Core\CMSAuth;

class DashboardController
{
    public function index()
    {
        CMSAuth::check(); // MUST login

        $view = new DashboardView();
        $view->render([
            'page_title' => "Dashboard CMS",
            'stats' => [
                'total_products' => 120,
                'total_users' => 53,
                'total_orders' => 12,
                'total_revenue' => 10000000,
            ]
        ]);
    }
}
