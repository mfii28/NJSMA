<?php
namespace Models;
use Core\Database;

class Faq {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAll() { return $this->db->fetchAll("SELECT * FROM tblfaqs ORDER BY Category, DisplayOrder ASC"); }
}
