<?php
require_once 'config.php';
require_login();

$msg=''; 
$err='';

/* ===== UPDATE ORDER STATUS & DELIVERY PERSON ===== */

if (isset($_POST['update_status'])) {

    $id     = intval($_POST['order_id']);
    $status = $_POST['status'];
   if (!empty($_POST['delivery_person_id'])) {
    $dp_id = intval($_POST['delivery_person_id']);

    // ✅ Check if delivery person exists in delivery_person table
    $check = $mysqli->prepare("SELECT id FROM delivery_person WHERE id=?");
    $check->bind_param('i', $dp_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Valid delivery person, update order
        $stmt = $mysqli->prepare("UPDATE orders SET status=?, delivery_person_id=? WHERE id=?");
        $stmt->bind_param('sii', $status, $dp_id, $id);
    } else {
        // Invalid ID, set to NULL
        $stmt = $mysqli->prepare("UPDATE orders SET status=?, delivery_person_id=NULL WHERE id=?");
        $stmt->bind_param('si', $status, $id);
    }
    $check->close();
} else {
    // No delivery person selected, set to NULL
    $stmt = $mysqli->prepare("UPDATE orders SET status=?, delivery_person_id=NULL WHERE id=?");
    $stmt->bind_param('si', $status, $id);
}

if ($stmt->execute()) {
    $msg = 'Order updated successfully';
} else {
    $err = 'Update failed: ' . $mysqli->error;
}
$stmt->close();
 
    
}

include 'includes.php';

/* ===== FETCH ORDERS ===== */
$res = $mysqli->query("
   SELECT o.*, 
       c.name AS customer_name,
       u.name AS delivery_name
   FROM orders o
   LEFT JOIN customers c ON o.customer_id = c.id
   LEFT JOIN users u ON o.delivery_person_id = u.id
   ORDER BY o.created_at DESC
");

/* ===== FETCH DELIVERY PERSONS (FROM USERS) ===== */
$dp_res = $mysqli->query("
    SELECT id, name 
    FROM delivery_person 
    WHERE status='active'
");


$deliveryPersons = [];
while($dp = $dp_res->fetch_assoc()){
    $deliveryPersons[] = $dp;
}
?>

<div class="card">
  <h2>Manage Orders</h2>

  <?php if ($msg): ?><div style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div style="color:red"><?php echo e($err); ?></div><?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Delivery Person</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php while($o = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo e($o['id']); ?></td>
        <td><?php echo e($o['customer_name']); ?></td>
        <td>₹ <?php echo e($o['total']); ?></td>
        <td><?php echo e($o['status']); ?></td>
<td><?php echo $o['delivery_name'] ?: 'Not Assigned'; ?></td>

        <td><?php echo e($o['created_at']); ?></td>
        <td>

          <form method="post">
            <input type="hidden" name="order_id" value="<?php echo e($o['id']); ?>">

            <select name="status">
              <?php foreach(['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                <option value="<?php echo $s; ?>" <?php if($s==$o['status']) echo 'selected'; ?>>
                  <?php echo ucfirst($s); ?>
                </option>
              <?php endforeach; ?>
            </select>
             
<select name="delivery_person_id">
  <option value="">-- Assign Delivery --</option>
  <?php foreach($deliveryPersons as $dp): ?>
    <option value="<?php echo $dp['id']; ?>" 
      <?php if($dp['id']==$o['delivery_person_id']) echo 'selected'; ?>>
      <?php echo e($dp['name']); ?>
    </option>
  <?php endforeach; ?>
</select>


           

            <button class="btn" name="update_status">Update</button>
            | <a href="?delete=<?php echo $o['id']; ?>" onclick="return confirmDelete()" style="color:red">Delete</a>
          </form>

        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
