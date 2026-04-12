<?php

namespace Models;

use Core\Database;

class Department {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tbldepartments");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM tbldepartments WHERE id = :id", ['id' => (int)$id]);
    }

    public function getByNameSlug($slug) {
        // Simple slug match
        return $this->db->fetch("SELECT * FROM tbldepartments WHERE DeptName LIKE :slug", ['slug' => "%$slug%"]);
    }

    public function save($data) {
        $id = $data['id'] ?? 0;
        if ($id) {
            return $this->db->execute("UPDATE tbldepartments SET DeptName=:n, Description=:d, Objectives=:o, Functions=:f, HeadName=:hn, HeadTitle=:ht, HeadImage=:hi, AdminDetails=:ad WHERE id=:id",
                ['n'=>$data['DeptName'], 'd'=>$data['Description'], 'o'=>$data['Objectives'], 'f'=>$data['Functions'], 'hn'=>$data['HeadName'], 'ht'=>$data['HeadTitle'], 'hi'=>$data['HeadImage'], 'ad'=>$data['AdminDetails'], 'id'=>$id]);
        } else {
            return $this->db->execute("INSERT INTO tbldepartments (DeptName, Description, Objectives, Functions, HeadName, HeadTitle, HeadImage, AdminDetails) VALUES (:n,:d,:o,:f,:hn,:ht,:hi,:ad)",
                ['n'=>$data['DeptName'], 'd'=>$data['Description'], 'o'=>$data['Objectives'], 'f'=>$data['Functions'], 'hn'=>$data['HeadName'], 'ht'=>$data['HeadTitle'], 'hi'=>$data['HeadImage'], 'ad'=>$data['AdminDetails']]);
        }
    }

    public function delete($id) {
        return $this->db->execute("DELETE FROM tbldepartments WHERE id=:id", ['id' => (int)$id]);
    }
}
