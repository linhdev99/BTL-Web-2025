<?php

namespace Controllers;

use Models\NewsModel;
use Views\NewsView;
use Core\Auth;

class NewsController
{
    protected NewsModel $model;
    protected NewsView $view;

    public function __construct()
    {
        $this->model = new NewsModel();
        $this->view = new NewsView();
    }

    /**
     * Trang danh sách tin tức (có phân trang)
     */
    public function index()
    {
        $view = new NewsView();
        $model = new NewsModel();
        $user = Auth::optionalUser();
        $onlyPublished = !Auth::isAdminOrStaff();

        // --- Nhận dữ liệu từ URL ---
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $keyword = trim($_GET['search'] ?? '');
        $sort = $_GET['sort'] ?? 'newest';

        // --- Điều kiện lọc ---
        $where = "";
        $params = [];
        $pageLimit = 9;

        // --- Nếu có từ khóa tìm kiếm ---
        if ($keyword !== '') {
            $where .= " AND (title LIKE :kw1 OR summary LIKE :kw2 OR content LIKE :kw3)";
            $params = [
                'kw1' => "%{$keyword}%",
                'kw2' => "%{$keyword}%",
                'kw3' => "%{$keyword}%",
            ];
        }

        // --- Sắp xếp ---
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

        // --- Gọi model để phân trang ---
        $pagination = $model->getDataPaginate($page, $pageLimit, $onlyPublished, $where, $params, $order);

        // --- Render ra view ---
        $view->render_index([
            'page_title' => 'Tin tức & Cập nhật',
            'pagination' => $pagination,
            'user' => $user,
            'keyword' => $keyword,
            'sort' => $sort,
        ]);
    }

    /**
     * Trang chi tiết bài viết
     */
    public function detail(int $id)
    {
        $user = Auth::optionalUser();
        $newsModel = new NewsModel();
        $news = $newsModel->getById($id);
        $related = $newsModel->getRelated($id, 4);
        $comments = $newsModel->getByNewsId($id);

        return $this->view->render_detail([
            'page_title' => $news['title'],
            'news' => $news,
            'related' => $related,
            'comments' => $comments,
            'user' => $user,
        ]);
    }

    public function comment(int $id)
    {
        Auth::requireLogin();

        $user = Auth::optionalUser();
        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            $_SESSION['error'] = "Nội dung bình luận không được để trống.";
            header("Location: /news/{$id}");
            exit;
        }

        $newsModel = new NewsModel();

        $data = [
            'news_id' => $id,
            'user_id' => $user['id'],
            'content' => $content,
        ];

        $newsModel->addComment($data);
        header("Location: /news/{$id}");
        exit;
    }

    public function deleteComment(int $id)
    {
        Auth::requireLogin();
        $user = Auth::optionalUser();
        $newsModel = new NewsModel();
        $commentId = (int) ($_POST['comment_id'] ?? 0);
        if ($commentId <= 0) {
            $_SESSION['error'] = "Yêu cầu không hợp lệ.";
            header("Location: /news/{$id}");
            exit;
        }
        $comment = $newsModel->getCommentById($commentId);
        if (!$comment) {
            $_SESSION['error'] = "Bình luận không tồn tại.";
            header("Location: /news/{$id}");
            exit;
        }

        // Chỉ cho phép chủ bình luận xoá
        if ($comment['user_id'] !== $user['id']) {
            $_SESSION['error'] = "Bạn không có quyền xoá bình luận này.";
            header("Location: /news/{$id}");
            exit;
        }

        // Thực hiện xoá
        $newsModel->deleteComment($commentId, $user["id"]);

        $_SESSION['success'] = "Đã xoá bình luận.";
        header("Location: /news/{$id}");
        exit;
    }

    public function rate(int $id)
    {
        Auth::requireLogin();
        $user = Auth::optionalUser();

        $star = (int) ($_POST['star'] ?? 0);
        if ($star < 1 || $star > 10) {
            $_SESSION['error'] = "Giá trị đánh giá không hợp lệ.";
            header("Location: /news/$id");
            exit;
        }

        $this->model->saveOrUpdate($id, $user['id'], $star);

        $_SESSION['success'] = "Cảm ơn bạn đã đánh giá bài viết!";
        header("Location: /news/$id");
        exit;
    }

}
