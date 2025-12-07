<?php

namespace Models;

use PDO;

class AboutModel extends BaseModel
{
    protected string $table = 'about';

    public function getAllData(): array
    {
        $sql = "SELECT title, content FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        return $result ?: [];
    }
    public function updateContent(string $title, string $content): bool
    {
        // Kiểm tra xem title đã tồn tại chưa
        $checkSql = "SELECT COUNT(*) FROM {$this->table} WHERE title = :title";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute(['title' => $title]);
        $exists = $checkStmt->fetchColumn() > 0;

        if ($exists) {
            // Nếu tồn tại → cập nhật
            $sql = "UPDATE {$this->table} 
                    SET content = :content, updated_at = NOW() 
                    WHERE title = :title";
        } else {
            // Nếu chưa có → thêm mới
            $sql = "INSERT INTO {$this->table} (title, content, created_at, updated_at)
                    VALUES (:title, :content, NOW(), NOW())";
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'content' => $content
        ]);
    }
}
