<?php

namespace Views;

class CMSFAQView
{
    public function render(string $module, string $view = "index", array $data = [])
    {
        extract($data);

        include PATH_ROOT . "/views/admin/partials/header.php";
        include PATH_ROOT . "/views/admin/partials/sidebar.php";

        echo '<div class="admin-content container-fluid">';

        if ($module === "home") {
            include PATH_ROOT . "/views/admin/faq/faq.php";
        } else {
            $file = PATH_ROOT . "/views/admin/faq/{$module}/{$view}.php";

            if (!file_exists($file)) {
                echo "<p class='text-danger'>Không tìm thấy view: $file</p>";
            } else {
                include $file;
            }
        }

        echo '</div>';

        include PATH_ROOT . "/views/admin/partials/footer.php";
    }
}
