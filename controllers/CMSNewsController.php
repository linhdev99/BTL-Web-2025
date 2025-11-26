<?php

namespace Controllers;

use Core\Auth;
use Models\NewsModel;

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

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $result = $this->newsModel->paginate($page, ADMIN_ITEMS_PER_PAGE, null, [], 'created_at DESC');

        $this->view('admin/news/index', [
            'pageTitle' => 'Quản lý tin tức',
            'newsList' => $result['data'],
            'pagination' => $result
        ]);
    }

    /**
     * Show add news form
     */
    public function add()
    {
        Auth::requireAdminOrStaff();

        $this->view('admin/news/add', [
            'pageTitle' => 'Thêm tin tức'
        ]);
    }

    /**
     * Store new news
     */
    public function store()
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Yêu cầu không hợp lệ', 'error');
            return;
        }

        // Validate required fields
        $errors = [];
        if (empty($_POST['title'])) {
            $errors[] = 'Tiêu đề không được để trống';
        }
        if (empty($_POST['content'])) {
            $errors[] = 'Nội dung không được để trống';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASE_URL . '/cms/news/add');
            exit;
        }

        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadImage($_FILES['image'], 'uploads/news');
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                $_SESSION['error'] = $uploadResult['error'];
                $_SESSION['old'] = $_POST;
                header('Location: ' . BASE_URL . '/cms/news/add');
                exit;
            }
        }

        // Prepare data - using BTL-Web-2025 schema
        $data = [
            'title' => trim($_POST['title']),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content']),
            'thumbnail' => $imagePath,
            'published_at' => !empty($_POST['published_at']) ? date('Y-m-d H:i:s', strtotime($_POST['published_at'])) : null,
            'is_published' => isset($_POST['status']) && $_POST['status'] === 'published' ? 1 : 0,
            'user_id' => $_SESSION['user']['id'] ?? null
        ];

        // Insert news
        $newsId = $this->newsModel->insert('news', $data);

        if ($newsId) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Đã thêm tin tức thành công', 'success');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi thêm tin tức';
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

        $news = $this->newsModel->getNewsById($id);

        if (!$news) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Tin tức không tồn tại', 'error');
            return;
        }

        $this->view('admin/news/edit', [
            'pageTitle' => 'Sửa tin tức',
            'news' => $news
        ]);
    }

    /**
     * Update news
     */
    public function update($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Yêu cầu không hợp lệ', 'error');
            return;
        }

        // Check if news exists
        $news = $this->newsModel->getNewsById($id);
        if (!$news) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Tin tức không tồn tại', 'error');
            return;
        }

        // Validate required fields
        $errors = [];
        if (empty($_POST['title'])) {
            $errors[] = 'Tiêu đề không được để trống';
        }
        if (empty($_POST['content'])) {
            $errors[] = 'Nội dung không được để trống';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASE_URL . '/cms/news/edit/' . $id);
            exit;
        }

        // Handle image upload
        $imagePath = $news['thumbnail']; // Keep existing image by default
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadImage($_FILES['image'], 'uploads/news');
            if ($uploadResult['success']) {
                // Delete old image if exists
                if (!empty($news['thumbnail']) && file_exists(PATH_ROOT . '/' . $news['thumbnail'])) {
                    unlink(PATH_ROOT . '/' . $news['thumbnail']);
                }
                $imagePath = $uploadResult['path'];
            } else {
                $_SESSION['error'] = $uploadResult['error'];
                $_SESSION['old'] = $_POST;
                header('Location: ' . BASE_URL . '/cms/news/edit/' . $id);
                exit;
            }
        }

        // Prepare data - using BTL-Web-2025 schema
        $data = [
            'title' => trim($_POST['title']),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content']),
            'thumbnail' => $imagePath,
            'published_at' => !empty($_POST['published_at']) ? date('Y-m-d H:i:s', strtotime($_POST['published_at'])) : $news['published_at'],
            'is_published' => isset($_POST['status']) && $_POST['status'] === 'published' ? 1 : 0
        ];

        // Update news
        $success = $this->newsModel->update('news', $data, 'id = :id', ['id' => $id]);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/news', 'Đã cập nhật tin tức thành công', 'success');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật tin tức';
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
