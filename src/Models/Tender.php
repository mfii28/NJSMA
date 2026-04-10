<?php

namespace Models;

use Core\Database;

class Tender {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getActive() {
        return $this->db->fetchAll("SELECT * FROM tbltenders WHERE Status = 'Open' ORDER BY Deadline ASC");
    }
}
