<?php

namespace Models;

class ContactModel extends BaseModel
{
    protected string $table = 'contacts';

    /**
     * Get all contacts with pagination
     */
    public function getAllContacts($page = 1, $perPage = 20, $readStatus = null)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = [];

        if ($readStatus !== null) {
            if ($readStatus === 'replied') {
                $where[] = "status = 'replied'";
            } elseif ($readStatus === 'read') {
                $where[] = "status = 'read'";
            } elseif ($readStatus === 'unread') {
                $where[] = "status = 'unread'";
            }
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
     * Create new contact
     */
    public function createContact($data)
    {
        $insertData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message']
        ];

        return $this->insert($this->table, $insertData);
    }

    /**
     * Mark contact as read
     */
    public function markAsRead($id)
    {
        return $this->update(
            $this->table,
            ['is_read' => 1, 'status' => 'read'],
            'id = :id',
            ['id' => $id]
        );
    }

    /**
     * Get unread contacts count
     */
    public function getUnreadCount()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE is_read = 0";
        $result = $this->getOne($sql);
        return $result['count'] ?? 0;
    }

    /**
     * Mark contact as unread
     */
    public function markAsUnread($id)
    {
        return $this->update(
            $this->table,
            ['is_read' => 0, 'status' => 'unread'],
            'id = :id',
            ['id' => $id]
        );
    }

    /**
     * Update contact status
     */
    public function updateStatus($id, $status)
    {
        $validStatuses = ['unread', 'read', 'replied'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $data = ['status' => $status];

        // Auto set is_read based on status
        if ($status === 'read' || $status === 'replied') {
            $data['is_read'] = 1;
        } else {
            $data['is_read'] = 0;
        }

        return $this->update(
            $this->table,
            $data,
            'id = :id',
            ['id' => $id]
        );
    }

    /**
     * Add reply to contact
     */
    public function addReply($id, $reply, $adminId)
    {
        return $this->update(
            $this->table,
            [
                'admin_reply' => $reply,
                'status' => 'replied',
                'is_read' => 1,
                'replied_at' => date('Y-m-d H:i:s'),
                'replied_by' => $adminId
            ],
            'id = :id',
            ['id' => $id]
        );
    }
}
