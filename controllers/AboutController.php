<?php

namespace Controllers;

use Core\Auth;
use Models\AboutModel;
use Views\AboutView;

class AboutController extends BaseController
{
  public function index()
  {
    $view = new AboutView();
    $model = new AboutModel();
    $aboutData = $model->getAllData();
    $view->render([
      'pageTitle' => 'Về chúng tôi',
      'aboutData' => $aboutData
    ]);
  }

  public function edit()
  {
    Auth::requireAdminOrStaff();

    $model = new AboutModel();
    $aboutData = $model->getAllData();

    $view = new AboutView();
    $view->render_edit([
      'pageTitle' => 'Chỉnh sửa thông tin "Về chúng tôi"',
      'aboutData' => $aboutData
    ]);
  }

  public function update()
  {
    Auth::requireAdminOrStaff();

    $model = new AboutModel();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      foreach ($_POST as $title => $content) {
        $model->updateContent($title, $content);
      }
      header("Location: /about");
      exit;
    }
  }
}
