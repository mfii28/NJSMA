<?php

namespace Models;

use Core\Database;

class Management {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tblmanagement ORDER BY Rank ASC");
    }
}
