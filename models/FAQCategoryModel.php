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
    public function create(string $name, string $color, int $is_active = 1)
    {
        $slug = $this->generateSlug($name);

        $originalSlug = $slug;
        $counter = 1;
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $this->insert($this->table, [
            "name" => $name,
            "slug" => $slug,
            "color" => $color,
            "is_active" => $is_active,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]);
    }


    // Generate slug from Vietnamese string
    private function generateSlug($string)
    {
        $string = trim($string);
        $string = mb_strtolower($string, 'UTF-8');

        // Convert Vietnamese characters to ASCII
        $vietnameseMap = [
            'á' => 'a',
            'à' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'ạ' => 'a',
            'ă' => 'a',
            'ắ' => 'a',
            'ằ' => 'a',
            'ẳ' => 'a',
            'ẵ' => 'a',
            'ặ' => 'a',
            'â' => 'a',
            'ấ' => 'a',
            'ầ' => 'a',
            'ẩ' => 'a',
            'ẫ' => 'a',
            'ậ' => 'a',
            'đ' => 'd',
            'é' => 'e',
            'è' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ẹ' => 'e',
            'ê' => 'e',
            'ế' => 'e',
            'ề' => 'e',
            'ể' => 'e',
            'ễ' => 'e',
            'ệ' => 'e',
            'í' => 'i',
            'ì' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',
            'ị' => 'i',
            'ó' => 'o',
            'ò' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ọ' => 'o',
            'ô' => 'o',
            'ố' => 'o',
            'ồ' => 'o',
            'ổ' => 'o',
            'ỗ' => 'o',
            'ộ' => 'o',
            'ơ' => 'o',
            'ớ' => 'o',
            'ờ' => 'o',
            'ở' => 'o',
            'ỡ' => 'o',
            'ợ' => 'o',
            'ú' => 'u',
            'ù' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ụ' => 'u',
            'ư' => 'u',
            'ứ' => 'u',
            'ừ' => 'u',
            'ử' => 'u',
            'ữ' => 'u',
            'ự' => 'u',
            'ý' => 'y',
            'ỳ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'ỵ' => 'y',
        ];

        $string = strtr($string, $vietnameseMap);

        // Remove special characters
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);

        // Replace multiple spaces/hyphens with single hyphen
        $string = preg_replace('/[\s-]+/', '-', $string);

        // Remove leading/trailing hyphens
        $string = trim($string, '-');

        return $string;
    }

    // Check if slug exists
    private function slugExists($slug, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
        $params = ['slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = $this->getOne($sql, $params);
        return $result && $result['count'] > 0;
    }

    // Update category
    public function updateCategory(int $id, string $name, ?string $slugInput, string $color, int $is_active)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $old = $this->getOne($sql, ['id' => $id]);

        if (!$old) {
            return false;
        }

        $slug = trim($slugInput ?? '');
        if ($slug === '') {
            $slug = $old['slug'];
        }

        if ($slug === '' || $slug === null) {
            $slug = $this->generateSlug($name);
        }

        $originalSlug = $slug;
        $counter = 1;
        while ($this->slugExists($slug, $id)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $this->update(
            $this->table,
            [
                "name" => $name,
                "slug" => $slug,
                "color" => $color,
                "is_active" => $is_active,
                "updated_at" => date('Y-m-d H:i:s')
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
