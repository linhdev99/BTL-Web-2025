<?php

namespace Views;

class AboutView
{
    public function render(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/pages/about.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";
    }
    public function render_edit(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/admin/about/edit.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/views/admin/layouts/header.php";
        include $file;
        include PATH_ROOT . "/views/admin/layouts/footer.php";
    }
}
