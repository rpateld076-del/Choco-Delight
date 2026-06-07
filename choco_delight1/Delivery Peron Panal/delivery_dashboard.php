<?php
require_once 'config.php';
requireDeliveryLogin();

$deliveryInfo = getDeliveryPersonInfo();
$conn = getDBConnection();
$deliveryId = $_SESSION['delivery_id'];

/* ================= DASHBOARD STATS ================= */
$statsQuery = "
    SELECT 
        COUNT(*) AS total_orders,

        SUM(
            CASE 
                WHEN status IN ('pending','processing','confirmed')
                THEN 1 ELSE 0 
            END
        ) AS pending_delivery,

        SUM(
            CASE 
                WHEN status IN ('shipped','out_for_delivery')
                THEN 1 ELSE 0 
            END
        ) AS out_for_delivery,

        SUM(
            CASE 
                WHEN status = 'delivered'
                THEN 1 ELSE 0 
            END
        ) AS delivered,

        SUM(
            CASE 
                WHEN status = 'cancelled'
                THEN 1 ELSE 0 
            END
        ) AS cancelled,

        SUM(
            CASE 
                WHEN status = 'delivered'
                AND DATE(created_at) = CURDATE()
                THEN total
                ELSE 0
            END
        ) AS today_earnings

    FROM orders
    WHERE delivery_person_id = ?
";

$stmt = $conn->prepare($statsQuery);
$stmt->bind_param("i", $deliveryId);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
$stmt->close();

/* ================= RECENT ORDERS ================= */
$ordersQuery = "
    SELECT 
        o.id,
        o.status,
        o.total,
        o.created_at,
        c.name AS customer_name,
        c.phone AS customer_phone,
        c.address
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    WHERE o.delivery_person_id = ?
    ORDER BY o.created_at DESC
    LIMIT 6
";

$stmt = $conn->prepare($ordersQuery);
$stmt->bind_param("i", $deliveryId);
$stmt->execute();
$recentOrders = $stmt->get_result();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - ChocoDelight Delivery</title>
<link rel="stylesheet" href="delivery_styles.css">
</head>
<body>

<?php include 'delivery_header.php'; ?>

<div class="container">

<div class="page-header">
    <div>
        <h1>Welcome Back, <?php echo htmlspecialchars($deliveryInfo['name']); ?> 👋</h1>
        <p>Here's your delivery overview for today</p>
    </div>
    <span class="date-badge">📅 <?php echo date('l, M d, Y'); ?></span>
</div>

<!-- ===== STATS ===== -->
<div class="stats-grid">

    <div class="stat-card stat-primary">
        <div class="stat-icon">📦</div>
        <div class="stat-content">
            <h3><?php echo $stats['total_orders'] ?? 0; ?></h3>
            <p>Total Orders</p>
        </div>
    </div>

    <div class="stat-card stat-warning">
        <div class="stat-icon">⏳</div>
        <div class="stat-content">
            <h3><?php echo $stats['pending_delivery'] ?? 0; ?></h3>
            <p>Pending</p>
        </div>
    </div>

    <div class="stat-card stat-info">
        <div class="stat-icon">🚚</div>
        <div class="stat-content">
            <h3><?php echo $stats['out_for_delivery'] ?? 0; ?></h3>
            <p>Out for Delivery</p>
        </div>
    </div>

    <div class="stat-card stat-success">
        <div class="stat-icon">💰</div>
        <div class="stat-content">
            <h3><?php echo formatCurrency($stats['today_earnings'] ?? 0); ?></h3>
            <p>Today's Collection</p>
        </div>
    </div>

    <div class="stat-card" style="border-left: 5px solid #dc3545; background: #fff5f5;">
        <div class="stat-icon" style="background:#dc3545; color:white;">❌</div>
        <div class="stat-content">
            <h3><?php echo $stats['cancelled'] ?? 0; ?></h3>
            <p>Cancelled</p>
        </div>
    </div>

</div>

<!-- ===== CONTENT ===== -->
<div class="content-grid">

<div class="main-content">
<div class="card">
<div class="card-header">
    <h2>Recent Orders</h2>
    <a href="delivery_orders.php" class="btn btn-sm btn-primary">View All</a>
</div>

<?php if ($recentOrders->num_rows > 0): ?>
<?php while ($order = $recentOrders->fetch_assoc()): ?>
<div class="order-item">

    <div class="order-header">
        <div>
            <strong>#<?php echo $order['id']; ?></strong>
            <span class="badge badge-<?php echo getStatusClass($order['status']); ?>">
                <?php echo strtoupper($order['status']); ?>
            </span>
        </div>
        <div class="order-amount">
            <?php echo formatCurrency($order['total']); ?>
        </div>
    </div>

    <div class="order-details">
        <p>👤 <?php echo htmlspecialchars($order['customer_name']); ?></p>
        <p>📞 <?php echo htmlspecialchars($order['customer_phone']); ?></p>
        <p>📍 <?php echo htmlspecialchars($order['address']); ?></p>
    </div>

    <div class="order-actions">
        <a href="delivery_view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">View</a>

        <?php if ($order['status'] === 'shipped'): ?>
            <a href="delivery_mark_delivered.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-success">
                Mark Delivered
            </a>
        <?php endif; ?>
    </div>

</div>
<?php endwhile; ?>
<?php else: ?>
<p class="empty">No orders assigned yet.</p>
<?php endif; ?>

</div>
</div>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">

<div class="card">
<h3>Quick Actions</h3>

<div class="action-btn">⏳ Pending <span><?php echo $stats['pending_delivery']; ?></span></div>
<div class="action-btn">🚚 Out <span><?php echo $stats['out_for_delivery']; ?></span></div>
<div class="action-btn">✓ Delivered <span><?php echo $stats['delivered']; ?></span></div>
<div class="action-btn">📦 All <span><?php echo $stats['total_orders']; ?></span></div>

</div>

<div class="card">
<h3>Profile</h3>
<p><?php echo htmlspecialchars($deliveryInfo['email']); ?></p>
<p>📞 <?php echo htmlspecialchars($deliveryInfo['phone']); ?></p>
</div>

</div>

</div>
</div>

</body>
</html>
