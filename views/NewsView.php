<?php

namespace Views;

class NewsView
{
  public function render_index(array $data = [])
  {
    extract($data);

    $file = PATH_ROOT . "/views/client/news/index.php";
    if (!file_exists($file)) {
      (new ErrorView)->render();
      return;
    }

    include PATH_ROOT . "/app/views/layouts/header.php";
    include $file;
    include PATH_ROOT . "/app/views/layouts/footer.php";
  }

  public function render_detail(array $data = [])
  {
    extract($data);

    $file = PATH_ROOT . "/views/client/news/detail.php";
    if (!file_exists($file)) {
      (new ErrorView)->render();
      return;
    }

    include PATH_ROOT . "/app/views/layouts/header.php";
    include $file;
    include PATH_ROOT . "/app/views/layouts/footer.php";
  }
}
