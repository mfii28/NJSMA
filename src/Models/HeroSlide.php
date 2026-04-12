<?php
namespace Models;
use Core\Database;

class HeroSlide {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getActive() { return $this->db->fetchAll("SELECT * FROM tblhero_slides WHERE is_active = 1 ORDER BY display_order ASC"); }
}
