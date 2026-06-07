<?php
require_once 'inc/functions.php';

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        UPDATE customers 
        SET password=?, reset_token=NULL, token_expire=NULL
        WHERE reset_token=? AND token_expire > NOW()
    ");
    $stmt->bind_param("ss", $hashed, $token);

    if ($stmt->execute() && $stmt->affected_rows) {
        echo "Password updated successfully";
        exit;
    } else {
        echo "Invalid or expired token";
        exit;
    }
}
?>

<form method="post">
    <input type="password" name="password" placeholder="New password" required>
    <button type="submit">Reset Password</button>
</form>
