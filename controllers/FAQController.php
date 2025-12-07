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
        $user = Auth::optionalUser();

        if (Auth::isAdmin() || Auth::isStaff()) {
            $faqs = $faqModel->getAllFAQ();
        } else {
            $faqs = $faqModel->getAllActiveFAQ();
        }

        return $view->render_faq([
            'faqs' => $faqs,
            'user' => $user,
        ]);
    }

    public function faqDetail($id)
    {
        $view = new FAQView();
        $faqModel = new FAQModel();
        $user = Auth::optionalUser();

        $faq = $faqModel->getById($id);
        if (!$faq) {
            die("Không tìm thấy câu hỏi FAQ với ID #{$id}");
        }

        $category = [
            'id' => $faq['category_id'] ?? null,
            'name' => $faq['category_name'] ?? 'Khác',
            'slug' => $faq['category_slug'] ?? null,
            'color' => $faq['category_color'] ?? '#6c757d',
            'active' => $faq['category_active'] ?? 0,
        ];

        return $view->render_faq_detail([
            'faq' => $faq,
            'category' => $category,
            'user' => $user,
        ]);
    }

    public function questions()
    {
        Auth::requireLogin();

        $view = new FAQView();
        $catModel = new FAQCategoryModel();
        $faqQuestionModel = new FAQQuestionModel();

        $keyword = trim($_GET['keyword'] ?? '');
        $category_id = $_GET['category_id'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $statuses = ['pending', 'answered'];
        if (Auth::isAdminOrStaff()) {
            $statuses = [];
        }

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $categories = $catModel->getAllCategories();

        $questions = $faqQuestionModel->getAllQuestions(
            $keyword,
            $category_id,
            $statuses,
            $sort,
            $limit,
            $offset
        );

        $total = $faqQuestionModel->countAll($keyword, $category_id, $statuses);
        $totalPages = ceil($total / $limit);

        return $view->render_questions([
            'pageTitle' => 'Câu hỏi từ cộng đồng',
            'categories' => $categories,
            'faqQuestions' => $questions,
            'keyword' => htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'),
            'category_id' => $category_id,
            'status' => $statuses,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function questionDetail($id)
    {
        Auth::requireLogin();

        $id = (int) $id;
        $questionModel = new FAQQuestionModel();
        $question = $questionModel->getById($id);

        if (!$question) {
            $_SESSION['error'] = 'Câu hỏi không tồn tại hoặc đã bị xóa.';
            header('Location: ' . BASE_URL . '/cms/faq/user');
            exit;
        }

        $comments = $questionModel->getComments($id);
        $questionModel->incrementViews($id);

        $view = new FAQView();
        $view->render_question_detail([
            'pageTitle' => 'Chi tiết câu hỏi người dùng',
            'question' => $question,
            'comments' => $comments
        ]);
    }

    public function questCmt($id)
    {
        Auth::requireLogin();

        $id = (int) $id;
        $userId = $_SESSION['user']['id'] ?? null;
        $content = $_POST['content'] ?? '';

        (new FAQQuestionModel())->addComment($id, $userId, $content);

        $this->redirectWithMessage(BASE_URL . '/questions/' . $id, 'Đã thêm phản hồi', 'success');
    }
}
