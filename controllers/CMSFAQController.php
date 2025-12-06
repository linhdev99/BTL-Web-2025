<?php

namespace Controllers;

use Core\Auth;
use Models\FAQModel;
use Models\FAQCategoryModel;
use Models\FAQQuestionModel;
use Views\CMSFAQView;

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
        $view = new CMSFAQView();

        $view->renderCategory([
            'pageTitle' => 'FAQ - Quản lý thể loại',
            'categories' => $categories
        ]);
    }

    public function categoryAdd()
    {
        Auth::requireAdminOrStaff();
        $view = new CMSFAQView();
        $view->renderCategoryAdd([
            'pageTitle' => 'FAQ - Thêm thể loại'
        ]);
    }

    public function categoryEdit($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $category = (new FAQCategoryModel())->getById($id);
        $view = new CMSFAQView();
        $view->renderCategoryEdit([
            'pageTitle' => 'FAQ - Chỉnh sửa thể loại',
            'category' => $category
        ]);
    }

    public function categoryStore()
    {
        Auth::requireAdminOrStaff();

        $name = trim($_POST['name'] ?? '');
        $color = trim($_POST['color'] ?? '#3498db');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->create($name, $color, $is_active);

        $this->redirectWithMessage(
            BASE_URL . '/cms/faq/category',
            'Đã thêm thể loại FAQ',
            'success'
        );
    }

    public function categoryUpdate($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $color = trim($_POST['color'] ?? '#3498db');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        (new FAQCategoryModel())->updateCategory($id, $name, $slug, $color, $is_active);

        $this->redirectWithMessage(
            BASE_URL . '/cms/faq/category',
            'Đã cập nhật thể loại FAQ',
            'success'
        );
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

        $model = new FAQModel();
        $view = new CMSFAQView();

        $limit = 5;
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $data = $model->getAllFAQ($limit, $offset);

        $countSql = "SELECT COUNT(*) AS total FROM faq";
        $totalRow = $model->getOne($countSql)['total'] ?? 0;
        $totalPages = max(1, ceil($totalRow / $limit));

        $view->renderStatic([
            'pageTitle' => 'FAQ tĩnh',
            'data' => $data,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function staticAdd()
    {
        Auth::requireAdminOrStaff();

        $catModel = new FAQCategoryModel();
        $categories = $catModel->getAllCategories();

        if (empty($categories)) {
            $_SESSION['error'] = 'Chưa có thể loại FAQ nào. Vui lòng tạo thể loại trước.';
            $this->redirect(BASE_URL . '/cms/faq/category/add');
            return;
        }

        (new CMSFAQView())->renderStaticAdd([
            'pageTitle' => 'Thêm FAQ tĩnh',
            'categories' => $categories
        ]);
    }

    public function staticEdit($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        $faqModel = new FAQModel();
        $catModel = new FAQCategoryModel();

        $faq = $faqModel->getById($id);
        if (!$faq) {
            $_SESSION['error'] = 'FAQ không tồn tại hoặc đã bị xóa.';
            $this->redirect(BASE_URL . '/cms/faq/static');
            return;
        }

        $categories = $catModel->getAllCategories();

        (new CMSFAQView())->renderStaticEdit([
            'pageTitle' => 'Chỉnh sửa FAQ tĩnh',
            'faq' => $faq,
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
        $statusParam = $_GET['status'] ?? null;
        $statuses = [];

        if (!empty($statusParam)) {
            $statuses[] = $statusParam;
        }

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $model = new FAQQuestionModel();
        $view = new CMSFAQView();

        $questions = $model->getAllQuestions($keyword, $category_id, $statuses, $sort, $limit, $offset);
        $total = $model->countAll($keyword, $category_id, $statuses);
        $totalPages = ceil($total / $limit);

        $view->renderUser([
            'pageTitle' => 'Câu hỏi người dùng',
            'questions' => $questions,
            'keyword' => $keyword,
            'category_id' => $category_id,
            'status' => $statuses,
            'sort' => $sort,
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
