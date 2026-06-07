<?php
require_once 'config.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: products.php');
    exit;
}

$msg = '';
$err = '';

/* =======================
   UPDATE PRODUCT
======================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $desc  = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id    = intval($_POST['category_id']);
    $subcategory_id = !empty($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : NULL;
    $show_on_home   = isset($_POST['show_on_home']) ? 1 : 0;

    /* IMAGE UPLOAD */
    $image_part = "";
    $image_new = NULL;

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','webp','gif'];
        $upDir = dirname(__DIR__) . '/uploads/';

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $err = "Only image files allowed";
        } else {
            $new = uniqid('p_') . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upDir.$new)) {
                $image_new = 'uploads/'.$new;
                $image_part = ", image = '$image_new'";
                
                // Delete old image
                $old = $mysqli->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
                if ($old && $old['image'] && file_exists(dirname(__DIR__).'/'.$old['image'])) {
                    unlink(dirname(__DIR__).'/'.$old['image']);
                }
            } else {
                $err = "Image upload failed";
            }
        }
    }

    if (!$err) {
        $stmt = $mysqli->prepare("
            UPDATE products 
            SET category_id=?, subcategory_id=?, name=?, description=?, price=?, stock=?, show_on_home=? $image_part
            WHERE id=?
        ");
        $stmt->bind_param(
            "iissdiii",
            $category_id,
            $subcategory_id,
            $name,
            $desc,
            $price,
            $stock,
            $show_on_home,
            $id
        );

        if ($stmt->execute()) {
            $msg = "Product updated successfully";
        } else {
            $err = "Update failed: " . $mysqli->error;
        }
        $stmt->close();
    }
}

/* =======================
   LOAD CURRENT DATA
======================= */
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: products.php');
    exit;
}

$cats = $mysqli->query("SELECT id,name FROM categories ORDER BY name")->fetch_all(MYSQLI_ASSOC);

include 'includes.php';
?>

<div class="card">
    <h2>Edit Product</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:15px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:15px;"><?php echo e($err); ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data" style="max-width:700px">
        
        <label>Category</label>
        <select name="category_id" id="category_select" required>
            <?php foreach($cats as $c): ?>
            <option value="<?php echo e($c['id']); ?>" <?php echo $product['category_id'] == $c['id'] ? 'selected' : ''; ?>>
                <?php echo e($c['name']); ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Subcategory</label>
        <select name="subcategory_id" id="subcat_select">
            <option value="">-- none --</option>
        </select>

        <label>Name</label>
        <input type="text" name="name" value="<?php echo e($product['name']); ?>" required>

        <label>Description</label>
        <textarea name="description" rows="5"><?php echo e($product['description']); ?></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?php echo e($product['price']); ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?php echo e($product['stock']); ?>">

        <label>Current Image</label><br>
        <img src="../<?php echo $product['image'] ?: 'uploads/default.png'; ?>" height="100" style="margin: 10px 0; border-radius:8px; border: 1px solid #ddd;">
        
        <label>Change Image (Optional)</label>
        <input type="file" name="image" accept="image/*">

        <label style="display:flex; align-items:center; gap:10px; margin: 20px 0; cursor:pointer; font-weight:600;">
            <input type="checkbox" name="show_on_home" value="1" <?php echo $product['show_on_home'] ? 'checked' : ''; ?> style="width:auto; margin:0;">
            Show on Home Page
        </label>

        <div style="display:flex; gap:15px; align-items:center;">
            <button class="btn">Update Product</button>
            <a href="products.php" style="color:#666; text-decoration:none;">Back to list</a>
        </div>
    </form>
</div>

<script>
document.getElementById('category_select').addEventListener('change', function(){
    let selectedSub = <?php echo json_encode($product['subcategory_id']); ?>;
    fetch('ajax_get_subcategories.php?cat='+this.value)
    .then(res=>res.json())
    .then(data=>{
        let s = document.getElementById('subcat_select');
        s.innerHTML = '<option value="">-- none --</option>';
        data.forEach(r=>{
            let o = document.createElement('option');
            o.value = r.id;
            o.textContent = r.name;
            if(r.id == selectedSub) o.selected = true;
            s.appendChild(o);
        });
    });
});
document.getElementById('category_select').dispatchEvent(new Event('change'));
</script>

<?php include 'footer.php'; ?>
