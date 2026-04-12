<?php
// Logout
require_once __DIR__ . '/../src/init.php';
session_destroy();
header('Location: login.php');
exit;
