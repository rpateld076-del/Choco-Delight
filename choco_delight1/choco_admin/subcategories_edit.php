<?php
require_once 'config.php';
require_login();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: subcategories.php'); exit; }

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $category_id = intval($_POST['category_id']);
    $name = $_POST['name'];
    $desc = $_POST['description'];

    $stmt = $mysqli->prepare("UPDATE subcategories SET category_id=?, name=?, description=? WHERE id=?");
    $stmt->bind_param('issi', $category_id, $name, $desc, $id);
    if ($stmt->execute()) {
        $msg = "Subcategory updated successfully";
    } else {
        $err = "Update failed: " . $mysqli->error;
    }
    $stmt->close();
}

$subcat = $mysqli->query("SELECT * FROM subcategories WHERE id=$id")->fetch_assoc();
if (!$subcat) { header('Location: subcategories.php'); exit; }

$cats = $mysqli->query("SELECT id, name FROM categories ORDER BY name")->fetch_all(MYSQLI_ASSOC);

include 'includes.php';
?>
<div class="card">
    <div class="right"><a href="subcategories.php" class="btn">Back to List</a></div>
    <h2>Edit Subcategory</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:10px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:10px;"><?php echo e($err); ?></div><?php endif; ?>

    <form method="post" style="max-width:500px">
        <input type="hidden" name="action" value="update">
        
        <div class="row">
            <label>Category</label>
            <select name="category_id" required>
                <?php foreach($cats as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if($c['id'] == $subcat['category_id']) echo 'selected'; ?>>
                        <?php echo e($c['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo e($subcat['name']); ?>" required>
        </div>

        <div class="row">
            <label>Description</label>
            <textarea name="description" rows="4"><?php echo e($subcat['description']); ?></textarea>
        </div>

        <button type="submit" class="btn">Update Subcategory</button>
    </form>
</div>
<?php include 'footer.php'; ?>
