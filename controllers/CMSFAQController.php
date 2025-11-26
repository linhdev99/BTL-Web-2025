<?php

namespace Controllers;

use Core\Auth;
use Models\FAQModel;
use Models\FAQCategoryModel;
use Models\FAQQuestionModel;

class CMSFAQController extends BaseController
{
    /**
     * Trang HOME của FAQ - có 3 nút chuyển module
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        $this->view('admin/faq/index', [
            'pageTitle' => 'Quản lý FAQ'
        ]);
    }

    // ============================================================
    //  MODULE 1 — FAQ CATEGORY (faq-category/)
    // ============================================================

    public function category()
    {
        Auth::requireAdminOrStaff();

        $categories = (new FAQCategoryModel())->getAllCategories();

        $this->view('admin/faq/category/index', [
            'pageTitle' => 'Quản lý thể loại FAQ',
            'categories' => $categories
        ]);
    }

    public function categoryAdd()
    {
        Auth::requireAdminOrStaff();

        $this->view('admin/faq/category/add', [
            'pageTitle' => 'Thêm thể loại FAQ'
        ]);
    }

    public function categoryStore()
    {
        Auth::requireAdminOrStaff();

        $name = $_POST['name'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->create($name, $is_active);

        $this->redirectWithMessage(BASE_URL . '/cms/faq/category', 'Đã thêm thể loại FAQ', 'success');
    }

    public function categoryEdit($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $category = (new FAQCategoryModel())->getById($id);

        $this->view('admin/faq/category/edit', [
            'pageTitle' => 'Chỉnh sửa thể loại FAQ',
            'category' => $category
        ]);
    }

    public function categoryUpdate($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $name = $_POST['name'] ?? '';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->updateCategory($id, $name, $is_active);

        $this->redirectWithMessage(BASE_URL . '/cms/faq/category', 'Đã cập nhật thể loại FAQ', 'success');
    }

    public function categoryDelete($id)
    {
        Auth::requireAdminOrStaff();
        (new FAQCategoryModel())->deleteCategory((int) $id);
        $this->redirectWithMessage(BASE_URL . '/cms/faq/category', 'Đã xóa thể loại FAQ', 'success');
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

        $this->view('admin/faq/static/index', [
            'pageTitle' => 'FAQ tĩnh',
            'staticFaq' => $staticFaq,
            'categories' => $categories,
            'categoriesMap' => $categoriesMap
        ]);
    }

    public function staticAdd()
    {
        Auth::requireAdminOrStaff();

        $categories = (new FAQCategoryModel())->getAllCategories();

        $this->view('admin/faq/static/add', [
            'pageTitle' => 'Thêm FAQ tĩnh',
            'categories' => $categories
        ]);
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

        $this->redirectWithMessage(BASE_URL . '/cms/faq/static', 'Đã thêm FAQ', 'success');
    }

    public function staticEdit($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $faq = $faqModel->getById($id);
        $categories = $catModel->getAllCategories();

        $this->view('admin/faq/static/edit', [
            'pageTitle' => 'Chỉnh sửa FAQ tĩnh',
            'faq' => $faq,
            'categories' => $categories
        ]);
    }

    public function staticUpdate($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $ordering = (int) ($_POST['ordering'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $category_id = (int) ($_POST['category_id'] ?? 1);

        (new FAQModel())->updateFAQ($id, $question, $answer, $ordering, $isActive, $category_id);

        $this->redirectWithMessage(BASE_URL . '/cms/faq/static', 'Đã cập nhật FAQ', 'success');
    }

    public function staticDelete($id)
    {
        Auth::requireAdminOrStaff();
        (new FAQModel())->deleteFAQ((int) $id);
        $this->redirectWithMessage(BASE_URL . '/cms/faq/static', 'Đã xóa FAQ', 'success');
    }

    // ============================================================
    //  MODULE 3 — FAQ USER INTERACTION (faq-user/)
    // ============================================================

    public function user()
    {
        Auth::requireAdminOrStaff();

        $keyword = $_GET['keyword'] ?? '';
        $category_id = $_GET['category_id'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $questionModel = new FAQQuestionModel();
        $catModel = new FAQCategoryModel();

        $categories = $catModel->getAllCategories();

        // Đếm tổng bản ghi
        $total = $questionModel->countFilteredQuestions($keyword, $category_id);

        // Lấy dữ liệu theo trang
        $userQuestions = $questionModel->paginateFilteredQuestions(
            $keyword,
            $category_id,
            $sort,
            $limit,
            $offset
        );

        $totalPages = ceil($total / $limit);

        $this->view('admin/faq/user/index', [
            'pageTitle' => 'FAQ người dùng',
            'userQuestions' => $userQuestions,
            'categories' => $categories,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function userDetail($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;

        $questionModel = new FAQQuestionModel();
        $question = $questionModel->getById($id);
        $comments = $questionModel->getComments($id);

        $this->view('admin/faq/user/detail', [
            'pageTitle' => 'Chi tiết câu hỏi người dùng',
            'question' => $question,
            'comments' => $comments
        ]);
    }

    public function userReply($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $content = $_POST['content'] ?? '';
        $adminId = $_SESSION['user']['id'] ?? null;

        (new FAQQuestionModel())->addComment($id, $adminId, $content);

        $this->redirectWithMessage(BASE_URL . '/cms/faq/user/detail/' . $id, 'Đã thêm phản hồi', 'success');
    }

    public function userDelete($id)
    {
        Auth::requireAdminOrStaff();

        (new FAQQuestionModel())->deleteQuestion((int) $id);

        $this->redirectWithMessage(BASE_URL . '/cms/faq/user', 'Đã xóa câu hỏi', 'success');
    }

    public function userUpdateStatus($id)
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

        $this->redirectWithMessage(BASE_URL . '/cms/faq/user/detail/' . $id, 'Đã cập nhật trạng thái', 'success');
    }

}
