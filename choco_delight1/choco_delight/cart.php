<?php
require_once 'inc/functions.php';
include 'inc/header.php';

$cart = $_SESSION['cart'] ?? [];

/* UPDATE CART */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['qty'] as $pid => $q) {
        $pid = intval($pid);
        $q   = max(0, intval($q));

        if ($q === 0) {
            unset($_SESSION['cart'][$pid]);
        } else {
            $_SESSION['cart'][$pid]['qty'] = $q;
        }
    }
    header("Location: cart.php");
    exit;
}

$total = 0;
?>

<!-- CART PAGE STYLING -->
<style>
/* Container */
.container.user-page {
    max-width: 900px;
    margin: 20px auto;
    padding: 0 15px;
    font-family: Arial, sans-serif;
}

/* Title */
.cart-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.8rem;
}

/* Empty cart message */
.empty-cart {
    text-align: center;
    font-size: 1.2rem;
    color: #555;
}

/* Cart box */
.cart-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

/* Cart row */
.cart-row {
    display: grid;
    grid-template-columns: 3fr 1fr 1fr 1fr; /* Product | Price | Qty | Subtotal */
    align-items: center;
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
}

.cart-row:last-child {
    border-bottom: none;
}

/* Header row */
.cart-head {
    background: #f7f7f7;
    font-weight: bold;
}

/* Product name */
.cart-row div:first-child {
    font-weight: 500;
}

/* Input field */
.cart-row input[type="number"] {
    width: 60px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    text-align: center;
}

/* Total */
.cart-total {
    text-align: right;
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 15px;
}

/* Buttons */
.cart-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-outline {
    padding: 8px 15px;
    border: 1px solid #ff6600;
    background: #fff;
    color: #ff6600;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
}

.btn-outline:hover {
    background: #ff6600;
    color: #fff;
}

.btn-primary {
    padding: 8px 15px;
    border: none;
    background: #ff6600;
    color: #fff;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
}

.btn-primary:hover {
    background: #e65c00;
}
</style>

<main class="container user-page">

<h2 class="cart-title">Your Cart</h2>

<?php if (empty($cart)): ?>

    <p class="empty-cart">Your cart is empty</p>

<?php else: ?>

<form method="post">

<div class="cart-box">

    <!-- HEADER -->
    <div class="cart-row cart-head">
        <div>Product</div>
        <div>Price</div>
        <div>Qty</div>
        <div>Subtotal</div>
    </div>

    <!-- ITEMS -->
    <?php foreach ($cart as $item): 
        $sub = $item['price'] * $item['qty'];
        $total += $sub;
    ?>
    <div class="cart-row">
        <div><?php echo esc($item['name']); ?></div>
        <div>₹<?php echo number_format($item['price'], 2); ?></div>
        <div>
            <input type="number"
                   name="qty[<?php echo $item['id']; ?>]"
                   value="<?php echo $item['qty']; ?>"
                   min="0">
        </div>
        <div>₹<?php echo number_format($sub, 2); ?></div>
    </div>
    <?php endforeach; ?>

</div>

<!-- TOTAL -->
<div class="cart-total">
    Total: ₹<?php echo number_format($total, 2); ?>
</div>

<!-- BUTTONS -->
<div class="cart-actions">
    <button type="submit" name="update" class="btn-outline">
        Update Cart
    </button>
    <a href="checkout.php" class="btn-primary">
        Proceed to Checkout
    </a>
</div>

</form>

<?php endif; ?>

</main>

<?php include 'inc/footer.php'; ?>
