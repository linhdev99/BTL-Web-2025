<?php

namespace Models;

class FAQQuestionModel extends BaseModel
{
    protected string $table = "faq_questions";

    public function getAllQuestionsWithUser()
    {
        return $this->getAll("
            SELECT q.*, u.full_name, c.name AS category_name
            FROM faq_questions q
            LEFT JOIN users u ON u.id = q.user_id
            LEFT JOIN faq_categories c ON c.id = q.category_id
            ORDER BY q.created_at DESC
        ");
    }

    public function getById($id)
    {
        return $this->getOne("
            SELECT q.*, u.full_name, c.name AS category_name
            FROM faq_questions q
            LEFT JOIN users u ON u.id = q.user_id
            LEFT JOIN faq_categories c ON c.id = q.category_id
            WHERE q.id = :id
        ", ['id' => $id]);
    }

    public function getComments(int $questionId)
    {
        return $this->getAll("
            SELECT c.*, u.full_name
            FROM faq_comments c
            LEFT JOIN users u ON u.id = c.user_id
            WHERE c.question_id = :qid
            ORDER BY c.created_at ASC
        ", ['qid' => $questionId]);
    }

    public function addComment(int $questionId, int $userId, string $content)
    {
        return $this->insert("faq_comments", [
            "question_id" => $questionId,
            "user_id" => $userId,
            "content" => $content
        ]);
    }

    public function deleteQuestion(int $id)
    {
        return $this->delete($this->table, "id = :id", ['id' => $id]);
    }
}
