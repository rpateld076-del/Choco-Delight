<?php
require_once 'config.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    // Show simple search interface
    include 'includes.php';
    $ords = $mysqli->query("SELECT id, created_at, total FROM orders ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="card">
      <h2>Generate Invoice</h2>
      <table>
        <thead><tr><th>Order ID</th><th>Date</th><th>Total</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach($ords as $o): ?>
          <tr>
            <td><?php echo e($o['id']); ?></td>
            <td><?php echo e($o['created_at']); ?></td>
            <td>₹ <?php echo e($o['total']); ?></td>
            <td><a href="invoice.php?id=<?php echo e($o['id']); ?>" target="_blank">Open Invoice</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
    include 'footer.php';
    exit;
}

// Build invoice view
$stmt = $mysqli->prepare("SELECT o.*, c.name as customer_name, c.email, c.phone, c.address FROM orders o LEFT JOIN customers c ON o.customer_id=c.id WHERE o.id=?");
$stmt->bind_param('i',$id); $stmt->execute(); $inv = $stmt->get_result()->fetch_assoc(); $stmt->close();
if (!$inv) { header('Location: invoice.php'); exit; }
$items = $mysqli->query("SELECT oi.*, p.name FROM order_items oi LEFT JOIN products p ON oi.product_id=p.id WHERE oi.order_id={$id}");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Invoice #<?php echo e($id); ?></title>
  <style>
    body{font-family:Arial;padding:18px}
    .invoice{max-width:800px;margin:0 auto;background:#fff;padding:18px;border-radius:6px}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #eee;padding:8px}
    h2{margin-top:0}
  </style>
</head><body>
  <div class="invoice">
    <h2>Choco Delight</h2>
    <p>Invoice #: <?php echo e($inv['id']); ?> | Date: <?php echo e($inv['created_at']); ?></p>
    <p><strong>Customer:</strong> <?php echo e($inv['customer_name']); ?> <br>
       <?php echo e($inv['email']); ?> | <?php echo e($inv['phone']); ?><br>
       <?php echo e($inv['address']); ?></p>
    <table>
      <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
      <tbody>
        <?php while($it=$items->fetch_assoc()): ?>
          <tr>
            <td><?php echo e($it['name']); ?></td>
            <td><?php echo e($it['qty']); ?></td>
            <td>₹ <?php echo e($it['price']); ?></td>
            <td>₹ <?php echo e(number_format($it['price']*$it['qty'],2)); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <p style="text-align:right;font-size:18px"><strong>Total: ₹ <?php echo e($inv['total']); ?></strong></p>
    <p><a href="#" onclick="window.print()">Print Invoice</a></p>
  </div>
</body></html>
