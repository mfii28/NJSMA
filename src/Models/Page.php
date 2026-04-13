<?php
namespace Models;
use Core\Database;

class Page
{
    protected $table = 'pages';
    private $db;

    public function __construct() 
    { 
        $this->db = Database::getInstance(); 
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY title ASC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function getBySlug($slug)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE slug = :slug AND is_active = 1", ['slug' => $slug]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, slug, content, meta_description, meta_keywords, is_active)
                VALUES (:title, :slug, :content, :meta_description, :meta_keywords, :is_active)";

        $params = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? strtolower(str_replace(' ', '-', $data['title'])),
            'content' => $data['content'] ?? '',
            'meta_description' => $data['meta_description'] ?? '',
            'meta_keywords' => $data['meta_keywords'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET title = :title, slug = :slug, content = :content,
                    meta_description = :meta_description, meta_keywords = :meta_keywords, is_active = :is_active
                WHERE id = :id";

        $params = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? strtolower(str_replace(' ', '-', $data['title'])),
            'content' => $data['content'] ?? '',
            'meta_description' => $data['meta_description'] ?? '',
            'meta_keywords' => $data['meta_keywords'] ?? '',
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
