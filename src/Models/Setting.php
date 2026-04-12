<?php

namespace Models;

use Core\Database;

class Setting {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllAsKeyValue() {
        $results = $this->db->fetchAll("SELECT setting_key, setting_value FROM tblsettings");
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function update($key, $value) {
        // Use Insert On Duplicate Key Update to handle both creating and updating
        return $this->db->execute(
            "INSERT INTO tblsettings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v2",
            ['k' => $key, 'v' => $value, 'v2' => $value]
        );
    }
}
