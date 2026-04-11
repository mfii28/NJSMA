<?php
require_once __DIR__ . '/src/init.php';

$pageTitle = "Home | " . SITE_NAME;
$pageDescription = "Welcome to the official website of the New Juaben South Municipal Assembly (NJSMA), Koforidua.";

include VIEW_PATH . '/partials/header.php';

// Hero Section
include ROOT_PATH . '/inc/Hero.php';

// MCE Featured Section
include ROOT_PATH . '/inc/featured.php';

// Services/Departments Overview
include ROOT_PATH . '/inc/services.php';

// Latest News Section
include ROOT_PATH . '/inc/blog.php';

include VIEW_PATH . '/partials/footer.php';