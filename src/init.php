<?php
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
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Define configuration constants from .env (if not already defined)
if (!defined('DB_HOST')) define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', $_ENV['DB_NAME'] ?? 'njsma');
if (!defined('DB_USER')) define('DB_USER', $_ENV['DB_USER'] ?? 'root');
if (!defined('DB_PASS')) define('DB_PASS', $_ENV['DB_PASS'] ?? '');
if (!defined('SITE_NAME')) define('SITE_NAME', $_ENV['SITE_NAME'] ?? 'New Juaben South Municipal Assembly');
if (!defined('SITE_URL'))  define('SITE_URL',  $_ENV['SITE_URL']  ?? 'http://localhost/njsma');

// Secure session settings (must be set before session_start)
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load autoloader
require_once __DIR__ . '/autoloader.php';

// Initialize Database
use Core\Database;
$db = Database::getInstance();

// Load Global Settings …
