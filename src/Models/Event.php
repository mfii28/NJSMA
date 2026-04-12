<?php
namespace Models;
use Core\Database;

class Event {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAll() { return $this->db->fetchAll("SELECT * FROM tblevents ORDER BY EventDate DESC"); }
    public function getUpcoming() { return $this->db->fetchAll("SELECT * FROM tblevents WHERE EventDate >= NOW() ORDER BY EventDate ASC"); }
}
