<?php
namespace Models;
use Core\Database;

class ZonalCouncil {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAll() { return $this->db->fetchAll("SELECT * FROM tblzonal_councils ORDER BY CouncilName ASC"); }
}
