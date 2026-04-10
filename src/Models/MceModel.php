<?php

namespace Models;

use Core\Database;

class MceModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getMceInfo() {
        return $this->db->fetch("SELECT * FROM mce LIMIT 1");
    }
}
