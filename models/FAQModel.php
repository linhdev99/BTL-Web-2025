<?php

namespace Models;

class FAQModel extends BaseModel
{
    protected string $table = "faq";

    public function getAllFAQ()
    {
        return $this->getAll(
            "SELECT * FROM {$this->table} ORDER BY ordering ASC, id ASC"
        );
    }

    public function getById(int $id)
    {
        return $this->getOne(
            "SELECT * FROM {$this->table} WHERE id = :id",
            ['id' => $id]
        );
    }

    public function create(string $question, string $answer, int $ordering, int $isActive)
    {
        return $this->insert($this->table, [
            'question' => $question,
            'answer' => $answer,
            'ordering' => $ordering,
            'is_active' => $isActive
        ]);
    }

    public function updateFAQ(int $id, string $question, string $answer, int $ordering, int $isActive)
    {
        return $this->update(
            $this->table,
            [
                'question' => $question,
                'answer' => $answer,
                'ordering' => $ordering,
                'is_active' => $isActive
            ],
            "id = :id",
            ['id' => $id]
        );
    }

    public function deleteFAQ(int $id)
    {
        return $this->delete(
            $this->table,
            "id = :id",
            ['id' => $id]
        );
    }
}
