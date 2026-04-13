<?php

namespace Models;

use Core\Database;

class Admin {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get all admin users
     */
    public function getAll() {
        return $this->db->fetchAll("SELECT id, username, email, full_name, is_active, created_at, last_login FROM admin_users ORDER BY created_at DESC");
    }
    
    /**
     * Get admin by ID
     */
    public function getById($id) {
        return $this->db->fetch("SELECT id, username, email, full_name, is_active, created_at, last_login FROM admin_users WHERE id = :id", ['id' => $id]);
    }
    
    /**
     * Get admin by username
     */
    public function getByUsername($username) {
        return $this->db->fetch("SELECT * FROM admin_users WHERE username = :username", ['username' => $username]);
    }
    
    /**
     * Get admin by email
     */
    public function getByEmail($email) {
        return $this->db->fetch("SELECT * FROM admin_users WHERE email = :email", ['email' => $email]);
    }
    
    /**
     * Verify admin credentials
     */
    public function verify($username, $password) {
        $admin = $this->getByUsername($username);
        if (!$admin || !$admin['is_active']) {
            return false;
        }
        
        if (password_verify($password, $admin['password_hash'])) {
            // Update last login
            $this->updateLastLogin($admin['id']);
            return $admin;
        }
        
        return false;
    }
    
    /**
     * Create new admin
     */
    public function create($data) {
        // Check if username or email already exists
        if ($this->getByUsername($data['username'])) {
            throw new \Exception("Username already exists");
        }
        
        if ($this->getByEmail($data['email'])) {
            throw new \Exception("Email already exists");
        }
        
        $sql = "INSERT INTO admin_users (username, email, password_hash, full_name, is_active, created_at) 
                VALUES (:username, :email, :password_hash, :full_name, :is_active, NOW())";
        
        $params = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'full_name' => $data['full_name'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Update admin
     */
    public function update($id, $data) {
        $allowedFields = ['username', 'email', 'full_name', 'is_active'];
        $updates = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[$key] = $value;
            }
        }
        
        // Handle password update separately
        if (!empty($data['password'])) {
            $updates[] = "password_hash = :password_hash";
            $params['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $sql = "UPDATE admin_users SET " . implode(', ', $updates) . " WHERE id = :id";
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Delete admin
     */
    public function delete($id) {
        // Don't allow deleting the last admin
        $count = $this->db->fetchOne("SELECT COUNT(*) as count FROM admin_users");
        if ($count['count'] <= 1) {
            throw new \Exception("Cannot delete the last admin user");
        }
        
        return $this->db->execute("DELETE FROM admin_users WHERE id = :id", ['id' => $id]);
    }
    
    /**
     * Update last login timestamp
     */
    private function updateLastLogin($id) {
        return $this->db->execute(
            "UPDATE admin_users SET last_login = NOW() WHERE id = :id",
            ['id' => $id]
        );
    }
    
    /**
     * Count total admins
     */
    public function count() {
        $result = $this->db->fetch("SELECT COUNT(*) as count FROM admin_users");
        return $result['count'] ?? 0;
    }
    
    /**
     * Check if any admin exists
     */
    public function adminExists() {
        return $this->count() > 0;
    }
    
    /**
     * Create password reset token
     */
    public function createPasswordResetToken($email) {
        $admin = $this->getByEmail($email);
        if (!$admin) {
            return false;
        }
        
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->db->execute(
            "UPDATE admin_users SET reset_token = :token, reset_expires = :expires WHERE id = :id",
            ['token' => $token, 'expires' => $expires, 'id' => $admin['id']]
        );
        
        return $token;
    }
    
    /**
     * Verify reset token
     */
    public function verifyResetToken($token) {
        return $this->db->fetch(
            "SELECT id FROM admin_users WHERE reset_token = :token AND reset_expires > NOW()",
            ['token' => $token]
        );
    }
    
    /**
     * Reset password with token
     */
    public function resetPassword($token, $newPassword) {
        $admin = $this->verifyResetToken($token);
        if (!$admin) {
            return false;
        }
        
        $this->db->execute(
            "UPDATE admin_users SET password_hash = :hash, reset_token = NULL, reset_expires = NULL WHERE id = :id",
            ['hash' => password_hash($newPassword, PASSWORD_DEFAULT), 'id' => $admin['id']]
        );
        
        return true;
    }
}
