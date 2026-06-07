<?php
require_once 'inc/functions.php';

$id  = intval($_GET['id'] ?? 0);
$sub = intval($_GET['sub'] ?? 0);

/* =========================
   SINGLE PRODUCT / LIST FETCH
========================= */
if ($id) {
    $stmt = $conn->prepare("
        SELECT p.*, s.name AS subname 
        FROM products p 
        LEFT JOIN subcategories s ON p.subcategory_id = s.id 
        WHERE p.id = ?
    ");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $p = $stmt->get_result()->fetch_assoc();

} elseif ($sub) {
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE subcategory_id = ?
        ORDER BY id DESC
    ");
    $stmt->bind_param('i', $sub);
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

include 'inc/header.php';

// Handle Not Found
if ($id && !$p) {
    echo "<div style='text-align:center; padding:50px;'><h2>Product not found</h2><a href='categories.php'>Back to Shop</a></div>";
    include 'inc/footer.php';
    exit;
}

/* =========================
   ADD TO CART LOGIC
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $pid = intval($_POST['product_id']);
    $qty = max(1, intval($_POST['qty']));

    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->bind_param('i', $pid);
    $stmt->execute();
    $pr = $stmt->get_result()->fetch_assoc();

    if ($pr) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$pid] = [
                'id'    => $pr['id'],
                'name'  => $pr['name'],
                'price' => $pr['price'],
                'image' => $pr['image'],
                'qty'   => $qty
            ];
        }
        header('Location: cart.php');
        exit;
    }
}
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

.product-page {
    font-family: 'Poppins', sans-serif;
    padding: 60px 0;
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    min-height: 80vh;
}

/* LIST VIEW STYLES */
.prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.prod-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: 0.3s;
    text-align: center;
}

.prod-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.prod-img {
    width: 100%;
    height: 220px;
    object-fit: contain;
    background: #fff;
}

.prod-info {
    padding: 20px;
}

.prod-title {
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 8px;
    font-weight: 600;
}

.prod-price {
    color: #5A1E2B;
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.btn-view {
    display: inline-block;
    padding: 8px 20px;
    border: 1px solid #5A1E2B;
    color: #5A1E2B;
    border-radius: 20px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 0.9rem;
}

.btn-view:hover {
    background: #5A1E2B;
    color: #fff;
}

/* SINGLE PRODUCT VIEW STYLES */
.single-prod-container {
    max-width: 1000px;
    margin: 0 auto;
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
}

/* Responsive Single View */
@media(max-width:768px){
    .single-prod-container{ grid-template-columns: 1fr; }
}

.sp-img img {
    width: 100%;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.sp-details h2 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.2;
}

.sp-price {
    font-size: 2rem;
    color: #5A1E2B;
    font-weight: 700;
    margin-bottom: 20px;
    display: block;
}

.sp-desc {
    color: #666;
    line-height: 1.8;
    margin-bottom: 30px;
}

.cart-form {
    display: flex;
    gap: 15px;
    align-items: center;
}

.qty-input {
    width: 70px;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1.1rem;
    text-align: center;
}

.btn-add-cart {
    background: #5A1E2B;
    color: #fff;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(90, 30, 43, 0.3);
}

.btn-add-cart:hover {
    background: #722F37;
    transform: translateY(-2px);
}

.btn-feedback {
    display: inline-block;
    background: #ffd27d;
    color: #5A1E2B;
    padding: 10px 20px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 20px;
}
</style>

<div class="product-page">
    <?php if (isset($p)): 
        // Logic for feedback check
        $can_feedback = false;
        if (is_logged_in()) {
            $cid = $_SESSION['customer_id'];
            $chk = $conn->prepare("SELECT oi.id FROM order_items oi JOIN orders o ON o.id = oi.order_id WHERE o.customer_id = ? AND oi.product_id = ? LIMIT 1");
            $chk->bind_param("ii", $cid, $p['id']);
            $chk->execute();
            $chk->store_result();
            if ($chk->num_rows > 0) $can_feedback = true;
        }
    ?>
    
    <!-- SINGLE PRODUCT LAYOUT -->
    <div class="single-prod-container">
        <div class="sp-img">
            <img src="../<?php echo esc($p['image']); ?>" alt="<?php echo esc($p['name']); ?>">
        </div>
        <div class="sp-details">
            <h2><?php echo esc($p['name']); ?></h2>
            <span class="sp-price">₹<?php echo number_format($p['price'], 2); ?></span>
            <div class="sp-desc">
                <?php echo nl2br(esc($p['description'])); ?>
            </div>

            <form method="post" class="cart-form">
                <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                <input type="number" name="qty" value="1" min="1" class="qty-input">
                <button type="submit" name="add_to_cart" class="btn-add-cart">Add to Cart</button>
            </form>

            <?php if ($can_feedback): ?>
                <a href="feedback.php?product_id=<?php echo $p['id']; ?>" class="btn-feedback">
                    ⭐ Give Feedback
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php else: ?>

    <!-- PRODUCT LIST GRID -->
    <h2 style="text-align:center; color:#5A1E2B; margin-bottom:40px; font-size:2.2rem;">Our Products</h2>
    <div class="prod-grid">
        <?php foreach ($products as $pr): ?>
            <div class="prod-card">
                <img src="../<?php echo esc($pr['image']); ?>" class="prod-img" alt="">
                <div class="prod-info">
                    <h4 class="prod-title"><?php echo esc($pr['name']); ?></h4>
                    <div class="prod-price">₹<?php echo number_format($pr['price'],2); ?></div>
                    <a href="product.php?id=<?php echo $pr['id']; ?>" class="btn-view">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div style="text-align:center; margin-top:40px;">
        <a href="categories.php" style="color:#777; text-decoration:none;">&larr; Back to Categories</a>
    </div>

    <?php endif; ?>
</div>

<?php include 'inc/footer.php'; ?>
