<?php

namespace Models;

use Core\Database;

class Service
{
    private $db;
    protected $table = 'services';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllActive()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
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
        $sql = "INSERT INTO {$this->table} (title, description, icon, link, link_text, is_active, display_order) 
                VALUES (:title, :description, :icon, :link, :link_text, :is_active, :display_order)";
        
        return $this->db->execute($sql, [
            'title' => $data['title'],
            'description' => $data['description'],
            'icon' => $data['icon'] ?? 'bi-briefcase',
            'link' => $data['link'] ?? '',
            'link_text' => $data['link_text'] ?? 'Learn More',
            'is_active' => $data['is_active'] ?? 1,
            'display_order' => $data['display_order'] ?? 0
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET title = :title, 
                    description = :description, 
                    icon = :icon, 
                    link = :link, 
                    link_text = :link_text, 
                    is_active = :is_active, 
                    display_order = :display_order 
                WHERE id = :id";
        
        return $this->db->execute($sql, [
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'icon' => $data['icon'] ?? 'bi-briefcase',
            'link' => $data['link'] ?? '',
            'link_text' => $data['link_text'] ?? 'Learn More',
            'is_active' => $data['is_active'] ?? 1,
            'display_order' => $data['display_order'] ?? 0
        ]);
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
