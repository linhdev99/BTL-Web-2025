<?php

namespace Views;

class FAQView
{
    public function render_faq(array $data = [])
    {
        extract($data);
        include PATH_ROOT . "/views/client/partials/header.php";
        include PATH_ROOT . "/views/client/partials/sidebar.php";
        include PATH_ROOT . "/views/client/faq/faq.php";
        include PATH_ROOT . "/views/client/partials/footer.php";
    }
    public function render_questions(array $data = [])
    {
        extract($data);
        include PATH_ROOT . "/views/client/partials/header.php";
        include PATH_ROOT . "/views/client/partials/sidebar.php";
        include PATH_ROOT . "/views/client/faq/questions.php";
        include PATH_ROOT . "/views/client/partials/footer.php";
    }
    public function render_faq_detail(array $data = [])
    {
        extract($data);
        include PATH_ROOT . "/views/client/partials/header.php";
        include PATH_ROOT . "/views/client/partials/sidebar.php";
        include PATH_ROOT . "/views/client/faq/detail.php";
        include PATH_ROOT . "/views/client/partials/footer.php";
    }

}
