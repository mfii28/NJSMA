<?php

namespace Models;

use Core\Database;

class Department {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tbldepartments");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM tbldepartments WHERE id = :id", ['id' => (int)$id]);
    }

    public function getByNameSlug($slug) {
        // Simple slug match
        return $this->db->fetch("SELECT * FROM tbldepartments WHERE DeptName LIKE :slug", ['slug' => "%$slug%"]);
    }
}
