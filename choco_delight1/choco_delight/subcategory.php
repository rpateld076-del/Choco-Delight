<?php
require_once 'inc/functions.php';

$cat_id = intval($_GET['cat'] ?? 0);
$catName = $conn->query("SELECT name FROM categories WHERE id = $cat_id")->fetch_row()[0] ?? 'Category';
$subs = get_subcategories($cat_id);

include 'inc/header.php';
?>

<style>
/* REUSED PREMIUM STYLES */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

.page-wrapper {
    font-family: 'Poppins', sans-serif;
    padding: 60px 0;
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    min-height: 80vh;
}

.page-header {
    text-align: center;
    margin-bottom: 50px;
}

.page-header h2 {
    font-size: 2.5rem;
    color: #5A1E2B;
    position: relative;
    display: inline-block;
}

.page-header h2::after {
    content: '';
    display: block;
    width: 50%;
    height: 3px;
    background: #ffd27d;
    margin: 8px auto 0;
}

.sub-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.sub-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 200px;
}

.sub-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(90, 30, 43, 0.1);
    border-color: #ffd27d;
}

.sub-title {
    font-size: 1.4rem;
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
}

.btn-view-products {
    background: #5A1E2B;
    color: #ffd27d;
    padding: 10px 25px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
    display: inline-block;
}

.btn-view-products:hover {
    background: #722F37;
    color: #fff;
    transform: scale(1.05);
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 40px;
    color: #777;
    text-decoration: none;
    font-weight: 500;
}
.back-link:hover { padding-left: 5px; color: #5A1E2B; transition:0.3s;}
</style>

<div class="page-wrapper">
    <div class="page-header">
        <h2><?php echo esc($catName); ?></h2>
        <p style="color:#777;">Select a subcategory to browse products</p>
    </div>

    <div class="sub-grid">
        <?php foreach($subs as $s): ?>
            <div class="sub-card">
                <h3 class="sub-title"><?php echo esc($s['name']); ?></h3>
                <a href="product.php?sub=<?php echo $s['id']; ?>" class="btn-view-products">
                    View Products
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="categories.php" class="back-link">&larr; Back to Categories</a>
</div>

<?php include 'inc/footer.php'; ?>
