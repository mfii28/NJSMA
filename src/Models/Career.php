<?php
namespace Models;
use Core\Database;

class Career {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAllActive() { return $this->db->fetchAll("SELECT j.*, d.DeptName FROM tblcareers j LEFT JOIN tbldepartments d ON d.id = j.DepartmentId WHERE j.Status = 'Active' ORDER BY j.CreatedAt DESC"); }
}
