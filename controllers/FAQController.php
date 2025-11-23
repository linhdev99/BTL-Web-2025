<?php

namespace Controllers;

use Views\FAQView;
use Models\FAQModel;
use Models\FAQCategoryModel;
use Models\FAQQuestionModel;
use Controllers\BaseController;

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

        $categories = $catModel->getAllCategories();
        $faqQuestions = $faqQuestionModel->getAllQuestionsWithUser();


        return $view->render_questions([
            'categories' => $categories,
            'faqQuestions' => $faqQuestions,
        ]);
    }
}
