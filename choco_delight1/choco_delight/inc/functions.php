<?php
// inc/functions.php
define('BASE_URL', '/choco_delight1/');

require_once __DIR__ . '/config.php';

function is_logged_in() {
    return !empty($_SESSION['customer_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function get_user($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, name, email, phone, address FROM customers WHERE id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function get_categories() {
    global $conn;
    $res = $conn->query("SELECT * FROM categories ORDER BY name");
    return $res->fetch_all(MYSQLI_ASSOC);
}

function get_subcategories($cat_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM subcategories WHERE category_id = ?");
    $stmt->bind_param('i',$cat_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
