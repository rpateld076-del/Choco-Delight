<?php
require_once 'inc/functions.php';
include 'inc/header.php';
$cats = get_categories();
?>

<style>
/* PREMIUM CATEGORIES STYLES */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

.categories-page {
    font-family: 'Poppins', sans-serif;
    padding: 60px 0;
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    min-height: 80vh;
}

.section-title {
    text-align: center;
    margin-bottom: 60px;
}

.section-title h2 {
    font-size: 3rem;
    color: #5A1E2B;
    margin-bottom: 10px;
    position: relative;
    display: inline-block;
}

.section-title h2::after {
    content: '';
    display: block;
    width: 60%;
    height: 4px;
    background: #ffd27d;
    margin: 10px auto 0;
    border-radius: 2px;
}

.section-title p {
    color: #666;
    font-size: 1.1rem;
}

.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.cat-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    min-height: 320px;
    border: 1px solid rgba(0,0,0,0.02);
}

.cat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, #5A1E2B, #ffd27d);
    opacity: 0;
    transition: 0.3s;
}

.cat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(90, 30, 43, 0.15);
}

.cat-card:hover::before {
    opacity: 1;
}

.cat-icon {
    width: 80px;
    height: 80px;
    background: #fff8e1;
    border-radius: 50%;
    margin: 0 auto 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: #5A1E2B;
    box-shadow: inset 0 0 20px rgba(255, 210, 125, 0.3);
    transition: 0.3s;
}

.cat-card:hover .cat-icon {
    background: #5A1E2B;
    color: #ffd27d;
    transform: scale(1.1) rotate(5deg);
}

.cat-name {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
}

.cat-desc {
    color: #777;
    margin-bottom: 30px;
    font-size: 0.95rem;
    line-height: 1.6;
}

.btn-explore {
    display: inline-block;
    padding: 12px 30px;
    background: transparent;
    border: 2px solid #5A1E2B;
    color: #5A1E2B;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.cat-card:hover .btn-explore {
    background: #5A1E2B;
    color: #fff;
    box-shadow: 0 5px 15px rgba(90, 30, 43, 0.3);
}

</style>

<div class="categories-page">
    <div class="section-title">
        <h2>Our Collections</h2>
        <p>Explore our premium range of chocolates & delights</p>
    </div>

    <div class="cat-grid">
        <?php foreach($cats as $c): ?>
            <div class="cat-card">
                <div>
                    <!-- Decorative Icon using First Letter -->
                    <div class="cat-icon">
                        <?php echo strtoupper(substr($c['name'], 0, 1)); ?>
                    </div>
                    
                    <h3 class="cat-name"><?php echo esc($c['name']); ?></h3>
                    
                    <p class="cat-desc">
                        Discover the finest <?php echo strtolower(esc($c['name'])); ?> crafted with passion and love.
                    </p>
                </div>

                <a href="subcategory.php?cat=<?php echo $c['id']; ?>" class="btn-explore">
                    Explore Collection <span style="font-size:1.2em;">&rarr;</span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
