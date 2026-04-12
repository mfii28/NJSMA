<?php
namespace Models;
use Core\Database;

class Page {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }
    public function getAll() { return $this->db->fetchAll("SELECT id, PageSlug, PageTitle, UpdatedAt FROM tblpages"); }
    public function getBySlug($slug) { return $this->db->fetch("SELECT * FROM tblpages WHERE PageSlug = :s AND IsActive = 1", ['s' => $slug]); }
}
