<?php
require_once 'inc/functions.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM customers WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->get_result()->num_rows) {
        $token = bin2hex(random_bytes(32));

        $conn->query("
            UPDATE customers 
            SET reset_token='$token', token_expire=DATE_ADD(NOW(), INTERVAL 1 HOUR)
            WHERE email='$email'
        ");

        $resetLink = "http://localhost/choco_delight1/choco_delight/reset_password.php?token=$token";

        $msg = "Reset link: <a href='$resetLink'>Click here</a>";
    } else {
        $msg = "Email not found";
    }
}
?>

<form method="post">
    <input type="email" name="email" placeholder="Enter email" required>
    <button type="submit">Send Reset Link</button>
</form>

<?php echo $msg; ?>
