<?php

namespace Models;

class CategoryModel extends BaseModel
{
    protected string $table = 'categories';

    /**
     * Get all active categories
     */
    public function getActiveCategories()
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY name ASC";
        return $this->getAll($sql);
    }

    /**
     * Get all categories
     */
    public function getAllCategories()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        return $this->getAll($sql);
    }

    /**
     * Get category by slug
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1";
        return $this->getOne($sql, ['slug' => $slug]);
    }

    /**
     * Get category by ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Get categories with product count
     */
    public function getCategoriesWithProductCount()
    {
        $sql = "SELECT c.*, COUNT(p.id) as product_count
                FROM {$this->table} c
                LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
                WHERE c.is_active = 1
                GROUP BY c.id
                ORDER BY c.name ASC";

        return $this->getAll($sql);
    }
}
