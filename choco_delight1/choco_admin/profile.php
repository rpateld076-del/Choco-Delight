<?php
require_once 'config.php';
require_login();

$admin_id = $_SESSION['admin_id'];
$err = $msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE admins SET name=?, email=?, password=? WHERE id=?");
        $stmt->bind_param('sssi', $name, $email, $hash, $admin_id);
    } else {
        $stmt = $mysqli->prepare("UPDATE admins SET name=?, email=? WHERE id=?");
        $stmt->bind_param('ssi', $name, $email, $admin_id);
    }
    if ($stmt->execute()) {
        $msg = 'Profile updated';
        $_SESSION['admin_name'] = $name;
    } else {
        $err = 'Update failed';
    }
    $stmt->close();
}

$stmt = $mysqli->prepare("SELECT username,name,email FROM admins WHERE id=?");
$stmt->bind_param('i',$admin_id);
$stmt->execute();
$stmt->bind_result($username,$name,$email);
$stmt->fetch();
$stmt->close();

include 'includes.php';
?>
<div class="card">
  <h2>Manage Profile</h2>
  <?php if ($msg): ?><div class="small" style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div class="small" style="color:red"><?php echo e($err); ?></div><?php endif; ?>
  <form method="post">
    <div class="row">
      <label>Username (cannot change)</label>
      <input type="text" value="<?php echo e($username); ?>" disabled>
    </div>
    <div class="row">
      <label>Name</label>
      <input type="text" name="name" value="<?php echo e($name); ?>">
    </div>
    <div class="row">
      <label>Email</label>
      <input type="email" name="email" value="<?php echo e($email); ?>">
    </div>
    <div class="row">
      <label>New Password (leave blank to keep)</label>
      <input type="password" name="password">
    </div>
    <div class="row">
      <button class="btn" type="submit">Save</button>
    </div>
  </form>
</div>
<?php include 'footer.php'; ?>
