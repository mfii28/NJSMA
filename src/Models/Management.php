<?php

namespace Models;

use Core\Database;

class Management
{
    private $db;
    protected $table = 'tblmanagement';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY Rank ASC, id ASC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        return $this->db->execute(
            "INSERT INTO {$this->table} (FullName, Position, Image, Bio, Rank) VALUES (:name, :position, :image, :bio, :rank)",
            [
                'name' => $data['FullName'],
                'position' => $data['Position'],
                'image' => $data['Image'] ?? 'default.jpg',
                'bio' => $data['Bio'] ?? '',
                'rank' => $data['Rank'] ?? 0
            ]
        );
    }

    public function update($id, $data)
    {
        return $this->db->execute(
            "UPDATE {$this->table} SET FullName = :name, Position = :position, Image = :image, Bio = :bio, Rank = :rank WHERE id = :id",
            [
                'id' => $id,
                'name' => $data['FullName'],
                'position' => $data['Position'],
                'image' => $data['Image'] ?? 'default.jpg',
                'bio' => $data['Bio'] ?? '',
                'rank' => $data['Rank'] ?? 0
            ]
        );
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
