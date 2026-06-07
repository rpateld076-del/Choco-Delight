<?php
require_once 'config.php';
require_login();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: delivery.php'); exit; }

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $status = $_POST['status'];

    $mysqli->begin_transaction();
    try {
        // Update users table (common details)
        $stmt1 = $mysqli->prepare("UPDATE users SET name=?, email=?, phone=? WHERE id=? AND role='delivery'");
        $stmt1->bind_param('sssi', $name, $email, $phone, $id);
        $stmt1->execute();
        $stmt1->close();

        // Update delivery_person table (specific status)
        $stmt2 = $mysqli->prepare("UPDATE delivery_person SET name=?, email=?, phone=?, status=? WHERE id=?");
        $stmt2->bind_param('ssssi', $name, $email, $phone, $status, $id);
        $stmt2->execute();
        $stmt2->close();

        $mysqli->commit();
        $msg = "Delivery person updated successfully";
    } catch (Exception $e) {
        $mysqli->rollback();
        $err = "Update failed: " . $e->getMessage();
    }
}

// Fetch current details
$res = $mysqli->query("
    SELECT u.name, u.email, u.phone, d.status 
    FROM users u
    LEFT JOIN delivery_person d ON u.id = d.id
    WHERE u.id=$id AND u.role='delivery'
");
$delivery = $res->fetch_assoc();

if (!$delivery) { header('Location: delivery.php'); exit; }

include 'includes.php';
?>
<div class="card">
    <div class="right"><a href="delivery.php" class="btn">Back to List</a></div>
    <h2>Edit Delivery Person</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:10px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:10px;"><?php echo e($err); ?></div><?php endif; ?>

    <form method="post" style="max-width:500px">
        <input type="hidden" name="action" value="update">
        
        <div class="row">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo e($delivery['name']); ?>" required>
        </div>

        <div class="row">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo e($delivery['email']); ?>" required>
        </div>

        <div class="row">
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo e($delivery['phone']); ?>" required>
        </div>

        <div class="row">
            <label>Status</label>
            <select name="status">
                <option value="active" <?php if($delivery['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if($delivery['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn">Update Information</button>
    </form>
</div>
<?php include 'footer.php'; ?>
