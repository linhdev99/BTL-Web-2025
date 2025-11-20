<?php

namespace Controllers;

use Models\HomeModel;
use Views\HomeView;

class HomeController extends BaseController
{
    public function index()
    {
        $model = new HomeModel();
        $view = new HomeView();

        $data = [
            "page_title" => "Trang chủ",
            "message" => $model->getWelcomeMessage()
        ];

        $view->render($data);
    }
}
