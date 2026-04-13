<?php
namespace Models;
use Core\Database;

class HeroSlide {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tblhero_slides ORDER BY display_order ASC, id ASC");
    }

    public function getActive() {
        return $this->db->fetchAll("SELECT * FROM tblhero_slides WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM tblhero_slides WHERE id = :id", ['id' => $id]);
    }

    public function create($data) {
        $sql = "INSERT INTO tblhero_slides (title, description, image, badge, badge_class, button_1_text, button_1_link, button_2_text, button_2_link, is_active, display_order) 
                VALUES (:title, :description, :image, :badge, :badge_class, :button_1_text, :button_1_link, :button_2_text, :button_2_link, :is_active, :display_order)";
        return $this->db->execute($sql, [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? 'slider-1.jpg',
            'badge' => $data['badge'] ?? '',
            'badge_class' => $data['badge_class'] ?? 'bg-primary',
            'button_1_text' => $data['button_1_text'] ?? '',
            'button_1_link' => $data['button_1_link'] ?? '',
            'button_2_text' => $data['button_2_text'] ?? '',
            'button_2_link' => $data['button_2_link'] ?? '',
            'is_active' => $data['is_active'] ?? 1,
            'display_order' => $data['display_order'] ?? 0
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE tblhero_slides SET 
                title = :title, description = :description, image = :image, badge = :badge,
                badge_class = :badge_class, button_1_text = :button_1_text, button_1_link = :button_1_link,
                button_2_text = :button_2_text, button_2_link = :button_2_link, is_active = :is_active,
                display_order = :display_order WHERE id = :id";
        return $this->db->execute($sql, [
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? 'slider-1.jpg',
            'badge' => $data['badge'] ?? '',
            'badge_class' => $data['badge_class'] ?? 'bg-primary',
            'button_1_text' => $data['button_1_text'] ?? '',
            'button_1_link' => $data['button_1_link'] ?? '',
            'button_2_text' => $data['button_2_text'] ?? '',
            'button_2_link' => $data['button_2_link'] ?? '',
            'is_active' => $data['is_active'] ?? 1,
            'display_order' => $data['display_order'] ?? 0
        ]);
    }

    public function delete($id) {
        return $this->db->execute("DELETE FROM tblhero_slides WHERE id = :id", ['id' => $id]);
    }
}
