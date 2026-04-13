<?php

namespace Models;

use Core\Database;

class Document
{
    protected $table = 'tbldocuments';
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY Category ASC, UploadDate DESC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function getByCategory($category)
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE Category = :category ORDER BY UploadDate DESC", ['category' => $category]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (Title, Description, Category, FilePath)
                VALUES (:title, :description, :category, :filepath)";

        $params = [
            'title' => $data['Title'],
            'description' => $data['Description'] ?? '',
            'category' => $data['Category'] ?? 'General',
            'filepath' => $data['FilePath']
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET Title = :title, Description = :description, Category = :category, FilePath = :filepath
                WHERE id = :id";

        $params = [
            'title' => $data['Title'],
            'description' => $data['Description'] ?? '',
            'category' => $data['Category'] ?? 'General',
            'filepath' => $data['FilePath'],
            'id' => $id
        ];

        return $this->db->execute($sql, $params);
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
