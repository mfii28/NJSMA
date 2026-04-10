<?php

namespace Models;

use Core\Database;

class AssemblyMember {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tblassembly_members ORDER BY FullName ASC");
    }
}
