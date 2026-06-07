<?php
require_once 'inc/functions.php';
include 'inc/header.php';
?>
<label>Payment Method</label>
<select name="payment_method" required>
    <option value="COD">Cash On Delivery</option>
    <option value="UPI">UPI</option>
    <option value="Card">Card</option>
</select>

<?php include 'inc/footer.php'; ?>
