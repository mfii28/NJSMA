<?php
namespace Models;
use Core\Database;

class Budget {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAll() { return $this->db->fetchAll("SELECT * FROM tblbudgets ORDER BY ReportYear DESC, Category ASC"); }
    public function getByCategory($cat) { return $this->db->fetchAll("SELECT * FROM tblbudgets WHERE Category = :c ORDER BY ReportYear DESC", ['c' => $cat]); }
}
