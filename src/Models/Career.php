<?php
namespace Models;
use Core\Database;

class Career
{
    protected $table = 'careers';
    private $db;

    public function __construct() 
    { 
        $this->db = Database::getInstance(); 
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, description, requirements, location, salary_range, deadline, is_active)
                VALUES (:title, :description, :requirements, :location, :salary_range, :deadline, :is_active)";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'requirements' => $data['requirements'] ?? '',
            'location' => $data['location'] ?? '',
            'salary_range' => $data['salary_range'] ?? '',
            'deadline' => $data['deadline'] ?? null,
            'is_active' => $data['is_active'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET title = :title, description = :description, requirements = :requirements,
                    location = :location, salary_range = :salary_range, deadline = :deadline, is_active = :is_active
                WHERE id = :id";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'requirements' => $data['requirements'] ?? '',
            'location' => $data['location'] ?? '',
            'salary_range' => $data['salary_range'] ?? '',
            'deadline' => $data['deadline'] ?? null,
            'is_active' => $data['is_active'] ?? 1,
            'id' => $id
        ];

        return $this->db->execute($sql, $params);
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function getAllActive() 
    { 
        return $this->db->fetchAll("SELECT j.*, d.DeptName FROM tblcareers j LEFT JOIN tbldepartments d ON d.id = j.DepartmentId WHERE j.Status = 'Active' ORDER BY j.CreatedAt DESC"); 
    }
}
