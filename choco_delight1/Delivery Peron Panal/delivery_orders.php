<?php
require_once 'config.php';
requireDeliveryLogin();

$deliveryInfo = getDeliveryPersonInfo();
$conn = getDBConnection();
$deliveryId = $_SESSION['delivery_id'];

/**
 * Only allow:
 * - all
 * - delivered
 */
$allowedStatuses = ['all', 'pending', 'confirmed', 'on_way', 'delivered', 'cancelled'];
$filterStatus = $_GET['status'] ?? 'all';

if (!in_array($filterStatus, $allowedStatuses)) {
    $filterStatus = 'all';
}

$query = "
    SELECT 
        o.*,
        c.name AS customer_name,
        c.phone AS customer_phone,
        c.address
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    WHERE o.delivery_person_id = ?
";

$params = [$deliveryId];
$types  = "i";

if ($filterStatus !== 'all') {
    if ($filterStatus === 'pending') {
        $query .= " AND o.status IN ('pending', 'processing', 'confirmed')";
    } elseif ($filterStatus === 'on_way') {
        $query .= " AND o.status IN ('shipped', 'out_for_delivery')";
    } else {
        $query .= " AND o.status = ?";
        $params[] = $filterStatus;
        $types   .= "s";
    }
}

$query .= " ORDER BY o.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$orders = $stmt->get_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - ChocoDelight Delivery</title>
    <link rel="stylesheet" href="delivery_styles.css">
</head>
<body>

<?php include 'delivery_header.php'; ?>

<div class="container">
    <div class="page-header">
        <div>
            <h1>My Orders</h1>
            <p>Manage and track your delivery orders</p>
        </div>
    </div>

    <div class="filter-tabs">
        <a href="delivery_orders.php?status=all"
           class="filter-tab <?= $filterStatus === 'all' ? 'active' : ''; ?>">
            📋 All
        </a>
        <a href="delivery_orders.php?status=pending"
           class="filter-tab <?= $filterStatus === 'pending' ? 'active' : ''; ?>">
            ⏳ Pending
        </a>
        <a href="delivery_orders.php?status=on_way"
           class="filter-tab <?= $filterStatus === 'on_way' ? 'active' : ''; ?>">
            🚚 On the Way
        </a>
        <a href="delivery_orders.php?status=delivered"
           class="filter-tab <?= $filterStatus === 'delivered' ? 'active' : ''; ?>">
            ✓ Delivered
        </a>
        <a href="delivery_orders.php?status=cancelled"
           class="filter-tab <?= $filterStatus === 'cancelled' ? 'active' : ''; ?>">
            ❌ Cancelled
        </a>
    </div>

    <div class="card">
        <?php if ($orders->num_rows > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Delivery Address</th>
                            <th>Amount</th>
                            
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <strong>#<?= htmlspecialchars($order['order_number'] ?? $order['id']); ?></strong>
                            </td>
                            <td><strong><?= htmlspecialchars($order['customer_name']); ?></strong></td>
                            <td>
                                <a href="tel:<?= htmlspecialchars($order['customer_phone']); ?>">
                                    📞 <?= htmlspecialchars($order['customer_phone']); ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($order['address']); ?></td>
                            <td><strong><?= formatCurrency($order['total']); ?></strong></td>
                            
                            <td>
                                <span class="badge badge-<?= getStatusClass($order['status']); ?>">
                                    <?= ucwords(str_replace('_', ' ', $order['status'])); ?>
                                </span>
                            </td>
                            <td><?= formatDateShort($order['created_at']); ?></td>
                            <td>
                                <a href="delivery_view_order.php?id=<?= $order['id']; ?>"
                                   class="btn btn-sm btn-primary">
                                    👁️ View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>No Orders Found</h3>
                <p>
                    No orders with status:
                    <strong><?= ucwords(str_replace('_',' ',$filterStatus)); ?></strong>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="delivery_script.js"></script>
</body>
</html>
