<?php
namespace Models;
use Core\Database;

class Budget
{
    protected $table = 'budgets';
    private $db;

    public function __construct() 
    { 
        $this->db = Database::getInstance(); 
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY year DESC, created_at DESC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, description, year, amount, category, file_path, is_active)
                VALUES (:title, :description, :year, :amount, :category, :file_path, :is_active)";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'year' => $data['year'],
            'amount' => $data['amount'] ?? 0,
            'category' => $data['category'] ?? 'General',
            'file_path' => $data['file_path'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET title = :title, description = :description, year = :year,
                    amount = :amount, category = :category, file_path = :file_path, is_active = :is_active
                WHERE id = :id";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'year' => $data['year'],
            'amount' => $data['amount'] ?? 0,
            'category' => $data['category'] ?? 'General',
            'file_path' => $data['file_path'] ?? '',
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
