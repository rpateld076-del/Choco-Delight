<?php
require_once 'config.php';
require_login();

$msg = '';
$err = '';

// ================= UPLOAD IMAGE =================
if (isset($_POST['action']) && $_POST['action'] === 'upload') {

    // NULL SAFE product_id
    $product_id = !empty($_POST['product_id']) ? intval($_POST['product_id']) : NULL;
    $caption = trim($_POST['caption'] ?? '');

    if (!empty($_FILES['image']['name'])) {

        $upDir = __DIR__ . '/uploads/gallery/';
        if (!is_dir($upDir)) {
            mkdir($upDir, 0755, true);
        }

        $allowed = ['jpg','jpeg','png','webp', 'mp4', 'webm', 'ogg'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $err = 'Invalid file type. Only JPG, PNG, WEBP, MP4, WEBM, OGG allowed.';
        } else {

            $newName = uniqid('g_') . '.' . $ext;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upDir . $newName)) {

                $filename = 'uploads/gallery/' . $newName;

                $stmt = $mysqli->prepare(
                    "INSERT INTO gallery (product_id, filename, caption) VALUES (?, ?, ?)"
                );

                if ($product_id === NULL || $product_id === 0) {
                    $pid_null = NULL;
                    $stmt->bind_param('iss', $pid_null, $filename, $caption);
                } else {
                    $stmt->bind_param('iss', $product_id, $filename, $caption);
                }

                if ($stmt->execute()) {
                    $msg = 'File uploaded successfully';
                } else {
                    $err = 'Database insert failed';
                }

                $stmt->close();

            } else {
                $err = 'Image upload failed';
            }
        }
    } else {
        $err = 'Please select an image';
    }
}

// ================= DELETE IMAGE =================
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $img = $mysqli->query(
        "SELECT filename FROM gallery WHERE id = {$id}"
    )->fetch_assoc();

    if ($img && file_exists(__DIR__ . '/' . $img['filename'])) {
        unlink(__DIR__ . '/' . $img['filename']);
    }

    $stmt = $mysqli->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    header("Location: gallery.php");
    exit;
}

// ================= DATA =================
$products = $mysqli->query(
    "SELECT id, name FROM products ORDER BY name"
)->fetch_all(MYSQLI_ASSOC);

$res = $mysqli->query("
    SELECT g.*, p.name AS pname 
    FROM gallery g 
    LEFT JOIN products p ON g.product_id = p.id 
    ORDER BY g.id DESC
");

include 'includes.php';
?>

<div class="card">
    <h2>📷 Manage Gallery</h2>

    <?php if ($msg): ?><div class="alert success"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?php echo e($err); ?></div><?php endif; ?>

    <!-- UPLOAD FORM -->
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload">

        <div class="row">
            <label>Attach to Product (optional)</label>
            <select name="product_id">
                <option value="">-- None --</option>
                <?php foreach ($products as $p): ?>
                    <option value="<?php echo e($p['id']); ?>">
                        <?php echo e($p['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label>Image or Video</label>
            <input type="file" name="image" accept="image/*,video/*" required>
        </div>

        <div class="row">
            <label>Name / Caption (Required)</label>
            <input type="text" name="caption" placeholder="Enter a unique name for this item" required>
        </div>

        <button class="btn" type="submit">Upload Image</button>
    </form>

    <!-- GALLERY TABLE -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Preview</th>
                <th>Product</th>
                <th>Caption</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($r = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo e($r['id']); ?></td>
                <td>
                    <?php 
                    $imgSrc = $r['filename'];
                    if (!file_exists(__DIR__ . '/' . $r['filename']) && file_exists(__DIR__ . '/../' . $r['filename'])) {
                        $imgSrc = '../' . $r['filename'];
                    }
                    ?>
                    <?php if ($r['filename']): ?>
                        <?php 
                        $is_video = in_array(strtolower(pathinfo($r['filename'], PATHINFO_EXTENSION)), ['mp4', 'webm', 'ogg']);
                        ?>
                        <?php if ($is_video): ?>
                            <div style="width:60px; height:60px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; border-radius:4px; font-size:24px;">🎥</div>
                        <?php else: ?>
                            <img src="<?php echo e($imgSrc); ?>" height="60" style="object-fit:cover; border-radius:4px;">
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td><?php echo e($r['pname'] ?? '—'); ?></td>
                <td><?php echo e($r['caption']); ?></td>
                <td>
                    <a href="gallery_edit.php?id=<?php echo e($r['id']); ?>">Edit</a> |
                    <a href="?delete=<?php echo e($r['id']); ?>"
                       onclick="return confirm('Delete this image?')"
                       class="del">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
