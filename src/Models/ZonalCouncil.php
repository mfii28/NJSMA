<?php
namespace Models;
use Core\Database;

class ZonalCouncil
{
    protected $table = 'zonal_councils';
    private $db;

    public function __construct() 
    { 
        $this->db = Database::getInstance(); 
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY name ASC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, description, chairperson, secretary, location, contact_info, is_active)
                VALUES (:name, :description, :chairperson, :secretary, :location, :contact_info, :is_active)";

        $params = [
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'chairperson' => $data['chairperson'] ?? '',
            'secretary' => $data['secretary'] ?? '',
            'location' => $data['location'] ?? '',
            'contact_info' => $data['contact_info'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET name = :name, description = :description, chairperson = :chairperson,
                    secretary = :secretary, location = :location, contact_info = :contact_info, is_active = :is_active
                WHERE id = :id";

        $params = [
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'chairperson' => $data['chairperson'] ?? '',
            'secretary' => $data['secretary'] ?? '',
            'location' => $data['location'] ?? '',
            'contact_info' => $data['contact_info'] ?? '',
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
