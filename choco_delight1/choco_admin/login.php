<?php
session_start();  
require_once 'config.php';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    $stmt = $mysqli->prepare("SELECT id, password, name FROM admins WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash, $name);

    if ($stmt->fetch()) {

        // CASE 1: password is hashed
        if (password_verify($password, $hash)) {
            
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_name'] = $name;

            header("Location: index.php");
            exit();

        }
        // CASE 2: password is plain text
        else if ($password === $hash) {

            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_name'] = $name;

            header("Location: index.php");
            exit();

        }
        else {
            $err = "Invalid credentials";
        }

    } else {
        $err = "Invalid credentials";
    }

    $stmt->close();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Choco Delight Admin</title>
  <style>
    body{font-family:Arial;background:#f7f3f0;display:flex;align-items:center;justify-content:center;height:100vh;margin:0}
    .box{background:#fff;padding:24px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.08);width:360px}
    input{width:100%;padding:10px;margin:6px 0;border:1px solid #ddd;border-radius:4px}
    .btn{padding:10px 14px;background:#6d4c41;color:#fff;border:none;border-radius:6px;cursor:pointer;width:100%}
    .err{color:#c62828;margin:8px 0}
  </style>
</head>
<body>
  <div class="box">
    <h2>Admin Login</h2>
    <?php if ($err): ?><div class="err"><?= $err ?></div><?php endif; ?>
    <form method="post">
      <label>Username</label>
      <input type="text" name="username" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <button class="btn" type="submit">Login</button>
    </form>
  </div>
</body>
</html>
