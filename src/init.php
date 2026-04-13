<?php
// Secure session settings (MUST be before any session_start or output)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_secure', 0);  // Set to 1 in production with HTTPS
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Production error handling
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../logs/error.log');
error_reporting(E_ALL);

// Define path constants
define('ROOT_PATH', dirname(__DIR__));
define('VIEW_PATH', ROOT_PATH . '/views');
define('SRC_PATH', ROOT_PATH . '/src');

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} catch (Exception $e) {
    error_log('Dotenv loading failed: ' . $e->getMessage());
}

// Define configuration constants from .env (if not already defined)
if (!defined('DB_HOST')) define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', $_ENV['DB_NAME'] ?? 'njsma');
if (!defined('DB_USER')) define('DB_USER', $_ENV['DB_USER'] ?? 'root');
if (!defined('DB_PASS')) define('DB_PASS', $_ENV['DB_PASS'] ?? '');
if (!defined('SITE_NAME')) define('SITE_NAME', $_ENV['SITE_NAME'] ?? 'New Juaben South Municipal Assembly');
if (!defined('SITE_URL'))  define('SITE_URL',  $_ENV['SITE_URL']  ?? 'http://localhost/njsma');

// Load autoloader
require_once __DIR__ . '/autoloader.php';

// Initialize Database
use Core\Database;
$db = Database::getInstance();

// Load Global Settings …
