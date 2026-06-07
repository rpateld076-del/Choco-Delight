<?php
require_once 'inc/functions.php';
include 'inc/header.php';

/* Fetch gallery images with product names */
$imgs = [];
if (isset($conn)) {
    // LEFT JOIN with products table to get the product name
    $res = $conn->query("
        SELECT g.filename, g.caption, p.name AS product_name
        FROM gallery g
        LEFT JOIN products p ON g.product_id = p.id
        ORDER BY g.id DESC
    ");
    if ($res) {
        $imgs = $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<style>
/* ===== PREMIUM GALLERY STYLE ===== */
:root {
    --choco-primary: #5d3a1a;
    --choco-accent: #d2691e;
    --choco-bg: #fffcf9;
    --glass-bg: rgba(255, 255, 255, 0.8);
}

.gallery-section {
    padding: 80px 0;
    background-color: var(--choco-bg);
}

.gallery-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 40px;
}

.gallery-header {
    text-align: center;
    margin-bottom: 60px;
}

.gallery-header h2 {
    font-size: 3.5rem;
    color: var(--choco-primary);
    font-weight: 800;
    background: linear-gradient(45deg, #5d3a1a, #bd6c2f);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.gallery-header p {
    font-size: 1.2rem;
    color: #888;
    max-width: 600px;
    margin: 0 auto;
}

.gallery-grid {
    column-count: 3;
    column-gap: 30px;
}

@media (max-width: 1100px) {
    .gallery-grid { column-count: 2; }
}
@media (max-width: 700px) {
    .gallery-grid { column-count: 1; }
}

.gallery-item {
    break-inside: avoid;
    margin-bottom: 30px;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.gallery-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(93, 58, 26, 0.15);
}

.gallery-media-wrapper {
    width: 100%;
    position: relative;
    overflow: hidden;
    background-color: #f5f5f5;
}

.gallery-media-wrapper img, 
.gallery-media-wrapper video {
    width: 100%;
    display: block;
    transition: transform 0.8s ease;
}

.gallery-item:hover .gallery-media-wrapper img,
.gallery-item:hover .gallery-media-wrapper video {
    transform: scale(1.08);
}

.video-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    font-size: 18px;
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 30px 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: #white;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s ease;
    z-index: 10;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
    transform: translateY(0);
}

.gallery-item-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: #fff;
}

.gallery-item-desc {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.8);
    font-style: italic;
}

/* Modal/Lightbox logic would go here if needed, but for now just big display */

.no-items {
    grid-column: 1 / -1;
    text-align: center;
    padding: 100px 0;
    color: #aaa;
    font-size: 1.5rem;
}
</style>

<main class="gallery-section">
    <div class="gallery-container">
        <div class="gallery-header">
            <h2>Our Chocolate Gallery</h2>
            <p>A curated collection of our finest artisanal creations, captured in their most beautiful moments.</p>
        </div>

        <?php if (empty($imgs)): ?>
            <div class="no-items">
                <p>No masterpieces to show yet. Stay tuned!</p>
            </div>
        <?php else: ?>

        <div class="gallery-grid">

        <?php foreach ($imgs as $im): ?>
            <?php
                $filename = ltrim($im['filename'], '/');
                $imgUrl   = $filename; 
                if (defined('BASE_URL')) {
                    // If path starts with uploads/, it's likely managed by admin
                    if (strpos($filename, 'uploads/') === 0) {
                        $imgUrl = BASE_URL . "choco_admin/" . $filename;
                    } elseif (strpos($filename, 'choco_admin') === 0) {
                        $imgUrl = "/" . $filename;
                    } else {
                        $imgUrl = BASE_URL . $filename;
                    }
                }
                
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $is_video = in_array($ext, ['mp4', 'webm', 'ogg']);
                
                $title = !empty($im['product_name']) ? $im['product_name'] : $im['caption'];
                if (empty($title)) {
                    $title = "Signature Delight #" . $im['id'];
                }
                $caption = (!empty($im['product_name']) && !empty($im['caption'])) ? $im['caption'] : "";
            ?>

            <div class="gallery-item">
                <?php if ($is_video): ?>
                    <div class="video-icon">🎥</div>
                <?php endif; ?>

                <div class="gallery-media-wrapper">
                    <?php if ($is_video): ?>
                        <video loop muted playsinline onmouseover="this.play()" onmouseout="this.pause()">
                            <source src="<?php echo htmlspecialchars($imgUrl); ?>" type="video/<?php echo $ext; ?>">
                            Your browser does not support videos.
                        </video>
                    <?php else: ?>
                        <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($title); ?>" loading="lazy">
                    <?php endif; ?>
                </div>

                <div class="gallery-overlay">
                    <div class="gallery-item-title"><?php echo htmlspecialchars($title); ?></div>
                    <?php if ($caption): ?>
                        <div class="gallery-item-desc"><?php echo htmlspecialchars($caption); ?></div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>

        </div>

        <?php endif; ?>
    </div>
</main>

<?php include 'inc/footer.php'; ?>
