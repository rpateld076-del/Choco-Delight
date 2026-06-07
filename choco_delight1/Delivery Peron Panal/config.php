<?php
/***********************************
 * DATABASE CONFIG
 ***********************************/
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'choco_delight');

/***********************************
 * DATABASE CONNECTION
 ***********************************/
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
    return $conn;
}

/***********************************
 * SESSION START
 ***********************************/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/***********************************
 * AUTH HELPERS
 ***********************************/
function isDeliveryLoggedIn() {
    return isset($_SESSION['delivery_id']) && !empty($_SESSION['delivery_id']);
}

function requireDeliveryLogin() {
    if (!isDeliveryLoggedIn()) {
        header('Location: delivery_login.php');
        exit();
    }
}

function deliveryLogout() {
    session_unset();
    session_destroy();
    header('Location: delivery_login.php');
    exit();
}

/***********************************
 * DELIVERY PERSON INFO
 ***********************************/
function getDeliveryPersonInfo() {
    if (!isDeliveryLoggedIn()) {
        return null;
    }

    $conn = getDBConnection();
    $id = (int)$_SESSION['delivery_id'];

    $stmt = $conn->prepare("
        SELECT id, name, email, phone, status 
        FROM users 
        WHERE id = ? AND user_type = 'delivery'
        LIMIT 1
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $info = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $info;
}

/***********************************
 * HELPERS
 ***********************************/
function formatCurrency($amount) {
    return '₹' . number_format((float)$amount, 2);
}

function formatDate($date) {
    return empty($date) ? 'N/A' : date('M d, Y h:i A', strtotime($date));
}

function formatDateShort($date) {
    return empty($date) ? 'N/A' : date('M d, Y', strtotime($date));
}

function getStatusClass($status) {
    return [
        'pending' => 'warning',
        'processing' => 'info',
        'confirmed' => 'info',
        'out_for_delivery' => 'primary',
        'delivered' => 'success',
        'cancelled' => 'danger',
        'returned' => 'danger'
    ][$status] ?? 'secondary';
}

function getPaymentStatusClass($status) {
    return [
        'pending' => 'warning',
        'paid' => 'success',
        'cod' => 'info',
        'failed' => 'danger',
        'refunded' => 'secondary'
    ][$status] ?? 'secondary';
}
