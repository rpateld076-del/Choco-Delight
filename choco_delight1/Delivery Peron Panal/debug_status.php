<?php
require_once 'config.php';
requireDeliveryLogin();

$orderId = $_GET['id'] ?? 0;
$deliveryId = $_SESSION['delivery_id'];

echo "<h2>Debug Information</h2>";
echo "<p>Order ID: $orderId</p>";
echo "<p>Delivery Person ID: $deliveryId</p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>POST Data Received:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    if (isset($_POST['update_status'])) {
        $newStatus = $_POST['new_status'];
        echo "<p>New Status: $newStatus</p>";
        
        $allowed = ['pending', 'processing', 'shipped', 'out_for_delivery', 'delivered', 'cancelled'];
        echo "<p>Status allowed: " . (in_array($newStatus, $allowed) ? 'YES' : 'NO') . "</p>";
        
        if (in_array($newStatus, $allowed)) {
            $conn = getDBConnection();
            $updateQuery = "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ? AND delivery_person_id = ?";
            
            echo "<p>Query: $updateQuery</p>";
            
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sii", $newStatus, $orderId, $deliveryId);
            
            if ($stmt->execute()) {
                $affected = $stmt->affected_rows;
                echo "<p style='color:green;'>SUCCESS! Affected rows: $affected</p>";
                
                if ($affected == 0) {
                    echo "<p style='color:orange;'>WARNING: No rows were updated. Check if order ID $orderId belongs to delivery person $deliveryId</p>";
                }
            } else {
                echo "<p style='color:red;'>ERROR: " . $stmt->error . "</p>";
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>

<form method="POST">
    <select name="new_status">
        <option value="pending">Pending</option>
        <option value="processing">Processing</option>
        <option value="shipped">Shipped</option>
        <option value="out_for_delivery">Out for Delivery</option>
        <option value="delivered">Delivered</option>
        <option value="cancelled">Cancelled</option>
    </select>
    <button type="submit" name="update_status">Test Update</button>
</form>

<p><a href="delivery_view_order.php?id=<?= $orderId ?>">Back to Order</a></p>
