<?php
namespace Models;
use Core\Database;

class Event
{
    protected $table = 'tblevents';
    private $db;

    public function __construct() { $this->db = Database::getInstance(); }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY EventDate DESC");
    }

    public function getUpcoming()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE EventDate >= NOW() ORDER BY EventDate ASC");
    }

    public function getById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, description, EventDate, EventTime, location, image, is_active)
                VALUES (:title, :description, :EventDate, :EventTime, :location, :image, :is_active)";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'EventDate' => $data['EventDate'],
            'EventTime' => $data['EventTime'] ?? null,
            'location' => $data['location'] ?? '',
            'image' => $data['image'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET title = :title, description = :description, EventDate = :EventDate,
                    EventTime = :EventTime, location = :location, image = :image, is_active = :is_active
                WHERE id = :id";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'EventDate' => $data['EventDate'],
            'EventTime' => $data['EventTime'] ?? null,
            'location' => $data['location'] ?? '',
            'image' => $data['image'] ?? '',
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
