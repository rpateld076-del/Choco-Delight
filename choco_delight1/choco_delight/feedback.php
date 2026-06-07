<?php
require_once 'inc/functions.php';
require_login();

$product_id = intval($_GET['product_id'] ?? 0);
$customer_id = $_SESSION['customer_id'];

// ✅ check product purchased or not AND fetch product details
$chk = $conn->prepare("
    SELECT oi.id, p.name, p.image
    FROM order_items oi
    JOIN orders o ON o.id = oi.order_id
    JOIN products p ON p.id = oi.product_id
    WHERE o.customer_id = ? AND oi.product_id = ?
    LIMIT 1
");
$chk->bind_param("ii", $customer_id, $product_id);
$chk->execute();
$res = $chk->get_result();

if ($res->num_rows === 0) {
    die("❌ You can give feedback only after purchasing this product.");
}

$product = $res->fetch_assoc();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = esc($_POST['name']);
    $email   = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = esc($_POST['message']);
    $rating  = intval($_POST['rating']);

    $stmt = $conn->prepare("
        INSERT INTO feedback (product_id, customer_name, email, message, rating)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssi", $product_id, $name, $email, $message, $rating);

    if ($stmt->execute()) {
        $msg = "✅ Thank you for your feedback!";
    } else {
        $msg = "❌ Failed to submit feedback";
    }
}

include 'inc/header.php';
?>

<style>
/* PREMIUM FEEDBACK PAGE STYLES */
body {
    background-color: #fcefe9; /* Light chocolatey tint */
}

.feedback-wrapper {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    font-family: 'Poppins', sans-serif;
}

.feedback-card {
    background: #fff;
    max-width: 500px;
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(90, 30, 43, 0.1);
    overflow: hidden;
    position: relative;
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.product-header {
    background: linear-gradient(135deg, #5A1E2B 0%, #3b0f18 100%);
    padding: 30px;
    text-align: center;
    color: #fff;
    position: relative;
}

.product-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    margin-bottom: 15px;
    animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes popIn {
    from { transform: scale(0); }
    to { transform: scale(1); }
}

.product-header h2 {
    font-size: 22px;
    margin: 0;
    font-weight: 600;
}

.product-header p {
    font-size: 14px;
    opacity: 0.8;
    margin-top: 5px;
}

.feedback-form {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 8px;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #eee;
    border-radius: 10px;
    font-size: 14px;
    transition: 0.3s;
    outline: none;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #5A1E2B;
    background: #fffcf5;
}

/* Star Rating */
.star-rating-wrapper {
    text-align: center;
    margin-bottom: 25px;
}

.star-rating {
    display: inline-flex;
    justify-content: center;
    gap: 10px;
    flex-direction: row-reverse; /* For CSS hover magic */
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 35px;
    color: #ddd;
    cursor: pointer;
    transition: 0.2s;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
    transform: scale(1.1);
}

/* Button */
.btn-submit {
    width: 100%;
    background: #5A1E2B;
    color: #fff;
    border: none;
    padding: 15px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(90, 30, 43, 0.2);
}

.btn-submit:hover {
    background: #722F37;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(90, 30, 43, 0.3);
}

/* Success Message */
.success-msg {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
}

.error-msg {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}
</style>

<div class="feedback-wrapper">
    <div class="feedback-card">
        
        <div class="product-header">
            <img src="../<?php echo esc($product['image']); ?>" alt="<?php echo esc($product['name']); ?>" class="product-img">
            <h2><?php echo esc($product['name']); ?></h2>
            <p>Tell us what you think!</p>
        </div>

        <div class="feedback-form">
            <?php if ($msg): ?>
                <div class="<?php echo strpos($msg, '✅') !== false ? 'success-msg' : 'error-msg'; ?>">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                
                <div class="star-rating-wrapper">
                    <div class="star-rating">
                        <!-- Reverse order for CSS implementation -->
                        <input type="radio" id="s5" name="rating" value="5" required><label for="s5">★</label>
                        <input type="radio" id="s4" name="rating" value="4"><label for="s4">★</label>
                        <input type="radio" id="s3" name="rating" value="3"><label for="s3">★</label>
                        <input type="radio" id="s2" name="rating" value="2"><label for="s2">★</label>
                        <input type="radio" id="s1" name="rating" value="1"><label for="s1">★</label>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" value="<?php echo isset($_SESSION['customer_name']) ? esc($_SESSION['customer_name']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                </div>

                <div class="form-group">
                    <textarea name="message" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
                </div>

                <button type="submit" class="btn-submit">Submit Review</button>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
