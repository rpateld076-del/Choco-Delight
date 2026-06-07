<?php
require_once 'inc/functions.php';
include 'inc/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email) $errors[] = "Email is required.";
    if (!$password) $errors[] = "Password is required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, name, password FROM customers WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['id'];
            $_SESSION['customer_name'] = $user['name'];
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<!-- LOGIN PAGE STYLING -->
<style>
.container.user-page {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px 25px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}

h2.login-title {
    text-align: center;
    margin-bottom: 25px;
    font-size: 1.8rem;
    color: #333;
}

form.login-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form.login-form label {
    font-weight: 500;
}

form.login-form input[type="email"],
form.login-form input[type="password"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    width: 100%;
    box-sizing: border-box;
}

form.login-form button {
    padding: 10px;
    background: #ff6600;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

form.login-form button:hover {
    background: #e65c00;
}

.error-messages {
    background: #ffe5e5;
    color: #cc0000;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.login-footer {
    text-align: center;
    margin-top: 15px;
    font-size: 0.9rem;
}

.login-footer a {
    color: #ff6600;
    text-decoration: none;
}

.login-footer a:hover {
    text-decoration: underline;
}
</style>

<main class="container user-page">

<h2 class="login-title">Login</h2>

<?php if (!empty($errors)): ?>
<div class="error-messages">
    <ul>
        <?php foreach ($errors as $err): ?>
            <li><?php echo esc($err); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="post" class="login-form">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?php echo esc($_POST['email'] ?? ''); ?>">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>

    <button type="submit">Login</button>
</form>
<a href="forgot_password.php">Forgot Password?</a>

<div class="login-footer">
    Don't have an account? <a href="register.php">Register here</a>
</div>

</main>

<?php include 'inc/footer.php'; ?>
