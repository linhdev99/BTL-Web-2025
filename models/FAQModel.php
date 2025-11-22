<?php

namespace Models;

class FAQModel extends BaseModel
{
    protected string $table = "faq";

    /**
     * Lấy toàn bộ FAQ tĩnh
     */
    public function getAllFAQ()
    {
        return $this->getAll("
            SELECT * FROM {$this->table}
            ORDER BY ordering ASC, id DESC
        ");
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
}
