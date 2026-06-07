<?php
// inc/config.php

// ✅ SESSION START (SAFE WAY)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ DATABASE DETAILS
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "choco_delight";

// ✅ DATABASE CONNECTION
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// ✅ CONNECTION CHECK
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ✅ SET CHARSET (IMPORTANT FOR LOGIN)
$conn->set_charset("utf8mb4");

// ✅ ESCAPE FUNCTION
function esc($value) {
    if ($value === null) {
        return '';
    }
    return htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
}
