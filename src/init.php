<?php
// Display errors during development (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Load configuration
require_once __DIR__ . '/../config/config.php';

// Load autoloader
require_once __DIR__ . '/autoloader.php';

// Initialize Database (optional here, but ready)
use Core\Database;
$db = Database::getInstance();
