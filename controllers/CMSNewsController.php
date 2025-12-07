<?php

namespace Controllers;

use Core\Auth;
use Models\NewsModel;
use Views\NewsView;

class CMSNewsController extends BaseController
{
    private $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    /**
     * List all news
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        $view = new NewsView();
        $model = new NewsModel();
        $onlyPublished = false;

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $keyword = trim($_GET['search'] ?? '');
        $sort = $_GET['sort'] ?? 'newest';

        $where = "";
        $params = [];
        $pageLimit = 20;

        if ($keyword !== '') {
            $where .= "(title LIKE :kw1 OR summary LIKE :kw2 OR content LIKE :kw3)";
            $params = [
                'kw1' => "%{$keyword}%",
                'kw2' => "%{$keyword}%",
                'kw3' => "%{$keyword}%",
            ];
        }

        switch ($sort) {
            case 'oldest':
                $order = 'created_at ASC';
                break;
            case 'star_desc':
                $order = 'star DESC';
                break;
            case 'star_asc':
                $order = 'star ASC';
                break;
            default:
                $order = 'created_at DESC';
                break;
        }

        $pagination = $model->getDataPaginate($page, $pageLimit, $onlyPublished, $where, $params, $order);

        $view->render_cms_index([
            'page_title' => 'Tin tức & Cập nhật',
            'pagination' => $pagination,
            'keyword' => $keyword,
            'sort' => $sort,
        ]);
    }

    /**
     * Show add news form
     */
    public function add()
    {
        Auth::requireAdminOrStaff();
        $view = new NewsView();
        $view->render_cms_add([
            'pageTitle' => 'Thêm tin tức'
        ]);
    }

    /**
     * Store new news
     */
    public function store()
    {
        Auth::requireAdminOrStaff();

        // --- Chỉ chấp nhận POST ---
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Yêu cầu không hợp lệ', 'error');
            return;
        }

        // --- Lấy và làm sạch dữ liệu ---
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $thumbnailUrl = trim($_POST['thumbnail'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $publishedAt = $_POST['published_at'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        // --- Validate cơ bản ---
        $errors = [];

        if (empty($title)) {
            $errors[] = 'Tiêu đề không được để trống';
        }
        if (empty($content)) {
            $errors[] = 'Nội dung không được để trống';
        }

        // Nếu có URL thumbnail thì phải hợp lệ
        if (!empty($thumbnailUrl) && !filter_var($thumbnailUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'URL ảnh thumbnail không hợp lệ';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASE_URL . '/cms/news/add');
            exit;
        }

        // --- Tạo slug tự động từ tiêu đề ---
        $slug = $this->generateSlug($title);

        // --- Chuẩn bị dữ liệu để lưu ---
        $data = [
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'thumbnail' => $thumbnailUrl ?: null,
            'published_at' => !empty($publishedAt) ? date('Y-m-d H:i:s', strtotime($publishedAt)) : null,
            'is_published' => ($status === 'published') ? 1 : 0,
            'user_id' => $userId,
        ];

        // --- Thực thi thêm vào DB ---
        $newsId = $this->newsModel->insert('news', $data);

        if ($newsId) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', '✅ Đã thêm tin tức thành công', 'success');
        } else {
            $_SESSION['error'] = '❌ Có lỗi xảy ra khi thêm tin tức';
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASE_URL . '/cms/news/add');
            exit;
        }
    }

    /**
     * Show edit news form
     */
    public function edit($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        if ($id <= 0) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'ID bài viết không hợp lệ', 'error');
            return;
        }

        $model = new NewsModel();
        $view = new NewsView();

        // --- Lấy bài viết ---
        $news = $model->getById($id);
        if (empty($news)) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Không tìm thấy bài viết cần chỉnh sửa', 'error');
            return;
        }

        // --- Render view edit ---
        $view->render_cms_edit([
            'pageTitle' => 'Chỉnh sửa tin tức',
            'news' => $news
        ]);
    }

    /**
     * Update news
     */
    public function update($id)
    {
        Auth::requireAdminOrStaff();

        $id = (int) $id;
        if ($id <= 0) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'ID bài viết không hợp lệ', 'error');
            return;
        }

        // Chỉ xử lý POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Yêu cầu không hợp lệ', 'error');
            return;
        }

        // Lấy dữ liệu từ form
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $thumbnailUrl = trim($_POST['thumbnail'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $publishedAt = $_POST['published_at'] ?? null;

        // Validate cơ bản
        $errors = [];

        if (empty($title)) {
            $errors[] = 'Tiêu đề không được để trống';
        }
        if (empty($content)) {
            $errors[] = 'Nội dung không được để trống';
        }
        if (!empty($thumbnailUrl) && !filter_var($thumbnailUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'URL ảnh thumbnail không hợp lệ';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASE_URL . '/cms/news/edit/' . $id);
            exit;
        }

        // Tạo slug mới từ tiêu đề
        $slug = $this->generateSlug($title);

        // Chuẩn bị dữ liệu cập nhật
        $data = [
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'thumbnail' => $thumbnailUrl ?: null,
            'published_at' => !empty($publishedAt) ? date('Y-m-d H:i:s', strtotime($publishedAt)) : null,
            'is_published' => ($status === 'published') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Gọi model cập nhật
        $updated = $this->newsModel->update('news', $data, 'id = :id', ['id' => $id]);

        if ($updated) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', '✅ Cập nhật tin tức thành công', 'success');
        } else {
            $_SESSION['error'] = '❌ Có lỗi xảy ra khi cập nhật tin tức';
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASE_URL . '/cms/news/edit/' . $id);
            exit;
        }
    }

    /**
     * Delete news
     */
    public function delete($id)
    {
        Auth::requireAdminOrStaff();

        $success = $this->newsModel->delete('news', 'id = :id', ['id' => $id]);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Đã xóa tin tức', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Có lỗi xảy ra', 'error');
        }
    }
}
