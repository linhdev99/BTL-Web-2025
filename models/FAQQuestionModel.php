<?php

namespace Models;

use PDO;

class FAQQuestionModel extends BaseModel
{
    protected string $table = "faq_questions";

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
            SELECT q.*, u.full_name, c.name AS category_name
            FROM faq_questions q
            LEFT JOIN users u ON u.id = q.user_id
            LEFT JOIN faq_categories c ON c.id = q.category_id
            WHERE q.id = :id
        ", ['id' => $id]);
    }

    public function getComments(int $questionId)
    {
        return $this->getAll("
            SELECT c.*, u.full_name
            FROM faq_comments c
            LEFT JOIN users u ON u.id = c.user_id
            WHERE c.question_id = :qid
            ORDER BY c.created_at ASC
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

    public function getFilteredQuestions(
        string $search,
        string $sort,
        ?int $categoryId,
        int $page,
        int $limit,
        bool $isUser = false
    ) {

        $offset = ($page - 1) * $limit;

        $sql = "
            SELECT 
                f.*,
                c.name AS category_name,
                u.full_name,
                u.email,
                u.phone,
                u.avatar,
                r.name AS role_name
            FROM {$this->table} AS f
            JOIN faq_categories AS c ON f.category_id = c.id
            JOIN users AS u ON f.user_id = u.id
            JOIN roles AS r ON u.role_id = r.id
            WHERE 1 = 1
        ";

        $params = [];

        // ====== Bộ lọc ======
        if (!empty($search)) {
            $sql .= " AND f.question LIKE :search";
            $params['search'] = "%{$search}%";
        }

        if (!empty($categoryId)) {
            $sql .= " AND f.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($isUser) {
            $sql .= " AND f.status = 'active'";
        }

        // ====== Sắp xếp ======
        switch ($sort) {
            case 'oldest':
                $sql .= " ORDER BY f.created_at ASC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY f.created_at DESC";
                break;
        }

        // ====== Phân trang ======
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFilteredQuestions(
        string $search,
        ?int $categoryId,
        bool $isUser = false
    ): int {

        $sql = "
            SELECT COUNT(*) 
            FROM {$this->table} AS f
            JOIN faq_categories AS c ON f.category_id = c.id
            JOIN users AS u ON f.user_id = u.id
            JOIN roles AS r ON u.role_id = r.id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($search)) {
            $sql .= " AND f.question LIKE :search";
            $params['search'] = "%{$search}%";
        }

        if (!empty($categoryId)) {
            $sql .= " AND f.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($isUser) {
            $sql .= " AND f.status = 'active'";
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
