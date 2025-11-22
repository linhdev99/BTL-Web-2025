<?php

namespace Controllers;

use Core\CMSAuth;
use Models\FAQModel;
use Views\CMSFAQView;

class CMSFAQController
{
    public function index()
    {
        CMSAuth::check();

        $model = new FAQModel();
        $faqs = $model->getAllFAQ();

        (new CMSFAQView())->render([
            'mode' => 'index',
            'page_title' => 'Quản lý FAQ',
            'faqs' => $faqs
        ]);
    }

    public function add()
    {
        CMSAuth::check();

        (new CMSFAQView())->render([
            'mode' => 'add',
            'page_title' => 'Thêm câu hỏi mới'
        ]);
    }

    public function store()
    {
        CMSAuth::check();

        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $ordering = (int) ($_POST['ordering'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        (new FAQModel())->create($question, $answer, $ordering, $isActive);

        header("Location: /cms/faq");
        exit;
    }

    public function edit($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;

        $model = new FAQModel();
        $faq = $model->getById($id);

        (new CMSFAQView())->render([
            'mode' => 'edit',
            'page_title' => 'Chỉnh sửa FAQ',
            'faq' => $faq
        ]);
    }

    public function update($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;

        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $ordering = (int) ($_POST['ordering'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        (new FAQModel())->updateFAQ($id, $question, $answer, $ordering, $isActive);

        header("Location: /cms/faq");
        exit;
    }

    public function delete($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;

        (new FAQModel())->deleteFAQ($id);

        header("Location: /cms/faq");
        exit;
    }
}
