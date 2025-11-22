<?php

namespace Views;

class CMSFAQView
{
    public function render(array $data = [])
    {
        extract($data);

        // Load Layout
        include PATH_ROOT . "/views/admin/partials/header.php";
        include PATH_ROOT . "/views/admin/partials/sidebar.php";

        echo '<div class="admin-content container-fluid">';

        switch ($mode ?? 'index') {

            case 'index':
                include PATH_ROOT . "/views/admin/faq/index.php";
                break;

            case 'add':
                include PATH_ROOT . "/views/admin/faq/add.php";
                break;

            case 'edit':
                include PATH_ROOT . "/views/admin/faq/edit.php";
                break;

            default:
                echo "<p class='text-danger'>FAQ View mode not found!</p>";
                break;
        }

        echo '</div>';

        include PATH_ROOT . "/views/admin/partials/footer.php";
    }
}
