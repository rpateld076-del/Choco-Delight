<?php
require_once 'inc/functions.php';
include 'inc/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm_password'] ?? '');

    if ($name === '')     $errors[] = "Name is required.";
    if ($email === '')    $errors[] = "Email is required.";
    if ($phone === '')    $errors[] = "Phone is required.";
    elseif (!preg_match('/^[0-9]{10}$/', $phone)) $errors[] = "Phone number must be exactly 10 digits.";
    if ($address === '')  $errors[] = "Address is required.";
    if ($password === '') $errors[] = "Password is required.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    // Email already exists check
    if (empty($errors)) {
        $check = $conn->prepare(
            "SELECT id FROM customers WHERE email=?"
        );
        $check->bind_param('s', $email);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            $errors[] = "Email already registered.";
        }
    }

    // Insert customer
    if (empty($errors)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO customers (name, email, password, phone, address)
             VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param(
            "sssss",
            $name,
            $email,
            $hashedPassword,
            $phone,
            $address
        );
        $stmt->execute();

        $_SESSION['customer_id']   = $stmt->insert_id;
        $_SESSION['customer_name'] = $name;

        header("Location: checkout.php");
        exit;
    }
}
?>



<!-- REGISTRATION PAGE STYLING -->
<style>
.container.user-page {
    max-width: 450px;
    margin: 50px auto;
    padding: 25px 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}

h2.register-title {
    text-align: center;
    margin-bottom: 25px;
    font-size: 1.8rem;
    color: #333;
}

form.register-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form.register-form label {
    font-weight: 500;
}

form.register-form input[type="text"],
form.register-form input[type="email"],
form.register-form input[type="password"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    width: 100%;
    box-sizing: border-box;
}

form.register-form button {
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

form.register-form button:hover {
    background: #e65c00;
}

/* Error messages */
.error-messages {
    background: #ffe5e5;
    color: #cc0000;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* Footer link */
.register-footer {
    text-align: center;
    margin-top: 15px;
    font-size: 0.9rem;
}

.register-footer a {
    color: #ff6600;
    text-decoration: none;
}

.register-footer a:hover {
    text-decoration: underline;
}
</style>

<main class="container user-page">

<h2 class="register-title">Register</h2>

<?php if (!empty($errors)): ?>
<div class="error-messages">
    <ul>
        <?php foreach ($errors as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="post" class="register-form">

    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Phone</label>
    <input type="text" name="phone" required pattern="\d{10}" minlength="10" maxlength="10" title="Please enter exactly 10 digits">

    <label>Address</label>
    <textarea name="address" required></textarea>

    <label>Password</label>
    <input type="password" name="password" required>

   
	 <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit">Register</button>
</form>


<?php include 'inc/footer.php'; ?>
