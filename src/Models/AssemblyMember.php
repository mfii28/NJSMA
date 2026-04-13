<?php

namespace Models;

use Core\Database;

class AssemblyMember
{
    private $db;
    protected $table = 'tblassembly_members';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY id ASC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        return $this->db->execute(
            "INSERT INTO {$this->table} (FullName, ElectoralArea, Position, Image) VALUES (:name, :area, :position, :image)",
            [
                'name' => $data['FullName'],
                'area' => $data['ElectoralArea'] ?? '',
                'position' => $data['Position'] ?? 'Elected Member',
                'image' => $data['Image'] ?? 'default.jpg'
            ]
        );
    }

    public function update($id, $data)
    {
        return $this->db->execute(
            "UPDATE {$this->table} SET FullName = :name, ElectoralArea = :area, Position = :position, Image = :image WHERE id = :id",
            [
                'id' => $id,
                'name' => $data['FullName'],
                'area' => $data['ElectoralArea'] ?? '',
                'position' => $data['Position'] ?? 'Elected Member',
                'image' => $data['Image'] ?? 'default.jpg'
            ]
        );
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
