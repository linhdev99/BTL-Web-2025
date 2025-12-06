<?php

namespace Models;

class FAQModel extends BaseModel
{
    protected string $table = "faq";

    /**
     * Lấy toàn bộ FAQ tĩnh
     */
    public function getAllFAQ(int $limit = 10, int $offset = 0)
    {
        $sql = "
                    SELECT 
                        f.id,
                        f.category_id,
                        f.question,
                        f.answer,
                        f.ordering,
                        f.is_active,
                        f.created_at,
                        f.updated_at,
                        c.name  AS category_name,
                        c.slug  AS category_slug,
                        c.color AS category_color,
                        c.is_active AS category_active
                    FROM faq AS f
                    LEFT JOIN faq_categories AS c ON f.category_id = c.id
                    ORDER BY f.ordering ASC, f.id DESC
                    LIMIT :limit OFFSET :offset
                ";

        return $this->getAll($sql, [
            'limit' => $limit,
            'offset' => $offset
        ]);
    }

    /**
     * Lấy 1 FAQ theo ID
     */
    public function getById(int $id)
    {
        return $this->getOne("
            SELECT * FROM {$this->table}
            WHERE id = :id
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
