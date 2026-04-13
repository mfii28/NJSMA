<?php
/**
 * Admin Logout
 * Properly clears all session data and cookies
 */

require_once __DIR__ . '/../src/init.php';

// Clear all session variables
$_SESSION = [];

// Destroy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

// Destroy the session
session_destroy();

// Redirect to login
header('Location: login.php');
exit;
