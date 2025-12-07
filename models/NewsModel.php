<?php

namespace Models;

class NewsModel extends BaseModel
{
    protected string $table = 'news';
    protected string $table_cmt = 'news_cmt';
    protected string $table_rating = 'news_rating';

    /* =========================================================
     * 📰 PUBLIC (dành cho người dùng)
     * ========================================================= */

    /**
     * Lấy danh sách tin đã xuất bản (có tác giả)
     */
    public function getDataPaginate(int $page = 1, int $perPage = 9, ?bool $onlyPublished = false, ?string $where = null, array $params = [], string $orderBy = 'n.published_at DESC, n.created_at DESC')
    {

        $offset = ($page - 1) * $perPage;
        $sql = "SELECT 
                n.*, 
                u.full_name AS full_name,
                ROUND(AVG(r.star), 1) AS avg_rating,
                COUNT(r.id) AS rating_count
            FROM {$this->table} n
            LEFT JOIN users u ON n.user_id = u.id
            LEFT JOIN news_rating r ON r.news_id = n.id";

        // ✅ Xử lý điều kiện WHERE
        $whereClauses = [];

        if ($onlyPublished) {
            $whereClauses[] = "n.is_published = 1";
        }

        if (!empty($where)) {
            $whereClauses[] = "({$where})";
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql .= " GROUP BY n.id";

        $sql .= " ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";

        $data = $this->getAll($sql, $params);

        $countSql = "SELECT COUNT(*) AS total FROM {$this->table} n";
        if (!empty($whereClauses)) {
            $countSql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $totalResult = $this->getOne($countSql, $params);
        $total = (int) ($totalResult['total'] ?? 0);

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => max(1, ceil($total / $perPage)),
        ];
    }

    /**
     * Lấy tin theo slug (hiển thị chi tiết bài viết)
     */
    public function getBySlug(string $slug)
    {
        $sql = "SELECT n.*, u.full_name AS author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.slug = :slug AND n.is_published = 1
                LIMIT 1";

        return $this->getOne($sql, ['slug' => $slug]);
    }

    /**
     * Lấy tin liên quan (loại trừ chính nó)
     */
    public function getRelated(int $id, int $limit = 4)
    {
        $sql = "SELECT n.*, u.full_name AS full_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.is_published = 1
                  AND n.id != :id
                ORDER BY n.created_at DESC
                LIMIT {$limit}";

        return $this->getAll($sql, ['id' => $id]);
    }

    /**
     * Tìm kiếm tin (theo title, summary, content)
     */
    public function search(string $keyword, int $page = 1, int $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $params = ['keyword' => '%' . $keyword . '%'];

        $sql = "SELECT n.*, u.full_name AS author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.is_published = 1
                  AND (n.title LIKE :keyword OR n.summary LIKE :keyword OR n.content LIKE :keyword)
                ORDER BY n.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $data = $this->getAll($sql, $params);

        $countSql = "SELECT COUNT(*) AS total FROM {$this->table}
                     WHERE is_published = 1
                       AND (title LIKE :keyword OR summary LIKE :keyword OR content LIKE :keyword)";
        $total = ($this->getOne($countSql, $params)['total']) ?? 0;

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /* =========================================================
     * ⚙️ ADMIN / STAFF (toàn quyền quản lý tin)
     * ========================================================= */

    /**
     * Phân trang tất cả tin tức (admin/staff)
     */
    public function paginateAll(int $page = 1, int $perPage = 10, ?string $where = null, array $params = [], string $orderBy = 'created_at DESC')
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT n.*, u.full_name AS author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id";

        if ($where) {
            $sql .= " WHERE $where";
        }

        $sql .= " ORDER BY $orderBy LIMIT $perPage OFFSET $offset";

        $data = $this->getAll($sql, $params);

        // Tổng số bản ghi
        $countSql = "SELECT COUNT(*) AS total FROM {$this->table} n";
        if ($where) {
            $countSql .= " WHERE $where";
        }
        $total = ($this->getOne($countSql, $params)['total']) ?? 0;

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /**
     * Lấy tin theo ID (có thể chưa publish)
     */
    public function getById(int $id)
    {
        $sql = "SELECT 
                n.*, 
                u.full_name AS full_name,
                u.avatar AS avatar,
                ROUND(AVG(r.star), 1) AS avg_rating,
                COUNT(r.id) AS rating_count
            FROM {$this->table} n
            LEFT JOIN users u ON n.user_id = u.id
            LEFT JOIN news_rating r ON r.news_id = n.id
            WHERE n.id = :id
            GROUP BY n.id
            LIMIT 1";

        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Tạo mới tin
     */
    public function create(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật tin
     */
    public function updateById(int $id, array $data)
    {
        return $this->update($this->table, $data, 'id = :id', ['id' => $id]);
    }

    /**
     * Xóa tin
     */
    public function deleteById(int $id)
    {
        return $this->delete($this->table, 'id = :id', ['id' => $id]);
    }

    /**
     * Đổi trạng thái xuất bản
     */
    public function togglePublish(int $id, bool $state)
    {
        $data = [
            'is_published' => $state ? 1 : 0,
            'published_at' => $state ? date('Y-m-d H:i:s') : null,
        ];
        return $this->update($this->table, $data, 'id = :id', ['id' => $id]);
    }


    /* =========================================================
     * 📰 PHẦN XỬ LÝ BÌNH LUẬN (comments)
     * ========================================================= */

    /**
     * Lấy danh sách bình luận của một bài viết
     */
    public function getByNewsId(int $newsId)
    {
        $sql = "SELECT c.*,
                       u.full_name AS full_name,
                       u.avatar AS avatar
                FROM {$this->table_cmt} c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.news_id = :news_id
                ORDER BY c.created_at DESC";

        return $this->getAll($sql, ['news_id' => $newsId]);
    }

    /**
     * Thêm bình luận mới
     */
    public function addComment(array $data)
    {
        return $this->insert($this->table_cmt, $data);
    }

    /**
     * Xóa bình luận (chỉ dành cho admin/staff hoặc chủ sở hữu)
     */
    public function deleteComment(int $commentId, int $userId, bool $isAdmin = false)
    {
        if ($isAdmin) {
            return $this->delete($this->table_cmt, 'id = :id', ['id' => $commentId]);
        }

        // Chỉ cho phép xóa bình luận của chính user đó
        $sql = "DELETE FROM {$this->table_cmt} WHERE id = :id AND user_id = :user_id";
        return $this->execute($sql, ['id' => $commentId, 'user_id' => $userId]);
    }

    public function getCommentById(int $id)
    {
        $sql = "SELECT * FROM {$this->table_cmt} WHERE id = :id LIMIT 1";
        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Đếm số lượng bình luận của bài viết (tùy chọn)
     */
    public function countComments(int $newsId)
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table_cmt} WHERE news_id = :news_id";
        $result = $this->getOne($sql, ['news_id' => $newsId]);
        return $result['total'] ?? 0;
    }

    public function saveOrUpdate(int $newsId, int $userId, int $star): bool
    {
        $sql = "INSERT INTO {$this->table_rating} (news_id, user_id, star)
                VALUES (:news_id, :user_id, :star)
                ON DUPLICATE KEY UPDATE star = :star_update, updated_at = NOW()";

        return $this->execute($sql, [
            'news_id' => $newsId,
            'user_id' => $userId,
            'star' => $star,
            'star_update' => $star,
        ]);
    }
}
