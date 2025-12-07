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

  public function render_cms_index(array $data = [])
  {
    extract($data);

    $file = PATH_ROOT . "/views/admin/news/index.php";
    if (!file_exists($file)) {
      (new ErrorView)->render();
      return;
    }

    include PATH_ROOT . "/views/admin/layouts/header.php";
    include $file;
    include PATH_ROOT . "/views/admin/layouts/footer.php";
  }

  public function render_cms_add(array $data = [])
  {
    extract($data);

    $file = PATH_ROOT . "/views/admin/news/add.php";
    if (!file_exists($file)) {
      (new ErrorView)->render();
      return;
    }

    include PATH_ROOT . "/views/admin/layouts/header.php";
    include $file;
    include PATH_ROOT . "/views/admin/layouts/footer.php";
  }

  public function render_cms_edit(array $data = [])
  {
    extract($data);

    $file = PATH_ROOT . "/views/admin/news/edit.php";
    if (!file_exists($file)) {
      (new ErrorView)->render();
      return;
    }

    include PATH_ROOT . "/views/admin/layouts/header.php";
    include $file;
    include PATH_ROOT . "/views/admin/layouts/footer.php";
  }
}
