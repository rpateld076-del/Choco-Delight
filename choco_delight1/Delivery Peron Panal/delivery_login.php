<?php
require_once 'config.php';

// Extra safety
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, go to dashboard
if (!empty($_SESSION['delivery_id'])) {
    header('Location: delivery_dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password';
    } else {

        $conn = getDBConnection();

        $stmt = $conn->prepare("
            SELECT id, name, email, password, status
            FROM users
            WHERE email = ?
              AND user_type = 'delivery'
            LIMIT 1
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows !== 1) {
            $error = 'Invalid email or password';
        } else {

            $user = $result->fetch_assoc();

            if ($user['status'] !== 'active') {
                $error = 'Your account is inactive. Please contact administrator.';
            } else {

                $loginOk   = false;
                $dbPass    = $user['password'];

                // Hashed password
                if (password_verify($password, $dbPass)) {
                    $loginOk = true;
                }
                // Old plain password → auto upgrade
                elseif ($password === $dbPass) {

                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $up->bind_param("si", $newHash, $user['id']);
                    $up->execute();
                    $up->close();

                    $loginOk = true;
                }

                if ($loginOk) {

                    // Regenerate session for safety
                    session_regenerate_id(true);

                    $_SESSION['delivery_id']    = $user['id'];
                    $_SESSION['delivery_name']  = $user['name'];
                    $_SESSION['delivery_email'] = $user['email'];
                    $_SESSION['user_type']      = 'delivery';

                    header('Location: delivery_dashboard.php');
                    exit();
                } else {
                    $error = 'Invalid email or password';
                }
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delivery Partner Login - ChocoDelight</title>

<style>
/* 🔒 CSS EXACT SAME — NOT TOUCHED */
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
    background:linear-gradient(135deg,#8B4513 0%,#D2691E 100%);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}
.login-container{width:100%;max-width:450px;}
.login-box{
    background:white;
    border-radius:20px;
    box-shadow:0 20px 60px rgba(0,0,0,0.3);
    padding:50px 40px;
}
.logo-section{text-align:center;margin-bottom:35px;}
.logo{font-size:70px;margin-bottom:15px;}
.logo-section h1{color:#8B4513;font-size:32px;}
.logo-section p{color:#666;}
.alert{padding:15px;border-radius:10px;margin-bottom:20px;}
.alert-error{background:#f8d7da;color:#721c24;}
.form-group{margin-bottom:25px;}
.form-group label{display:block;margin-bottom:8px;}
.form-group input{
    width:100%;
    padding:14px;
    border:2px solid #e0e0e0;
    border-radius:10px;
}
.btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#8B4513,#D2691E);
    color:white;
    font-weight:700;
    cursor:pointer;
}
.login-footer{text-align:center;margin-top:25px;}
</style>
</head>

<body>
<div class="login-container">
<div class="login-box">

<div class="logo-section">
    <div class="logo">🍫</div>
    <h1>ChocoDelight</h1>
    <p>Delivery Partner Portal</p>
</div>

<?php if ($error): ?>
<div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="POST" autocomplete="off">
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button class="btn">Login</button>
</form>

<div class="login-footer">
    <a href="index.php">← Back to Main Site</a>
</div>

</div>
</div>
</body>
</html>
