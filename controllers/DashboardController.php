<?php

namespace Controllers;

use Views\DashboardView;
use Core\CMSAuth;
use Models\DashboardModel;

class DashboardController
{
    public function index()
    {
        CMSAuth::check();

        $model = new DashboardModel();
        $stats = $model->getStats();

        $view = new DashboardView();
        $view->render([
            'page_title' => "Dashboard CMS",
            'stats' => $stats
        ]);
    }
}
