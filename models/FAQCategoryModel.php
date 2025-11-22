<?php

namespace Models;

class FAQCategoryModel extends BaseModel
{
    protected string $table = "faq_categories";

    public function getAllCategories()
    {
        return $this->getAll("SELECT * FROM {$this->table} ORDER BY id ASC");
    }

    // Lấy tất cả categories đang active
    public function getAllActive()
    {
        return $this->getAll("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY id ASC");
    }

    // Lấy category theo ID
    public function getById(int $id)
    {
        return $this->getOne("SELECT * FROM {$this->table} WHERE id = :id", [
            "id" => $id
        ]);
    }

    // Tạo category mới
    public function create(string $name, int $is_active = 1)
    {
        return $this->insert($this->table, [
            "name" => $name,
            "is_active" => $is_active
        ]);
    }

    // Update category
    public function updateCategory(int $id, string $name, int $is_active)
    {
        return $this->update(
            $this->table,
            [
                "name" => $name,
                "is_active" => $is_active
            ],
            "id = :id",
            ["id" => $id]
        );
    }

    // Delete category
    public function deleteCategory(int $id)
    {
        return $this->delete($this->table, "id = :id", ["id" => $id]);
    }
}
