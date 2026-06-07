<?php
require_once 'inc/functions.php';
require_login();

$order_id = intval($_GET['order_id'] ?? 0);
$customer_id = $_SESSION['customer_id'];

// Check if order belongs to user
$stmt = $conn->prepare("SELECT id, created_at FROM orders WHERE id = ? AND customer_id = ?");
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$order_res = $stmt->get_result();

if ($order_res->num_rows === 0) {
    die("Order not found or access denied.");
}
$order = $order_res->fetch_assoc();

// Fetch items
$items_stmt = $conn->prepare("
    SELECT oi.product_id, p.name, p.image 
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = ?
");
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items = $items_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include 'inc/header.php';
?>

<style>
/* PREMIUM SELECTION PAGE STYLES */
body {
    background-color: #fcefe9; /* Light chocolatey tint */
}

.selection-container {
    padding: 60px 20px;
    max-width: 1000px;
    margin: 0 auto;
    font-family: 'Poppins', sans-serif;
    min-height: 80vh;
}

.page-header {
    text-align: center;
    margin-bottom: 50px;
    animation: fadeInDown 0.6s ease;
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.page-header h2 {
    font-size: 2.5rem;
    color: #5A1E2B;
    margin-bottom: 10px;
}

.page-header p {
    color: #777;
    font-size: 1.1rem;
}

.feedback-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.feedback-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(90, 30, 43, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    padding-bottom: 25px;
    animation: fadeUp 0.6s ease backwards;
}

/* Stagger animations for cards */
<?php foreach($items as $index => $item) {
    echo ".feedback-card:nth-child(".($index+1).") { animation-delay: ".($index * 0.1)."s; }";
} ?>

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.feedback-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(90, 30, 43, 0.15);
}

.img-wrapper {
    width: 100%;
    height: 200px;
    background: #f9f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 15px;
}

.feedback-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.3s;
}

.feedback-card:hover img {
    transform: scale(1.05);
}

.feedback-card h3 {
    font-size: 1.2rem;
    color: #333;
    margin: 0 15px 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rate-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 25px;
    background: #5A1E2B;
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: 0.3s;
    font-size: 0.95rem;
}

.rate-btn:hover {
    background: #722F37;
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(90, 30, 43, 0.2);
}

.rate-btn span {
    font-size: 1.2rem;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 40px;
    color: #5A1E2B;
    text-decoration: none;
    font-weight: 500;
    opacity: 0.7;
    transition: 0.3s;
}

.back-link:hover {
    opacity: 1;
    text-decoration: underline;
}
</style>

<div class="selection-container">
    
    <div class="page-header">
        <h2>Rate Your Order #<?php echo $order_id; ?></h2>
        <p>Select a product below to share your experience</p>
    </div>

    <div class="feedback-grid">
        <?php foreach ($items as $item): ?>
            <div class="feedback-card">
                <div class="img-wrapper">
                    <img src="../<?php echo esc($item['image']); ?>" alt="<?php echo esc($item['name']); ?>">
                </div>
                <h3><?php echo esc($item['name']); ?></h3>
                <a href="feedback.php?product_id=<?php echo $item['product_id']; ?>" class="rate-btn">
                    <span>⭐</span> Rate Product
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="my_orders.php" class="back-link">&larr; Back to My Orders</a>

</div>

<?php include 'inc/footer.php'; ?>
