<?php

namespace Models;

use Core\Database;

class MceModel {
    private $db;
    private $columns = null;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    private function getColumns() {
        if ($this->columns !== null) {
            return $this->columns;
        }

        $rows = $this->db->fetchAll("SHOW COLUMNS FROM mce");
        $this->columns = array_column($rows, 'Field');
        return $this->columns;
    }

    private function hasColumn($name) {
        return in_array($name, $this->getColumns(), true);
    }

    public function getMceInfo() {
        $where = $this->hasColumn('is_active') ? 'WHERE is_active = 1' : '';
        return $this->db->fetch("SELECT * FROM mce {$where} ORDER BY id DESC LIMIT 1");
    }

    public function getAllMces() {
        $orderParts = [];
        if ($this->hasColumn('term_start')) {
            $orderParts[] = 'term_start DESC';
        }
        if ($this->hasColumn('is_active')) {
            $orderParts[] = 'is_active DESC';
        }
        $orderParts[] = 'id DESC';
        $orderBy = implode(', ', $orderParts);

        return $this->db->fetchAll("SELECT * FROM mce ORDER BY {$orderBy}");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM mce WHERE id = :id", ['id' => (int)$id]);
    }

    public function save($data) {
        $id = $data['id'] ?? 0;
        $allowed = [
            'first_name', 'last_name', 'title', 'email', 'phone', 'biography', 'vision',
            'education', 'term_start', 'term_end', 'is_active', 'social_facebook',
            'social_twitter', 'social_linkedin', 'contact_email', 'image'
        ];

        $payload = [];
        foreach ($allowed as $field) {
            if ($this->hasColumn($field) && array_key_exists($field, $data)) {
                $payload[$field] = $data[$field];
            }
        }

        if (!isset($payload['first_name']) || !isset($payload['last_name'])) {
            return 0;
        }

        if ($id) {
            $setParts = [];
            $params = ['id' => $id];
            foreach ($payload as $field => $value) {
                $setParts[] = "{$field} = :{$field}";
                $params[$field] = $value;
            }

            if (!$setParts) {
                return $id;
            }

            $sql = "UPDATE mce SET " . implode(', ', $setParts) . " WHERE id = :id";
            $this->db->execute($sql, $params);
            return $id;
        } else {
            $fields = array_keys($payload);
            $placeholders = array_map(function ($field) {
                return ':' . $field;
            }, $fields);

            $sql = "INSERT INTO mce (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $this->db->execute($sql, $payload);

            if (method_exists($this->db, 'lastInsertId')) {
                return $this->db->lastInsertId();
            }

            $row = $this->db->fetch("SELECT id FROM mce ORDER BY id DESC LIMIT 1");
            return (int)($row['id'] ?? 0);
        }
    }

    public function delete($id) {
        return $this->db->execute("DELETE FROM mce WHERE id=:id", ['id' => (int)$id]);
    }

    public function setActive($id) {
        if (!$this->hasColumn('is_active')) {
            return true;
        }

        // Deactivate all first
        $this->db->execute("UPDATE mce SET is_active = 0");
        // Activate selected
        return $this->db->execute("UPDATE mce SET is_active = 1 WHERE id=:id", ['id' => (int)$id]);
    }
}
