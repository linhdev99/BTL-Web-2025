<?php

namespace Controllers;

use Views\DashboardView;
use Core\Auth;
use Models\DashboardModel;

class DashboardController
{
    public function index()
    {
        Auth::requireAdminOrStaff();

        $model = new DashboardModel();
        $stats = $model->getStats();

        $view = new DashboardView();
        $view->render([
            'page_title' => "Dashboard CMS",
            'stats' => $stats
        ]);
    }
}
