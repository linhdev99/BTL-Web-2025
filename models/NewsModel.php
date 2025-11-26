<?php

namespace Models;

class NewsModel extends BaseModel
{
    protected string $table = 'news';

    /**
     * Get published news with author info
     */
    public function getNewsWithInfo($limit = null)
    {
        $sql = "SELECT n.*, u.full_name as author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.is_published = 1
                ORDER BY n.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }

        return $this->getAll($sql);
    }

    /**
     * Get news by ID with info
     */
    public function getNewsById($id)
    {
        $sql = "SELECT n.*, u.full_name as author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.id = :id
                LIMIT 1";

        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Get latest news
     */
    public function getLatestNews($limit = 5)
    {
        $sql = "SELECT n.*, u.full_name as author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.is_published = 1
                ORDER BY n.published_at DESC, n.created_at DESC
                LIMIT {$limit}";

        return $this->getAll($sql);
    }

    /**
     * Search news by keyword
     */
    public function search($keyword, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT n.*, u.full_name as author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.is_published = 1
                  AND (n.title LIKE :keyword OR n.content LIKE :keyword OR n.summary LIKE :keyword)
                ORDER BY n.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $params = ['keyword' => '%' . $keyword . '%'];
        $data = $this->getAll($sql, $params);

        // Get total
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}
                     WHERE is_published = 1
                       AND (title LIKE :keyword OR content LIKE :keyword OR summary LIKE :keyword)";
        $totalResult = $this->getOne($countSql, $params);
        $total = $totalResult['total'] ?? 0;

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /**
     * Get related news (by similar title/content)
     */
    public function getRelatedNews($newsId, $limit = 5)
    {
        $sql = "SELECT n.*, u.full_name as author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id
                WHERE n.is_published = 1
                  AND n.id != :id
                ORDER BY n.created_at DESC
                LIMIT {$limit}";

        return $this->getAll($sql, ['id' => $newsId]);
    }

    /**
     * Paginate news with optional where condition
     */
    public function paginate($page = 1, $perPage = 10, $where = null, $params = [], $orderBy = 'created_at DESC')
    {
        $offset = ($page - 1) * $perPage;

        // Build SQL with joins (BTL-Web-2025 schema)
        $sql = "SELECT n.*, u.full_name as author_name
                FROM {$this->table} n
                LEFT JOIN users u ON n.user_id = u.id";

        if ($where) {
            $sql .= " WHERE $where";
        }

        $sql .= " ORDER BY $orderBy LIMIT $perPage OFFSET $offset";

        $data = $this->getAll($sql, $params);

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} n";
        if ($where) {
            $countSql .= " WHERE $where";
        }
        $totalResult = $this->getOne($countSql, $params);
        $total = $totalResult['total'] ?? 0;

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage)
        ];
    }
}
