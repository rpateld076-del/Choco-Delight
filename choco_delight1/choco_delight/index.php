<?php
require_once 'inc/functions.php';
include 'inc/header.php';




?>

<!-- ================= HERO VIDEO ================= -->
<section class="hero-video">
    <video autoplay muted loop playsinline>
        <source src="assets/videos/hero.mp4" type="video/mp4">
    </video>

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Choco Delight 🍫</h1>
        <p>Fresh Handmade Chocolates</p>
    </div>
</section>

<section class="after-hero-bg">
    <div class="after-hero-content">
        <h2>Welcome to Choco Delight</h2>
        <p>Fresh chocolates moments made for you.</p>
    </div>
</section>



<!-- ================= TRENDING / NEW PRODUCTS ================= -->
<?php
$trending = $conn->query("
    SELECT id, name, price, image
    FROM products
    WHERE show_on_home = 1
    ORDER BY created_at DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);

/* 🔐 store IDs to avoid duplicates */
$shown_ids = array_column($trending, 'id');
?>

<section class="auto-scroll-section">
    <h2 class="section-title">Trending Products</h2>

    <div class="auto-scroll-wrapper">
        <div class="auto-scroll-track">
			<?php foreach ($trending as $p): ?>
    <a href="product.php?id=<?php echo $p['id']; ?>" class="product-card" style="text-decoration: none; color: inherit; display: block;">
        <img src="../<?php echo esc($p['image']); ?>" alt="<?php echo esc($p['name']); ?>">
        <h4><?php echo esc($p['name']); ?></h4>
        <span>₹<?php echo number_format($p['price'],2); ?></span>
    </a>
<?php endforeach; ?>

            <?php /* 🔁 Repeat items for smooth infinite loop */ ?>
            <?php foreach ($trending as $p): ?>
                <a href="product.php?id=<?php echo $p['id']; ?>" class="product-card" style="text-decoration: none; color: inherit; display: block;">
                    <img src="../<?php echo esc($p['image']); ?>"
                         alt="<?php echo esc($p['name']); ?>"
                         style="width:100%; height:180px; object-fit:contain; background:#fff;">

                    <h4><?php echo esc($p['name']); ?></h4>
                    <span>₹<?php echo number_format($p['price'], 2); ?></span>
                </a>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- ================= BEST SELLER / ONLY NEW PRODUCTS ================= -->
<?php
$exclude_ids = !empty($shown_ids) ? implode(',', $shown_ids) : 0;

$best_products = $conn->query("
    SELECT id, name, price, image
    FROM products
    WHERE id NOT IN ($exclude_ids) AND show_on_home = 1
    ORDER BY created_at DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);
?>

<section class="best-seller-section">
    <div class="best-seller-overlay"></div>

    <div class="container">
        <h2 class="best-title">
            Best Sellers <span>🍫</span>
        </h2>
        <p class="best-subtitle">
            Most loved chocolates by our customers
        </p>

        <div class="best-grid">

            <?php foreach ($best_products as $p): ?>
                <a href="product.php?id=<?php echo $p['id']; ?>" class="best-card">

                    <div class="best-badge">NEW</div>

                    <img src="../<?php echo esc($p['image']); ?>"
                         alt="<?php echo esc($p['name']); ?>">

                    <div class="best-info">
                        <h4><?php echo esc($p['name']); ?></h4>
                        <span>₹<?php echo number_format($p['price'], 2); ?></span>
                    </div>

                </a>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php
/* ===== ONLY NEW IMAGES FROM ADMIN (LATEST PRODUCTS) ===== */

/* 🔐 add best products to shown IDs */
$best_ids = array_column($best_products, 'id');
$shown_ids = array_merge($shown_ids, $best_ids);

$exclude_ids = !empty($shown_ids) ? implode(',', array_unique($shown_ids)) : 0;

$newImages = $conn->query("
    SELECT id, name, image 
    FROM products
    WHERE id NOT IN ($exclude_ids) AND show_on_home = 1
    ORDER BY created_at DESC
    LIMIT 8
")->fetch_all(MYSQLI_ASSOC);
?>

<section class="one-line-showcase">
    <h3 class="one-line-title">Fresh From Kitchen 🍫</h3>

    <div class="one-line-row">
        <?php foreach ($newImages as $p): ?>
            <a href="product.php?id=<?php echo $p['id']; ?>" class="one-line-card">
                <img src="../<?php echo esc($p['image']); ?>" 
                     alt="<?php echo esc($p['name']); ?>">
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
