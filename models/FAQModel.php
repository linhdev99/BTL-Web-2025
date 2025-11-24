<?php

namespace Models;
use PDO;

class FAQModel extends BaseModel
{
    protected string $table = "faq";
    protected string $table_category = "faq_categories";

    public function getAllFAQ()
    {
        return $this->getAll("
            SELECT 
                f.*,
                c.name AS category_name
            FROM {$this->table} AS f
            LEFT JOIN {$this->table_category} AS c ON f.category_id = c.id
            ORDER BY f.ordering ASC, f.id DESC
        ");
    }

    public function getActiveFAQ()
    {
        $stmt = $this->db->prepare("
            SELECT 
                f.id,
                f.category_id,
                c.name AS category_name,
                f.question,
                f.answer,
                f.ordering,
                f.is_active,
                f.updated_at
            FROM {$this->table} AS f
            JOIN {$this->table_category} AS c ON f.category_id = c.id
            WHERE f.is_active = 1 AND c.is_active = 1
            ORDER BY f.ordering ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy 1 FAQ theo ID
     */
    public function getById(int $id)
    {
        return $this->getOne("
            SELECT 
                f.*,
                c.name AS category_name
            FROM {$this->table} AS f
            LEFT JOIN {$this->table_category} AS c ON f.category_id = c.id
            WHERE f.id = :id
        ", ['id' => $id]);
    }

    /**
     * Tạo FAQ mới
     */
    public function create(string $question, string $answer, int $ordering, int $isActive, int $category_id)
    {
        return $this->insert($this->table, [
            'question' => $question,
            'answer' => $answer,
            'ordering' => $ordering,
            'is_active' => $isActive,
            'category_id' => $category_id
        ]);
    }

    /**
     * Cập nhật FAQ
     */
    public function updateFAQ(
        int $id,
        string $question,
        string $answer,
        int $ordering,
        int $isActive,
        int $category_id
    ) {
        return $this->update(
            $this->table,
            [
                "question" => $question,
                "answer" => $answer,
                "ordering" => $ordering,
                "is_active" => $isActive,
                "category_id" => $category_id
            ],
            "id = :id",
            ["id" => $id]
        );
    }

    /**
     * Xoá FAQ
     */
    public function deleteFAQ(int $id)
    {
        return $this->delete($this->table, "id = :id", ['id' => $id]);
    }

    public function getFrontendFAQ(string $keyword, $category_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND question LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }

        if ($category_id !== '' && $category_id !== null) {
            $sql .= " AND category_id = :cat_id";
            $params['cat_id'] = $category_id;
        }

        $sql .= " ORDER BY ordering ASC";

        return $this->getAll($sql, $params);
    }
}
