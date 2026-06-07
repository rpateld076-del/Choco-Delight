<?php
require_once 'inc/functions.php';
require_login();

$customer_id = $_SESSION['customer_id'];

// Fetch orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

include 'inc/header.php';
?>

<div class="container" style="padding: 60px 20px;">
    <h2 class="section-title">My <span>Orders</span></h2>

    <?php if (empty($orders)): ?>
        <p style="text-align:center;">You have placed no orders yet.</p>
    <?php else: ?>
        <div class="orders-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?php echo $o['id']; ?></td>
                            <td><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></td>
                            <td>₹ <?php echo number_format($o['total'], 2); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($o['status']); ?>">
                                    <?php echo esc($o['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="invoice.php?id=<?php echo $o['id']; ?>" class="view-btn">View Invoice</a>
                                <a href="select_feedback_product.php?order_id=<?php echo $o['id']; ?>" class="view-btn" style="background-color: #f0ad4e;">Feedback</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
.orders-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-radius: 12px;
    overflow: hidden;
}

.orders-table th, .orders-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.orders-table th {
    background-color: #f8f8f8;
    color: #3b1f1f;
    font-weight: 600;
}

.status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    display: inline-block;
}

.status-pending { background: #fff3cd; color: #856404; }
.status-processing { background: #cce5ff; color: #004085; }
.status-shipped { background: #d6d8d9; color: #383d41; }
.status-out_for_delivery { background: #d1ecf1; color: #0c5460; }
.status-delivered { background: #d4edda; color: #155724; }
.status-cancelled { background: #f8d7da; color: #721c24; }

.view-btn {
    display: inline-block;
    padding: 6px 12px;
    background: #b84d4d;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.3s;
}

.view-btn:hover {
    background: #3b1f1f;
}

@media (max-width: 600px) {
    .orders-table {
        display: block;
        overflow-x: auto;
    }
}
</style>

<?php include 'inc/footer.php'; ?>
