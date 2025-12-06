<?php

namespace Models;

class FAQQuestionModel extends BaseModel
{
    protected string $table = "faq_questions";

    /**
     * Lấy danh sách câu hỏi người dùng
     * 
     * @param string $keyword     Từ khóa tìm kiếm
     * @param string $category_id Lọc theo thể loại
     * @param array  $statusList  Danh sách trạng thái (['pending', 'answered', 'closed'])
     * @param string $sort        Kiểu sắp xếp (newest, oldest, views, pending)
     * @param int    $limit       Số dòng mỗi trang
     * @param int    $offset      Bỏ qua bao nhiêu dòng (phân trang)
     */
    public function getAllQuestions(string $keyword = '', string $category_id = '', array $statusList = [], string $sort = 'newest', int $limit = 20, int $offset = 0)
    {
        $sql = "
            SELECT 
                q.id,
                q.user_id,
                q.category_id,
                q.question,
                q.status,
                q.views,
                q.created_at,
                q.updated_at,
                u.username AS user_name,
                u.email AS user_email,
                c.name AS category_name,
                c.color AS category_color
            FROM {$this->table} AS q
            LEFT JOIN users AS u ON q.user_id = u.id
            LEFT JOIN faq_categories AS c ON q.category_id = c.id
            WHERE 1
        ";

        $params = [];

        // --- Tìm kiếm theo từ khóa
        if (!empty($keyword)) {
            $sql .= " AND (q.question LIKE :keyword OR u.username LIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        // --- Lọc theo thể loại
        if (!empty($category_id)) {
            $sql .= " AND q.category_id = :category_id";
            $params['category_id'] = (int) $category_id;
        }

        // --- Lọc theo danh sách trạng thái
        if (!empty($statusList)) {
            // Chuẩn bị danh sách placeholder động (:status_0, :status_1, ...)
            $placeholders = [];
            foreach ($statusList as $index => $status) {
                $key = "status_$index";
                $placeholders[] = ":$key";
                $params[$key] = $status;
            }
            $sql .= " AND q.status IN (" . implode(', ', $placeholders) . ")";
        }

        // --- Sắp xếp
        switch ($sort) {
            case 'views':
                $sql .= " ORDER BY q.views DESC";
                break;
            case 'oldest':
                $sql .= " ORDER BY q.created_at ASC";
                break;
            case 'pending':
                $sql .= " ORDER BY (q.status = 'pending') DESC, q.created_at DESC";
                break;
            default:
                $sql .= " ORDER BY q.created_at DESC"; // newest
                break;
        }

        // --- Phân trang
        $sql .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = (int) $limit;
        $params['offset'] = (int) $offset;

        // --- Thực thi
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            if (in_array($key, ['limit', 'offset', 'category_id'])) {
                $stmt->bindValue(':' . $key, $val, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':' . $key, $val, \PDO::PARAM_STR);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số câu hỏi (phục vụ phân trang)
     */
    public function countAll(string $keyword = '', string $category_id = '', array $statusList = [])
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM {$this->table} AS q
            LEFT JOIN users AS u ON q.user_id = u.id
            WHERE 1
        ";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (q.question LIKE :keyword OR u.username LIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        if (!empty($category_id)) {
            $sql .= " AND q.category_id = :category_id";
            $params['category_id'] = (int) $category_id;
        }

        if (!empty($statusList)) {
            $placeholders = [];
            foreach ($statusList as $index => $status) {
                $key = "status_$index";
                $placeholders[] = ":$key";
                $params[$key] = $status;
            }
            $sql .= " AND q.status IN (" . implode(', ', $placeholders) . ")";
        }

        return $this->getOne($sql, $params)['total'] ?? 0;
    }

    public function getAllQuestionsWithUser()
    {
        return $this->getAll("
            SELECT q.*, u.full_name, c.name AS category_name
            FROM faq_questions q
            LEFT JOIN users u ON u.id = q.user_id
            LEFT JOIN faq_categories c ON c.id = q.category_id
            ORDER BY q.created_at DESC
        ");
    }

    public function getById($id)
    {
        return $this->getOne("
        SELECT 
            q.*, 
            u.full_name, 
            c.name AS category_name,
            c.color AS category_color
        FROM faq_questions q
        LEFT JOIN users u ON u.id = q.user_id
        LEFT JOIN faq_categories c ON c.id = q.category_id
        WHERE q.id = :id
    ", ['id' => $id]);
    }

    public function getComments(int $questionId)
    {
        return $this->getAll("
        SELECT 
            c.*, 
            u.full_name
        FROM faq_comments c
        LEFT JOIN users u ON u.id = c.user_id
        WHERE c.question_id = :qid
        ORDER BY c.created_at DESC
    ", ['qid' => $questionId]);
    }

    public function addComment(int $questionId, int $userId, string $content)
    {
        return $this->insert("faq_comments", [
            "question_id" => $questionId,
            "user_id" => $userId,
            "content" => $content
        ]);
    }

    public function deleteQuestion(int $id)
    {
        return $this->delete($this->table, "id = :id", ['id' => $id]);
    }

    public function filterUserQuestions(string $keyword = '', $category_id = '', string $sort = 'newest')
    {
        $sql = "
                    SELECT q.*, u.full_name, c.name AS category_name
                    FROM faq_questions q
                    LEFT JOIN users u ON u.id = q.user_id
                    LEFT JOIN faq_categories c ON c.id = q.category_id
                    WHERE 1 = 1
                ";

        $params = [];

        // Lọc theo từ khóa
        if ($keyword !== '') {
            $sql .= " AND q.question LIKE :keyword";
            $params['keyword'] = "%{$keyword}%";
        }

        // Lọc theo thể loại
        if ($category_id !== '' && $category_id !== null) {
            $sql .= " AND q.category_id = :category_id";
            $params['category_id'] = (int) $category_id;
        }

        // Sắp xếp ngày
        if ($sort === 'oldest') {
            $sql .= " ORDER BY q.created_at ASC";
        } else {
            $sql .= " ORDER BY q.created_at DESC";
        }

        return $this->getAll($sql, $params);
    }

    public function countFilteredQuestions(string $keyword, $category_id)
    {
        $sql = "
        SELECT COUNT(*) AS total
        FROM faq_questions q
        WHERE 1=1
    ";

        $params = [];

        if ($keyword !== '') {
            $sql .= " AND q.question LIKE :keyword";
            $params['keyword'] = "%{$keyword}%";
        }

        // Note: faq_questions doesn't have category_id column
        // Removed category filter

        $row = $this->getOne($sql, $params);
        return $row ? (int) $row['total'] : 0;
    }

    public function paginateFilteredQuestions(string $keyword, $category_id, string $sort, int $limit, int $offset)
    {
        $sql = "
        SELECT q.*, u.full_name
        FROM faq_questions q
        LEFT JOIN users u ON u.id = q.user_id
        WHERE 1=1
    ";

        $params = [];

        if ($keyword !== '') {
            $sql .= " AND q.question LIKE :keyword";
            $params['keyword'] = "%{$keyword}%";
        }

        // Note: faq_questions doesn't have category_id column
        // Removed category filter

        // sort
        if ($sort === 'oldest')
            $sql .= " ORDER BY q.created_at ASC";
        else
            $sql .= " ORDER BY q.created_at DESC";

        // FIX LIMIT + OFFSET (important)
        $sql .= " LIMIT {$limit} OFFSET {$offset}";

        return $this->getAll($sql, $params);
    }

    public function getFilteredQuestions(string $search, string $sort, $categoryId, int $page, int $limit)
    {
        $offset = ($page - 1) * $limit;

        // Tổng số bản ghi
        $total = $this->countFilteredQuestions($search, $categoryId);
        $totalPages = max(1, ceil($total / $limit));

        // Lấy dữ liệu trang hiện tại
        $faqQuestions = $this->paginateFilteredQuestions($search, $categoryId, $sort, $limit, $offset);

        return [$faqQuestions, $totalPages];
    }
}
