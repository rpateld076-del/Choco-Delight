<?php
require_once 'config.php';
require_login();

$msg = '';

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $order_id = intval($_POST['order_id']);
    $amount = floatval($_POST['amount']);
    $method = $_POST['method'];
    $status = $_POST['status'];
    $stmt = $mysqli->prepare("INSERT INTO payments (order_id, amount, method, status) VALUES (?,?,?,?)");
    $stmt->bind_param('idss', $order_id, $amount, $method, $status);
    if ($stmt->execute()) $msg = "Payment added"; else $err = "Add failed";
    $stmt->close();
}

if (isset($_POST['mark_paid'])) {
    $id = intval($_POST['payment_id']);
    $stmt = $mysqli->prepare("UPDATE payments SET status='paid' WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    $msg = 'Payment marked as paid';
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM payments WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close();
    header('Location: payments.php'); exit;
}

include 'includes.php';

$res = $mysqli->query("
    SELECT 
        p.*,
        o.id AS order_ref
    FROM payments p
    LEFT JOIN orders o ON p.order_id = o.id
    ORDER BY p.created_at DESC
");

$orders_res = $mysqli->query("SELECT id FROM orders ORDER BY id DESC");
$orders = [];
while($o = $orders_res->fetch_assoc()) $orders[] = $o;
?>

<div class="card">
<h2>Manage Payments</h2>

<?php if (isset($msg) && $msg): ?><div style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
<?php if (isset($err) && $err): ?><div style="color:red"><?php echo e($err); ?></div><?php endif; ?>

<div class="top-actions">
    <form method="post" style="flex:1;max-width:700px; display:flex; gap:10px; align-items:flex-end;">
        <input type="hidden" name="action" value="add">
        <div style="flex:1"><label>Order ID</label>
            <select name="order_id" required>
                <?php foreach($orders as $o): ?>
                    <option value="<?php echo $o['id']; ?>">Order #<?php echo $o['id']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="flex:1"><label>Amount</label><input type="number" step="0.01" name="amount" required></div>
        <div style="flex:1"><label>Method</label>
            <select name="method">
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
                <option value="Net Banking">Net Banking</option>
                <option value="COD">COD</option>
            </select>
        </div>
        <div style="flex:1"><label>Status</label>
            <select name="status">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
        </div>
        <button class="btn">Add</button>
    </form>
</div>

<?php if ($res->num_rows == 0): ?>
<p>No payments found</p>
<?php else: ?>

<table>
<thead>
<tr>
<th>ID</th>
<th>Order</th>
<th>Amount</th>
<th>Method</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($p = $res->fetch_assoc()): ?>
<tr>
<td><?php echo e($p['id']); ?></td>
<td>#<?php echo e($p['order_ref']); ?></td>
<td>₹<?php echo number_format($p['amount'],2); ?></td>
<td><?php echo e($p['method']); ?></td>
<td>
<span class="<?php echo $p['status']=='paid'?'paid':'pending'; ?>">
<?php echo e($p['status']); ?>
</span>
</td>
<td><?php echo e($p['created_at']); ?></td>
<td>
    <div style="display:flex; gap:5px; align-items:center;">
    <?php if ($p['status'] !== 'paid'): ?>
    <form method="post">
    <input type="hidden" name="payment_id" value="<?php echo e($p['id']); ?>">
    <button class="btn" name="mark_paid" style="padding:4px 8px; font-size:12px;">Paid</button>
    </form>
    <?php else: ?>
    <span style="color:green">✔</span>
    <?php endif; ?>
    | <a href="payments_edit.php?id=<?php echo $p['id']; ?>">Edit</a> 
    | <a href="?delete=<?php echo $p['id']; ?>" onclick="return confirmDelete()" style="color:red">Del</a>
    </div>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php endif; ?>
</div>

<?php include 'footer.php'; ?>
