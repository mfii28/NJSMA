<?php

namespace Models;

use Core\Database;

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllActive($limit = 8, $offset = 0) {
        $sql = "SELECT p.*, c.CategoryName 
                FROM tblposts p 
                LEFT JOIN tblcategory c ON p.CategoryId = c.id 
                WHERE p.Is_Active = 1 
                ORDER BY p.PostingDate DESC 
                LIMIT :limit OFFSET :offset";
        
        return $this->db->fetchAll($sql, [
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ]);
    }

    public function search($term, $limit = 8, $offset = 0) {
        $sql = "SELECT p.*, c.CategoryName 
                FROM tblposts p 
                LEFT JOIN tblcategory c ON p.CategoryId = c.id 
                WHERE p.Is_Active = 1 AND p.PostTitle LIKE :term 
                ORDER BY p.PostingDate DESC 
                LIMIT :limit OFFSET :offset";
        
        return $this->db->fetchAll($sql, [
            'term' => "%$term%",
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ]);
    }

    public function getCount($term = null) {
        if ($term) {
            $sql = "SELECT COUNT(*) as total FROM tblposts WHERE Is_Active = 1 AND PostTitle LIKE :term";
            return $this->db->fetch($sql, ['term' => "%$term%"])['total'];
        }
        return $this->db->fetch("SELECT COUNT(*) as total FROM tblposts WHERE Is_Active = 1")['total'];
    }
}
