<?php
require_once 'config.php';
require_login();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: gallery.php'); exit; }

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $product_id = !empty($_POST['product_id']) ? intval($_POST['product_id']) : NULL;
    $caption = trim($_POST['caption']);

    $stmt = $mysqli->prepare("UPDATE gallery SET product_id=?, caption=? WHERE id=?");
    if ($product_id === NULL) {
        $stmt->bind_param('ssi', $product_id, $caption, $id);
    } else {
        $stmt->bind_param('isi', $product_id, $caption, $id);
    }

    if ($stmt->execute()) {
        $msg = "Gallery image updated successfully";
    } else {
        $err = "Update failed: " . $mysqli->error;
    }
    $stmt->close();
}

// Fetch current details
$res = $mysqli->query("SELECT * FROM gallery WHERE id=$id");
$img = $res->fetch_assoc();

if (!$img) { header('Location: gallery.php'); exit; }

$products = $mysqli->query("SELECT id, name FROM products ORDER BY name")->fetch_all(MYSQLI_ASSOC);

include 'includes.php';
?>
<div class="card">
    <div class="right"><a href="gallery.php" class="btn">Back to Gallery</a></div>
    <h2>Edit Gallery Image</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:10px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:10px;"><?php echo e($err); ?></div><?php endif; ?>

    <div style="margin-bottom:20px;">
        <label>Current Image</label>
        <?php 
        $imgSrc = $img['filename'];
        if (!file_exists(__DIR__ . '/' . $img['filename']) && file_exists(__DIR__ . '/../' . $img['filename'])) {
            $imgSrc = '../' . $img['filename'];
        }
        ?>
        <img src="<?php echo e($imgSrc); ?>" style="max-width:300px; border-radius:8px; display:block; margin-top:5px;">
    </div>

    <form method="post" style="max-width:500px">
        <input type="hidden" name="action" value="update">
        
        <div class="row">
            <label>Attach to Product (optional)</label>
            <select name="product_id">
                <option value="">-- None --</option>
                <?php foreach ($products as $p): ?>
                    <option value="<?php echo $p['id']; ?>" <?php if($p['id'] == $img['product_id']) echo 'selected'; ?>>
                        <?php echo e($p['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label>Caption</label>
            <input type="text" name="caption" value="<?php echo e($img['caption']); ?>">
        </div>

        <button type="submit" class="btn">Update Information</button>
    </form>
</div>
<?php include 'footer.php'; ?>
