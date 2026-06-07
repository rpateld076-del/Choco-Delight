<?php
require_once 'config.php';
require_login();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: customers.php'); exit; }

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $stmt = $mysqli->prepare("UPDATE customers SET name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param('sssi', $name, $email, $phone, $id);
    if ($stmt->execute()) {
        $msg = "Customer updated successfully";
    } else {
        $err = "Update failed: " . $mysqli->error;
    }
    $stmt->close();
}

$cust = $mysqli->query("SELECT * FROM customers WHERE id=$id")->fetch_assoc();
if (!$cust) { header('Location: customers.php'); exit; }

include 'includes.php';
?>
<div class="card">
    <div class="right"><a href="customers.php" class="btn">Back to List</a></div>
    <h2>Edit Customer</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:10px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:10px;"><?php echo e($err); ?></div><?php endif; ?>

    <form method="post" style="max-width:500px">
        <input type="hidden" name="action" value="update">
        
        <div class="row">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo e($cust['name']); ?>" required>
        </div>

        <div class="row">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo e($cust['email']); ?>" required>
        </div>

        <div class="row">
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo e($cust['phone']); ?>" required>
        </div>

        <button type="submit" class="btn">Update Customer</button>
    </form>
</div>
<?php include 'footer.php'; ?>
