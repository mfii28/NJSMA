<?php
namespace Models;
use Core\Database;

class Faq
{
    protected $table = 'faqs';
    private $db;

    public function __construct() 
    { 
        $this->db = Database::getInstance(); 
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY display_order ASC, id ASC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (question, answer, category, display_order, is_active)
                VALUES (:question, :answer, :category, :display_order, :is_active)";

        $params = [
            'question' => $data['question'],
            'answer' => $data['answer'],
            'category' => $data['category'] ?? 'General',
            'display_order' => $data['display_order'] ?? 0,
            'is_active' => $data['is_active'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET question = :question, answer = :answer, category = :category,
                    display_order = :display_order, is_active = :is_active
                WHERE id = :id";

        $params = [
            'question' => $data['question'],
            'answer' => $data['answer'],
            'category' => $data['category'] ?? 'General',
            'display_order' => $data['display_order'] ?? 0,
            'is_active' => $data['is_active'] ?? 1,
            'id' => $id
        ];

        return $this->db->execute($sql, $params);
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
