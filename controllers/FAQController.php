<?php

namespace Controllers;

use Views\FAQView;
use Models\FAQModel;
use Models\FAQCategoryModel;
use Models\FAQQuestionModel;
use Controllers\BaseController;
use Core\Auth;

class FAQController extends BaseController
{
    public function index()
    {
        $view = new FAQView();
        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $categories = $catModel->getAllCategories();
        $faqs = $faqModel->getAllFAQ();

        return $view->render_faq([
            'categories' => $categories,
            'faqs' => $faqs,
        ]);
    }
    public function questions()
    {
        $view = new FAQView();
        $catModel = new FAQCategoryModel();
        $faqQuestionModel = new FAQQuestionModel();

        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'created_at';
        $filterCategory = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? (int) $_GET['category_id'] : null;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $limit = 9;

        $categories = $catModel->getAllCategories();

        [$faqQuestions, $totalPages] = $faqQuestionModel->getFilteredQuestions(
            $search,
            $sort,
            $filterCategory,
            $page,
            $limit
        );

        // ==== Gửi dữ liệu sang View ====
        return $view->render_questions([
            'categories' => $categories,
            'faqQuestions' => $faqQuestions,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'sort' => $sort,
            'filterCategory' => $filterCategory,
        ]);
    }

    public function faqDetail($id)
    {
        $view = new FAQView();
        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $user = Auth::optionalUser();

        $faq = $faqModel->getById($id);
        if (!$faq) {
            die("Không tìm thấy câu hỏi FAQ với ID #{$id}");
        }

        $category = null;
        if (!empty($faq['category_id'])) {
            $category = $catModel->getById((int)$faq['category_id']);
        }

        return $view->render_faq_detail([
            'faq' => $faq,
            'category' => $category,
            'user' => $user,
        ]);
    }

}
