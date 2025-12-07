<?php

namespace Views;

class FAQView
{
    public function render_faq(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/faq/faq.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";
    }

    public function render_faq_detail(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/faq/detail.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";
    }

    public function render_questions(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/faq/questions.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";
    }

    public function render_question_detail(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/faq/questDetail.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";

    }

    public function render_user_ask(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/faq/userAsk.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";
    }

    public function render_user_edit_ask(array $data = [])
    {
        extract($data);

        $file = PATH_ROOT . "/views/client/faq/userEditAsk.php";
        if (!file_exists($file)) {
            (new ErrorView)->render();
            return;
        }

        include PATH_ROOT . "/app/views/layouts/header.php";
        include $file;
        include PATH_ROOT . "/app/views/layouts/footer.php";
    }
}