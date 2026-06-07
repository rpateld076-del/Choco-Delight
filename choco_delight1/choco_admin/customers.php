<?php
require_once 'config.php';
require_login();

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO customers (name, email, password, phone) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $name, $email, $password, $phone);
    if ($stmt->execute()) $msg = "Customer added"; else $err = "Add failed";
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM customers WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close();
    header('Location: customers.php'); exit;
}

include 'includes.php';
$res = $mysqli->query("SELECT * FROM customers ORDER BY created_at DESC");
?>
<div class="card">
  <h2>Manage Customers</h2>
  <?php if ($msg): ?><div style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div style="color:red"><?php echo e($err); ?></div><?php endif; ?>

  <div class="top-actions">
    <form method="post" style="flex:1;max-width:600px">
        <input type="hidden" name="action" value="add">
        <div class="row"><label>Name</label><input type="text" name="name" required></div>
        <div class="row"><label>Email</label><input type="email" name="email" required></div>
        <div class="row"><label>Phone</label><input type="text" name="phone" required></div>
        <div class="row"><label>Password</label><input type="password" name="password" required></div>
        <button class="btn">Add Customer</button>
    </form>
  </div>

  <table>
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo e($r['id']); ?></td>
        <td><?php echo e($r['name']); ?></td>
        <td><?php echo e($r['email']); ?></td>
        <td><?php echo e($r['phone']); ?></td>
        <td><?php echo e($r['created_at']); ?></td>
        <td>
            <a href="customers_edit.php?id=<?php echo e($r['id']); ?>">Edit</a> |
            <a href="?delete=<?php echo e($r['id']); ?>" onclick="return confirmDelete()">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
