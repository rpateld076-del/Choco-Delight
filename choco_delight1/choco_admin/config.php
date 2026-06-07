<?php
// config.php

// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // set your DB password
define('DB_NAME', 'choco_delight');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die("DB Connect failed: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

// Simple function to escape output
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

// Require login for protected pages
function require_login() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Create default admin if none exists (convenience)
function ensure_default_admin($mysqli) {
    $res = $mysqli->query("SELECT id FROM admins LIMIT 1");
    if (!$res || $res->num_rows == 0) {
        $pass = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO admins (username,password,name,email) VALUES (?,?,?,?)");
        $user = 'admin';
        $name = 'Choco Admin';
        $email = 'admin@choco.local';
        $stmt->bind_param('ssss', $user, $pass, $name, $email);
        $stmt->execute();
        $stmt->close();
    }
}
ensure_default_admin($mysqli);
?>
