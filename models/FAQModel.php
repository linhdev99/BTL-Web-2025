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
                        f.*,
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
     * Lấy chi tiết 1 FAQ theo ID (kèm thông tin category)
     */
    public function getById(int $id)
    {
        $sql = "
        SELECT 
            f.*,
            c.name  AS category_name,
            c.slug  AS category_slug,
            c.color AS category_color,
            c.is_active AS category_active
        FROM faq AS f
        LEFT JOIN faq_categories AS c ON f.category_id = c.id
        WHERE f.id = :id
        LIMIT 1
    ";
        return $this->getOne($sql, ['id' => $id]);
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

    public function getAllActiveFAQ()
    {
        $sql = "
                    SELECT 
                        f.*,
                        c.name  AS category_name,
                        c.slug  AS category_slug,
                        c.color AS category_color,
                        c.is_active AS category_active
                    FROM {$this->table} AS f
                    LEFT JOIN faq_categories AS c ON f.category_id = c.id
                    WHERE f.is_active = 1
                    ORDER BY f.ordering ASC, f.id DESC
                ";

        return $this->getAll($sql);
    }
}
