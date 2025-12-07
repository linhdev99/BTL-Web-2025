<?php

namespace Models;

class ProductModel extends BaseModel
{
    protected string $table = 'products';

    /**
     * Get products with category info
     */
    public function getProductsWithCategory($limit = null)
    {
        $sql = "SELECT p.*, c.name as category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.is_active = 1
                ORDER BY p.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }

        return $this->getAll($sql);
    }

    /**
     * Get product by ID with category info
     */
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id
                LIMIT 1";

        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Get product by slug
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.slug = :slug
                LIMIT 1";

        return $this->getOne($sql, ['slug' => $slug]);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts($limit = 8)
    {
        $sql = "SELECT p.*, c.name as category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.is_active = 1 AND p.is_featured = 1
                ORDER BY p.created_at DESC
                LIMIT {$limit}";

        return $this->getAll($sql);
    }

    /**
     * Get related products
     */
    public function getRelatedProducts($productId, $categoryId, $limit = 4)
    {
        $sql = "SELECT p.*, c.name as category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.category_id = :category_id
                AND p.id != :product_id
                AND p.is_active = 1
                ORDER BY RAND()
                LIMIT {$limit}";

        return $this->getAll($sql, [
            'category_id' => $categoryId,
            'product_id' => $productId
        ]);
    }

    /**
     * Get all products with filtering (PUBLIC - only active)
     */
    public function getAllProducts($page = 1, $perPage = 12, $categoryId = null, $search = null)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = ["p.is_active = 1"];

        if ($categoryId) {
            $where[] = "p.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($search && trim($search) !== '') {
            $searchTerm = '%' . trim($search) . '%';
            $where[] = "(p.name LIKE :search1 OR p.description LIKE :search2 OR p.sku LIKE :search3 OR p.content LIKE :search4)";
            $params['search1'] = $searchTerm;
            $params['search2'] = $searchTerm;
            $params['search3'] = $searchTerm;
            $params['search4'] = $searchTerm;
        }

        $whereClause = implode(' AND ', $where);

        // Cast to int for safety
        $perPage = (int)$perPage;
        $offset = (int)$offset;

        $sql = "SELECT p.*, c.name as category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE {$whereClause}
                ORDER BY p.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $products = $this->getAll($sql, $params);

        $totalSql = "SELECT COUNT(*) as total FROM {$this->table} p WHERE {$whereClause}";
        $totalResult = $this->getOne($totalSql, $params);
        $total = $totalResult['total'];

        return [
            'products' => $products,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }

    /**
     * Get all products for admin (ALL statuses)
     */
    public function getProductsForAdmin($page = 1, $perPage = 10, $search = null)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = [];

        if ($search && trim($search) !== '') {
            $searchTerm = '%' . trim($search) . '%';
            $where[] = "(p.name LIKE :search1 OR p.sku LIKE :search2 OR p.description LIKE :search3 OR p.content LIKE :search4)";
            $params['search1'] = $searchTerm;
            $params['search2'] = $searchTerm;
            $params['search3'] = $searchTerm;
            $params['search4'] = $searchTerm;
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        // Cast to int for safety
        $perPage = (int)$perPage;
        $offset = (int)$offset;

        $sql = "SELECT p.*, c.name as category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                {$whereClause}
                ORDER BY p.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $products = $this->getAll($sql, $params);

        $totalSql = "SELECT COUNT(*) as total FROM {$this->table} p {$whereClause}";
        $totalResult = $this->getOne($totalSql, $params);
        $total = $totalResult['total'];

        return [
            'products' => $products,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }

    /**
     * Get multiple products by IDs (Fix N+1 query problem)
     */
    public function getProductsByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $sql = "SELECT p.*, c.name as category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id IN ($placeholders)";

        return $this->getAll($sql, $ids);
    }
}
