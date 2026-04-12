<?php

namespace Models;

use Core\Database;

class MceModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getMceInfo() {
        return $this->db->fetch("SELECT * FROM mce WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
    }

    public function getAllMces() {
        return $this->db->fetchAll("SELECT * FROM mce ORDER BY term_start DESC, is_active DESC");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM mce WHERE id = :id", ['id' => (int)$id]);
    }

    public function save($data) {
        $id = $data['id'] ?? 0;
        if ($id) {
            return $this->db->execute("UPDATE mce SET first_name=:fn, last_name=:ln, title=:t, email=:e, phone=:p, biography=:b, vision=:v, education=:edu, term_start=:ts, term_end=:te, is_active=:ia, social_facebook=:sf, social_twitter=:st, social_linkedin=:sl, contact_email=:ce WHERE id=:id",
                ['fn'=>$data['first_name'], 'ln'=>$data['last_name'], 't'=>$data['title'], 'e'=>$data['email'], 'p'=>$data['phone'], 'b'=>$data['biography'], 'v'=>$data['vision'], 'edu'=>$data['education'], 'ts'=>$data['term_start'], 'te'=>$data['term_end'], 'ia'=>$data['is_active'], 'sf'=>$data['social_facebook'], 'st'=>$data['social_twitter'], 'sl'=>$data['social_linkedin'], 'ce'=>$data['contact_email'], 'id'=>$id]);
        } else {
            return $this->db->execute("INSERT INTO mce (first_name, last_name, title, email, phone, biography, vision, education, term_start, term_end, is_active, social_facebook, social_twitter, social_linkedin, contact_email) VALUES (:fn,:ln,:t,:e,:p,:b,:v,:edu,:ts,:te,:ia,:sf,:st,:sl,:ce)",
                ['fn'=>$data['first_name'], 'ln'=>$data['last_name'], 't'=>$data['title'], 'e'=>$data['email'], 'p'=>$data['phone'], 'b'=>$data['biography'], 'v'=>$data['vision'], 'edu'=>$data['education'], 'ts'=>$data['term_start'], 'te'=>$data['term_end'], 'ia'=>$data['is_active'], 'sf'=>$data['social_facebook'], 'st'=>$data['social_twitter'], 'sl'=>$data['social_linkedin'], 'ce'=>$data['contact_email']]);
        }
    }

    public function delete($id) {
        return $this->db->execute("DELETE FROM mce WHERE id=:id", ['id' => (int)$id]);
    }

    public function setActive($id) {
        // Deactivate all first
        $this->db->execute("UPDATE mce SET is_active = 0");
        // Activate selected
        return $this->db->execute("UPDATE mce SET is_active = 1 WHERE id=:id", ['id' => (int)$id]);
    }
}
