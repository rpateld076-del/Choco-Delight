<?php
require_once 'config.php';

/*
 |--------------------------------------------------
 | Proper Delivery Logout
 |--------------------------------------------------
*/

// Start session (safety)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset ONLY delivery related session variables
unset($_SESSION['delivery_id']);
unset($_SESSION['delivery_name']);
unset($_SESSION['delivery_email']);
unset($_SESSION['user_type']);

// Completely destroy the session
session_unset();
session_destroy();

// Prevent browser cache issues
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Redirect to login page
header('Location: delivery_login.php');
exit();
