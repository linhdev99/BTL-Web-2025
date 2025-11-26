<?php

namespace Models;

class ContactModel extends BaseModel
{
    protected string $table = 'contacts';

    /**
     * Get all contacts with pagination
     */
    public function getAllContacts($page = 1, $perPage = 20, $status = null)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = [];

        if ($status) {
            $where[] = "status = :status";
            $params['status'] = $status;
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "SELECT *
                FROM {$this->table}
                {$whereClause}
                ORDER BY created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $contacts = $this->getAll($sql, $params);

        // Get total count
        $totalSql = "SELECT COUNT(*) as total FROM {$this->table} {$whereClause}";
        $totalResult = $this->getOne($totalSql, $params);
        $total = $totalResult['total'];

        return [
            'contacts' => $contacts,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }

    /**
     * Get contact by ID
     */
    public function getContactById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Mark contact as read
     */
    public function markAsRead($id)
    {
        return $this->update(
            $this->table,
            ['status' => 'read'],
            'id = :id',
            ['id' => $id]
        );
    }
}
