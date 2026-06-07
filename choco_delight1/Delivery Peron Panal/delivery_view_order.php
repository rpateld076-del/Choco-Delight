<?php
require_once 'config.php';
requireDeliveryLogin();

$orderId    = intval($_GET['id'] ?? 0);
$deliveryId = $_SESSION['delivery_id'];
$conn       = getDBConnection();

$updateError = '';

/* ================= HANDLE POST ================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['new_status'])) {

        $newStatus = $_POST['new_status'];
        $allowed = [
            'pending','processing','confirmed',
            'shipped','out_for_delivery',
            'delivered','cancelled'
        ];

        if (!in_array($newStatus, $allowed)) {
            $updateError = "Invalid status selected.";
        } else {
            $stmt = $conn->prepare(
                "UPDATE orders 
                 SET status=? 
                 WHERE id=? AND delivery_person_id=?"
            );
            $stmt->bind_param("sii", $newStatus, $orderId, $deliveryId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: delivery_view_order.php?id=$orderId&success=status");
                exit;
            } else {
                $updateError = "Status already updated.";
            }
            $stmt->close();
        }
    }

    if (isset($_POST['collect_payment'])) {
        $stmt = $conn->prepare(
            "UPDATE orders 
             SET payment_status='paid' 
             WHERE id=? AND delivery_person_id=?"
        );
        $stmt->bind_param("ii", $orderId, $deliveryId);
        $stmt->execute();
        $stmt->close();

        header("Location: delivery_view_order.php?id=$orderId&success=payment");
        exit;
    }
}

/* ================= FETCH ORDER ================= */

$stmt = $conn->prepare("
    SELECT o.*, c.name AS customer_name, c.phone
    FROM orders o
    LEFT JOIN customers c ON o.customer_id=c.id
    WHERE o.id=? AND o.delivery_person_id=?
");
$stmt->bind_param("ii", $orderId, $deliveryId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    header("Location: delivery_orders.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order #<?= $orderId ?></title>

<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:#f6f7fb;
}
.order-wrapper{
    max-width:520px;
    margin:50px auto;
}
.order-card{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
}
.order-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}
.order-header h2{margin:0;}
.status-badge{
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
    background:#ffe7c2;
    color:#b45309;
}
.alert{
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}
.alert-success{background:#d1fae5;color:#065f46}
.alert-danger{background:#fee2e2;color:#991b1b}

.status-box{
    display:flex;
    gap:10px;
    margin-bottom:15px;
}
.status-box select{
    flex:1;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
}
.btn-main{
    background:#8b4513;
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
}
.btn-main:hover{background:#6f350f}

.btn-action{
    display:block;
    width:100%;
    margin-top:12px;
    text-align:center;
    padding:12px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}
.btn-invoice{
    background:linear-gradient(135deg,#ff8c42,#ff6a00);
    color:#fff;
}
.btn-payment{
    background:#16a34a;
    color:#fff;
}
</style>
</head>

<body>

<div class="order-wrapper">
<div class="order-card">

    <div class="order-header">
        <h2>Order #<?= $orderId ?></h2>
        <div class="status-badge">
            <?= strtoupper(str_replace('_',' ',$order['status'])) ?>
        </div>
    </div>

    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">
            <?= $_GET['success']=='payment'
                ? 'Payment Collected Successfully'
                : 'Status Updated Successfully'; ?>
        </div>
    <?php endif; ?>

    <?php if ($updateError): ?>
        <div class="alert alert-danger"><?= $updateError ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="status-box">
            <select name="new_status">
                <?php
                $statuses = ['out_for_delivery','delivered'];
                foreach ($statuses as $s):
                ?>
                <option value="<?= $s ?>" <?= $order['status']==$s?'selected':'' ?>>
                    <?= ucwords(str_replace('_',' ',$s)) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button class="btn-main">Update</button>
        </div>
    </form>

    <?php if ($order['status']=='delivered' && $order['status']=='cod'): ?>
        <form method="POST">
            <button name="collect_payment" class="btn-action btn-payment">
                💰 Collect Payment
            </button>
        </form>
    <?php endif; ?>

    <a href="delivery_invoice.php?id=<?= $orderId ?>"
       target="_blank"
       class="btn-action btn-invoice">
       📄 View Invoice
    </a>

</div>
</div>

</body>
</html>
