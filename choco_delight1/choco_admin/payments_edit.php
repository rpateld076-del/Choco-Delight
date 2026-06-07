<?php
require_once 'config.php';
require_login();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: payments.php'); exit; }

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $order_id = intval($_POST['order_id']);
    $amount = floatval($_POST['amount']);
    $method = $_POST['method'];
    $status = $_POST['status'];

    $stmt = $mysqli->prepare("UPDATE payments SET order_id=?, amount=?, method=?, status=? WHERE id=?");
    $stmt->bind_param('idssi', $order_id, $amount, $method, $status, $id);
    if ($stmt->execute()) {
        $msg = "Payment updated successfully";
    } else {
        $err = "Update failed: " . $mysqli->error;
    }
    $stmt->close();
}

$payment = $mysqli->query("SELECT * FROM payments WHERE id=$id")->fetch_assoc();
if (!$payment) { header('Location: payments.php'); exit; }

$orders = $mysqli->query("SELECT id FROM orders ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);

include 'includes.php';
?>
<div class="card">
    <div class="right"><a href="payments.php" class="btn">Back to List</a></div>
    <h2>Edit Payment</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:10px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:10px;"><?php echo e($err); ?></div><?php endif; ?>

    <form method="post" style="max-width:500px">
        <input type="hidden" name="action" value="update">
        
        <div class="row">
            <label>Order ID</label>
            <select name="order_id" required>
                <?php foreach($orders as $o): ?>
                    <option value="<?php echo $o['id']; ?>" <?php if($o['id'] == $payment['order_id']) echo 'selected'; ?>>Order #<?php echo $o['id']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" value="<?php echo e($payment['amount']); ?>" required>
        </div>

        <div class="row">
            <label>Method</label>
            <select name="method">
                <?php foreach(['UPI','Card','Net Banking','COD'] as $m): ?>
                    <option value="<?php echo $m; ?>" <?php if($m == $payment['method']) echo 'selected'; ?>><?php echo $m; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label>Status</label>
            <select name="status">
                <option value="pending" <?php if($payment['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="paid" <?php if($payment['status'] == 'paid') echo 'selected'; ?>>Paid</option>
                <option value="failed" <?php if($payment['status'] == 'failed') echo 'selected'; ?>>Failed</option>
            </select>
        </div>

        <button type="submit" class="btn">Update Payment</button>
    </form>
</div>
<?php include 'footer.php'; ?>
