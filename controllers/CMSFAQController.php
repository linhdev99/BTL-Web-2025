<?php

namespace Controllers;

use Core\Auth;
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
        Auth::requireAdminOrStaff();

        (new CMSFAQView())->render(
            "home",
            "index",
            [
                "page_title" => "Frequently Asked Questions (FAQ)"
            ]
        );
    }

    // ============================================================
    //  MODULE 1 — FAQ CATEGORY (faq-category/)
    // ============================================================

    public function category()
    {
        Auth::requireAdminOrStaff();

        $categories = (new FAQCategoryModel())->getAllCategories();

        (new CMSFAQView())->render(
            "category",
            "index",
            [
                "page_title" => "Quản lý thể loại",
                "categories" => $categories
            ]
        );
    }

    public function categoryAdd()
    {
        Auth::requireAdminOrStaff();

        (new CMSFAQView())->render(
            "category",
            "add",
            [
                "page_title" => "Thêm thể loại"
            ]
        );
    }

    public function categoryStore()
    {
        Auth::requireAdminOrStaff();

        $name = $_POST['name'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->create($name, $is_active);

        header("Location: /cms/faq/category");
        exit;
    }

    public function categoryEdit($url, $id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $category = (new FAQCategoryModel())->getById($id);

        (new CMSFAQView())->render(
            "category",
            "edit",
            [
                "page_title" => "Chỉnh sửa thể loại",
                "category" => $category
            ]
        );
    }

    public function categoryUpdate($url, $id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $name = $_POST['name'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->updateCategory($id, $name, $is_active);

        header("Location: /cms/faq/category");
        exit;
    }

    public function categoryDelete($url, $id)
    {
        Auth::requireAdminOrStaff();
        (new FAQCategoryModel())->deleteCategory((int) $id);
        header("Location: /cms/faq/category");
        exit;
    }

    // ============================================================
    //  MODULE 2 — FAQ STATIC (faq-static/)
    // ============================================================

    public function static()
    {
        Auth::requireAdminOrStaff();

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
                "page_title" => "Quản lí Câu hỏi thường gặp",
                "staticFaq" => $staticFaq,
                "categories" => $categories,
                "categoriesMap" => $categoriesMap
            ]
        );
    }

    public function staticAdd()
    {
        Auth::requireAdminOrStaff();

        $categories = (new FAQCategoryModel())->getAllCategories();

        (new CMSFAQView())->render(
            "static",
            "add",
            [
                "page_title" => "Thêm Câu hỏi",
                "categories" => $categories
            ]
        );
    }

    public function staticStore()
    {
        Auth::requireAdminOrStaff();

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
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $faq = $faqModel->getById($id);
        $categories = $catModel->getAllCategories();

        (new CMSFAQView())->render(
            "static",
            "edit",
            [
                "page_title" => "Chỉnh sửa câu hỏi",
                "faq" => $faq,
                "categories" => $categories
            ]
        );
    }

    public function staticUpdate($url, $id)
    {
        Auth::requireAdminOrStaff();

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
        Auth::requireAdminOrStaff();
        (new FAQModel())->deleteFAQ((int) $id);
        header("Location: /cms/faq/static");
        exit;
    }

    // ============================================================
    //  MODULE 3 — FAQ USER INTERACTION (faq-user/)
    // ============================================================

    public function user()
    {
        Auth::requireAdminOrStaff();

        $view = new CMSFAQView();
        $catModel = new FAQCategoryModel();
        $faqQuestionModel = new FAQQuestionModel();

        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';
        $filterCategory = !empty($_GET['category_id']) ? (int) $_GET['category_id'] : null;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $limit = 9;

        $isUser = Auth::isUser();

        $categories = $catModel->getAllCategories();
        $faqQuestions = $faqQuestionModel->getFilteredQuestions($search, $sort, $filterCategory, $page, $limit, $isUser);
        $totalRecords = $faqQuestionModel->countFilteredQuestions($search, $filterCategory, $isUser);
        $totalPages = ceil($totalRecords / $limit);

        $view->render(
            "user",
            "index",
            [
                'page_title' => "Quản lí Hỏi/Đáp với người dùng",
                'categories' => $categories,
                'faqQuestions' => $faqQuestions,
                'page' => $page,
                'totalPages' => $totalPages,
                'search' => $search,
                'sort' => $sort,
                'filterCategory' => $filterCategory,
                'isUser' => $isUser
            ]
        );
    }

    public function userDetail($url, $id)
    {
        Auth::requireAdminOrStaff();

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
        Auth::requireAdminOrStaff();

        $questId = (int) $id;
        $content = $_POST['content'] ?? '';
        $userId = $_SESSION['user']['id'];

        if ($userId == null || $userId == '') {
            header("Location: /login");
            return;
        }

        (new FAQQuestionModel())->addComment($questId, $userId, $content);

        header("Location: /cms/faq/user/detail/$id");
        exit;
    }

    public function userDelete($url, $id)
    {
        Auth::requireAdminOrStaff();

        (new FAQQuestionModel())->deleteQuestion((int) $id);

        header("Location: /cms/faq/user");
        exit;
    }

    public function userUpdateStatus($url, $id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $status = $_POST['status'] ?? 'pending';

        $questionModel = new FAQQuestionModel();
        $questionModel->update(
            'faq_questions',
            ['status' => $status],
            "id = :id",
            ['id' => $id]
        );

        $_SESSION['_flash'][] = [
            'msg' => "Cập nhật thành công!",
            'type' => "success",   // success / danger / warning / info
            'time' => 3000         // ms
        ];

        header("Location: /cms/faq/user/detail/$id");
        exit;
    }

    public function deleteComment($url, $idQuest, $idCmt)
    {
        Auth::requireAdminOrStaff();
        $idCmt = (int) $idCmt;
        $model = new FAQQuestionModel();
        $model->deleteComment(id: $idCmt);

        $_SESSION['_flash'][] = [
            'msg' => "Xoá thành công!",
            'type' => "success",
            'time' => 3000
        ];

        header("Location: /cms/faq/user/detail/$idQuest");
        exit;
    }
}
