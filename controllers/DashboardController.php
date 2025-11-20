<?php

namespace Controllers;

use Models\DashboardModel;
use Views\DashboardView;

class DashboardController extends BaseController
{
    public function index()
    {
        $model = new DashboardModel();
        $view = new DashboardView();

        $data = [
            "page_title" => "Dashboard CMS",
            "stats" => $model->getStats()
        ];

        $view->render($data);
    }
}
