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
    public function getAllFAQ()
    {
        $view = new FAQView();
        $faqModel = new FAQModel();
        $isUser = Auth::isUser();
        $faqs = [];

        if ($isUser) {
            $faqs = $faqModel->getActiveFAQ();
        } else {
            $faqs = $faqModel->getAllFAQ();
        }

        return $view->render_faq(['faqs' => $faqs,]);
    }

    public function getFAQDetail($url, $id)
    {
        $user = Auth::optionalUser();
        $view = new FAQView();
        $faqModel = new FAQModel();
        $faq = $faqModel->getById($id);

        return $view->render_faq_detail([
            'user' => $user,
            'faq' => $faq,
        ]);
    }

    public function getAllQuestions()
    {
        $view = new FAQView();
        $catModel = new FAQCategoryModel();
        $faqQuestionModel = new FAQQuestionModel();

        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';
        $filterCategory = !empty($_GET['category_id']) ? (int) $_GET['category_id'] : null;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $limit = 9;

        $isUser = !Auth::isAdminOrStaff();
        error_log('isuser: ' . $isUser);

        $categories = $catModel->getAllCategories();
        $faqQuestions = $faqQuestionModel->getFilteredQuestions($search, $sort, $filterCategory, $page, $limit, $isUser);
        $totalRecords = $faqQuestionModel->countFilteredQuestions($search, $filterCategory, $isUser);
        $totalPages = ceil($totalRecords / $limit);

        return $view->render_questions([
            'categories' => $categories,
            'faqQuestions' => $faqQuestions,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'sort' => $sort,
            'filterCategory' => $filterCategory,
            'isUser' => $isUser
        ]);
    }

    public function getQuestionDetail($url, $id)
    {
        Auth::requireLogin();
        $id = (int) $id;

        $questionModel = new FAQQuestionModel();
        $question = $questionModel->getById($id);
        $comments = $questionModel->getComments($id);

        (new FAQView())->render_quest_detail(
            [
                "question" => $question,
                "comments" => $comments
            ]
        );
    }
}
