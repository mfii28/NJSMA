<?php

namespace Models;

use Core\Database;

class Document {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tbldocuments ORDER BY UploadDate DESC");
    }

    public function getByCategory($category) {
        return $this->db->fetchAll("SELECT * FROM tbldocuments WHERE Category = :cat", ['cat' => $category]);
    }
}
