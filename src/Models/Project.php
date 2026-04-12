<?php
namespace Models;
use Core\Database;

class Project {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAll() { return $this->db->fetchAll("SELECT * FROM tblprojects ORDER BY CreatedAt DESC"); }
    public function getActive() { return $this->db->fetchAll("SELECT * FROM tblprojects WHERE Status != 'Completed' ORDER BY StartDate DESC"); }
    public function getById($id) { return $this->db->fetch("SELECT * FROM tblprojects WHERE id = :id", ['id' => $id]); }
}
