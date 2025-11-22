<?php

namespace Controllers;

use Core\CMSAuth;
use Models\FAQModel;
use Models\FAQCategoryModel;
use Models\FAQQuestionModel;
use Views\CMSFAQView;

class CMSFAQController
{
    /**
     * Trang HOME của FAQ - có 3 nút chuyển module
     */
    public function index()
    {
        CMSAuth::check();

        (new CMSFAQView())->render(
            "home",
            "index",
            [
                "page_title" => "Quản lý FAQ"
            ]
        );
    }

    // ============================================================
    //  MODULE 1 — FAQ CATEGORY (faq-category/)
    // ============================================================

    public function category()
    {
        CMSAuth::check();

        $categories = (new FAQCategoryModel())->getAllCategories();

        (new CMSFAQView())->render(
            "category",
            "index",
            [
                "page_title" => "Quản lý thể loại FAQ",
                "categories" => $categories
            ]
        );
    }

    public function categoryAdd()
    {
        CMSAuth::check();

        (new CMSFAQView())->render(
            "category",
            "add",
            [
                "page_title" => "Thêm thể loại FAQ"
            ]
        );
    }

    public function categoryStore()
    {
        CMSAuth::check();

        $name = $_POST['name'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->create($name, $is_active);

        header("Location: /cms/faq/category");
        exit;
    }

    public function categoryEdit($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;
        $category = (new FAQCategoryModel())->getById($id);

        (new CMSFAQView())->render(
            "category",
            "edit",
            [
                "page_title" => "Chỉnh sửa thể loại FAQ",
                "category" => $category
            ]
        );
    }

    public function categoryUpdate($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;
        $name = $_POST['name'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->updateCategory($id, $name, $is_active);

        header("Location: /cms/faq/category");
        exit;
    }

    public function categoryDelete($url, $id)
    {
        CMSAuth::check();
        (new FAQCategoryModel())->deleteCategory((int) $id);
        header("Location: /cms/faq/category");
        exit;
    }

    // ============================================================
    //  MODULE 2 — FAQ STATIC (faq-static/)
    // ============================================================

    public function static()
    {
        CMSAuth::check();

        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $staticFaq = $faqModel->getAllFAQ();
        $categories = $catModel->getAllCategories();
        $categoriesMap = [];

        foreach ($categories as $c) {
            $categoriesMap[$c['id']] = $c['name'];
        }

        (new CMSFAQView())->render(
            "static",
            "index",
            [
                "page_title" => "FAQ tĩnh",
                "staticFaq" => $staticFaq,
                "categories" => $categories,
                "categoriesMap" => $categoriesMap
            ]
        );
    }

    public function staticAdd()
    {
        CMSAuth::check();

        $categories = (new FAQCategoryModel())->getAllCategories();

        (new CMSFAQView())->render(
            "static",
            "add",
            [
                "page_title" => "Thêm FAQ tĩnh",
                "categories" => $categories
            ]
        );
    }

    public function staticStore()
    {
        CMSAuth::check();

        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $ordering = (int) ($_POST['ordering'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $category_id = (int) ($_POST['category_id'] ?? 1);

        (new FAQModel())->create($question, $answer, $ordering, $isActive, $category_id);

        header("Location: /cms/faq/static");
        exit;
    }

    public function staticEdit($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;
        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $faq = $faqModel->getById($id);
        $categories = $catModel->getAllCategories();

        (new CMSFAQView())->render(
            "static",
            "edit",
            [
                "page_title" => "Chỉnh sửa FAQ tĩnh",
                "faq" => $faq,
                "categories" => $categories
            ]
        );
    }

    public function staticUpdate($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;
        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $ordering = (int) ($_POST['ordering'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $category_id = (int) ($_POST['category_id'] ?? 1);

        error_log($category_id);

        (new FAQModel())->updateFAQ($id, $question, $answer, $ordering, $isActive, $category_id);

        header("Location: /cms/faq/static");
        exit;
    }

    public function staticDelete($url, $id)
    {
        CMSAuth::check();
        (new FAQModel())->deleteFAQ((int) $id);
        header("Location: /cms/faq/static");
        exit;
    }

    // ============================================================
    //  MODULE 3 — FAQ USER INTERACTION (faq-user/)
    // ============================================================

    public function user()
    {
        CMSAuth::check();

        $keyword = $_GET['keyword'] ?? null;
        $category_id = $_GET['category_id'] ?? null;
        $sort = $_GET['sort'] ?? null;

        $questionModel = new FAQQuestionModel();
        $catModel = new FAQCategoryModel();
        $categories = $catModel->getAllCategories();
        $userQuestions = [];

        if ($keyword === null && $category_id === null && $sort === null) {
            $userQuestions = $questionModel->getAllQuestionsWithUser();
            error_log('1');
        } else {
            $sort = $sort ?: 'newest';
            $userQuestions = $questionModel->filterUserQuestions(
                $keyword ?? '',
                $category_id ?? '',
                $sort
            );
            error_log('2');
        }

        (new CMSFAQView())->render(
            "user",
            "index",
            [
                "page_title" => "FAQ người dùng",
                "userQuestions" => $userQuestions,
                "categories" => $categories
            ]
        );
    }

    public function userDetail($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;

        $questionModel = new FAQQuestionModel();
        $question = $questionModel->getById($id);
        $comments = $questionModel->getComments($id);

        (new CMSFAQView())->render(
            "user",
            "detail",
            [
                "page_title" => "Chi tiết câu hỏi người dùng",
                "question" => $question,
                "comments" => $comments
            ]
        );
    }

    public function userReply($url, $id)
    {
        CMSAuth::check();

        $id = (int) $id;
        $content = $_POST['content'] ?? '';
        $adminId = $_SESSION['cms_user']['id'];

        (new FAQQuestionModel())->addComment($id, $adminId, $content);

        header("Location: /cms/faq/user/detail/$id");
        exit;
    }

    public function userDelete($url, $id)
    {
        CMSAuth::check();

        (new FAQQuestionModel())->deleteQuestion((int) $id);

        header("Location: /cms/faq/user");
        exit;
    }
}
