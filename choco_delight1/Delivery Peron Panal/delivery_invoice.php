<?php
require_once 'config.php';
requireDeliveryLogin();

$orderId    = intval($_GET['id'] ?? 0);
$deliveryId = $_SESSION['delivery_id'];
$conn       = getDBConnection();

/* ================= FETCH ORDER ================= */

$stmt = $conn->prepare("
    SELECT 
        o.id,
        o.status,
        c.name AS customer_name,
        c.phone,
        c.address
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    WHERE o.id = ? AND o.delivery_person_id = ?
");
$stmt->bind_param("ii", $orderId, $deliveryId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo '<h3 style="text-align:center;color:red">Invoice not available</h3>';
    exit;
}

$order = $res->fetch_assoc();
$stmt->close();

/* ================= FETCH ORDER ITEMS ================= */

$stmt = $conn->prepare("
    SELECT 
        oi.qty,
        oi.price,
        p.name AS product_name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$items = $stmt->get_result();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Invoice #<?= $orderId ?></title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
}
.invoice-box{
    max-width:800px;
    margin:30px auto;
    background:#fff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}
h2{margin-bottom:5px}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
th,td{
    border:1px solid #ccc;
    padding:8px;
}
th{background:#f0f0f0}
.total{
    text-align:right;
    font-size:18px;
    margin-top:15px;
}
.badge{
    display:inline-block;
    padding:4px 10px;
    background:#333;
    color:#fff;
    border-radius:4px;
    font-size:12px;
}
</style>
</head>

<body>

<div class="invoice-box">

<h2>🧾 Choco Delight – Invoice</h2>

<p><b>Order ID:</b> <?= $orderId ?></p>
<p><b>Status:</b> <span class="badge"><?= strtoupper($order['status']) ?></span></p>

<hr>

<h4>Customer Details</h4>
<p>
<?= htmlspecialchars($order['customer_name']) ?><br>
<?= htmlspecialchars($order['phone']) ?><br>
<?= nl2br(htmlspecialchars($order['address'])) ?>
</p>

<hr>

<table>
<tr>
    <th>#</th>
    <th>Product</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Total</th>
</tr>

<?php
$i = 1;
$grandTotal = 0;

while ($row = $items->fetch_assoc()):
    $lineTotal = $row['qty'] * $row['price'];
    $grandTotal += $lineTotal;
?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($row['product_name']) ?></td>
    <td><?= $row['qty'] ?></td>
    <td>₹<?= number_format($row['price'], 2) ?></td>
    <td>₹<?= number_format($lineTotal, 2) ?></td>
</tr>
<?php endwhile; ?>
</table>

<div class="total">
    <strong>Grand Total: ₹<?= number_format($grandTotal, 2) ?></strong>
</div>

</div>

</body>
</html>
