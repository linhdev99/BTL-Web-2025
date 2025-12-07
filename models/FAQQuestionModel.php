<?php

namespace Models;

class FAQQuestionModel extends BaseModel
{
    protected string $table = "faq_questions";
    protected string $table_categories = "faq_categories";
    protected string $table_comments = "faq_comments";

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
    public function getAllQuestions(
        string $keyword = '',
        string $category_id = '',
        array $statusList = [],
        string $sort = 'newest',
        int $limit = 20,
        int $offset = 0
    ) {
        $sql = "
                    SELECT 
                        q.*,
                        u.full_name AS full_name,
                        u.avatar AS avatar,
                        u.email AS user_email,
                        c.name AS category_name,
                        c.color AS category_color,
                        (
                            SELECT COUNT(*) 
                            FROM {$this->table_comments} AS fc 
                            WHERE fc.question_id = q.id
                        ) AS total_comments
                    FROM {$this->table} AS q
                    LEFT JOIN users AS u ON q.user_id = u.id
                    LEFT JOIN {$this->table_categories} AS c ON q.category_id = c.id
                    WHERE 1
                ";

        $params = [];

        // --- Tìm kiếm theo từ khóa
        if (!empty($keyword)) {
            $sql .= " AND q.question LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        // --- Lọc theo thể loại
        if (!empty($category_id)) {
            $sql .= " AND q.category_id = :category_id";
            $params[':category_id'] = (int) $category_id;
        }

        // --- Lọc theo danh sách trạng thái
        if (!empty($statusList)) {
            $placeholders = [];
            foreach ($statusList as $index => $status) {
                $key = ":status_$index";
                $placeholders[] = $key;
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
        $params[':limit'] = (int) $limit;
        $params[':offset'] = (int) $offset;

        // --- Thực thi
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $type = is_int($val) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindValue($key, $val, $type);
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
            $sql .= " AND q.question LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if (!empty($category_id)) {
            $sql .= " AND q.category_id = :category_id";
            $params[':category_id'] = (int) $category_id;
        }

        if (!empty($statusList)) {
            $placeholders = [];
            foreach ($statusList as $index => $status) {
                $key = ":status_$index";
                $placeholders[] = $key;
                $params[$key] = $status;
            }
            $sql .= " AND q.status IN (" . implode(', ', $placeholders) . ")";
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $type = is_int($val) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindValue($key, $val, $type);
        }

        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
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
            u.avatar AS avatar, 
            c.name AS category_name,
            c.color AS category_color
        FROM faq_questions q
        LEFT JOIN users u ON u.id = q.user_id
        LEFT JOIN faq_categories c ON c.id = q.category_id
        WHERE q.id = :id
    ", ['id' => $id]);
    }

    public function getCommentById(int $commentId)
    {
        return $this->getOne("
        SELECT 
            c.*, 
            u.full_name,
            u.email,
            q.question AS question_content,
            q.id AS question_id
        FROM faq_comments c
        LEFT JOIN users u ON u.id = c.user_id
        LEFT JOIN faq_questions q ON q.id = c.question_id
        WHERE c.id = :id
        LIMIT 1
    ", ['id' => $commentId]);
    }

    public function getComments(int $questionId)
    {
        return $this->getAll("
        SELECT 
            c.*, 
            u.full_name,
            u.avatar
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

    public function deleteComment($questionId, $commentId)
    {
        return $this->execute("
            DELETE FROM faq_comments 
            WHERE id = :commentId 
            AND question_id = :questionId
        ", [
            'commentId' => $commentId,
            'questionId' => $questionId
        ]);
    }

    public function deleteQuestion(int $id)
    {
        return $this->delete($this->table, "id = :id", ['id' => $id]);
    }

    public function insertQuestion($data)
    {
        $sql = "INSERT INTO faq_questions 
                (user_id, category_id, question, status, views, created_at, updated_at)
            VALUES 
                (:user_id, :category_id, :question, :status, :views, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':question' => $data['question'],
            ':status' => $data['status'] ?? 'pending',
            ':views' => $data['views'] ?? 0
        ]);

        return $this->db->lastInsertId();
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

    public function incrementViews(int $id)
    {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateQuestion($id, $data)
    {
        $sql = "UPDATE faq_questions 
            SET category_id = :category_id,
                question = :question,
                updated_at = :updated_at
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':category_id' => $data['category_id'],
            ':question' => $data['question'],
            ':updated_at' => $data['updated_at'],
            ':id' => $id
        ]);
    }
}
