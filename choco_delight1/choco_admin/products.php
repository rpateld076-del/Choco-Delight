<?php
require_once 'config.php';
require_login();

$msg = '';
$err = '';

/* =======================
   ADD PRODUCT
======================= */
if (isset($_POST['action']) && $_POST['action'] === 'add') {

    $name  = trim($_POST['name']);
    $desc  = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id    = intval($_POST['category_id']);
    $subcategory_id = !empty($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : NULL;
    $image = NULL;

    /* IMAGE UPLOAD */
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','webp','gif'];
        $upDir = dirname(__DIR__) . '/uploads/';

        if (!is_dir($upDir)) mkdir($upDir, 0755, true);

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $err = "Only image files allowed";
        } else {
            $new = uniqid('p_') . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upDir.$new)) {
                $image = 'uploads/'.$new;
            } else {
                $err = "Image upload failed";
            }
        }
    }

    if (!$err) {
        $show_on_home = isset($_POST['show_on_home']) ? 1 : 0;

        $stmt = $mysqli->prepare("
            INSERT INTO products 
            (category_id, subcategory_id, name, description, price, stock, image, show_on_home)
            VALUES (?,?,?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "iissdisi",
            $category_id,
            $subcategory_id,
            $name,
            $desc,
            $price,
            $stock,
            $image,
            $show_on_home
        );

        if ($stmt->execute()) $msg = "Product added successfully";
        else $err = "Product add failed";

        $stmt->close();
    }
}

/* =======================
   DELETE PRODUCT
======================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $img = $mysqli->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
    if ($img && $img['image'] && file_exists(dirname(__DIR__).'/'.$img['image'])) {
        unlink(dirname(__DIR__).'/'.$img['image']);
    }

    $stmt = $mysqli->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();

    header("Location: products.php");
    exit;
}

/* =======================
   LOAD DATA
======================= */
include 'includes.php';

$cats = $mysqli->query("SELECT id,name FROM categories ORDER BY name")->fetch_all(MYSQLI_ASSOC);

$res = $mysqli->query("
    SELECT 
        p.*,
        c.name AS catname,
        s.name AS subname
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN subcategories s ON p.subcategory_id = s.id
    ORDER BY p.id DESC
");
?>

<div class="card">
<h2>Manage Products</h2>

<?php if ($msg): ?><div style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
<?php if ($err): ?><div style="color:red"><?php echo e($err); ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data" style="max-width:700px">
<input type="hidden" name="action" value="add">

<label>Category</label>
<select name="category_id" id="category_select" required>
<?php foreach($cats as $c): ?>
<option value="<?php echo e($c['id']); ?>"><?php echo e($c['name']); ?></option>
<?php endforeach; ?>
</select>

<label>Subcategory</label>
<select name="subcategory_id" id="subcat_select">
<option value="">-- none --</option>
</select>

<label>Name</label>
<input type="text" name="name" required>

<label>Description</label>
<textarea name="description"></textarea>

<label>Price</label>
<input type="number" step="0.01" name="price" required>

<label>Stock</label>
<input type="number" name="stock" value="0">

<label>Image</label>
<input type="file" name="image" accept="image/*">

<label style="display:flex; align-items:center; gap:10px; margin: 15px 0; cursor:pointer;">
    <input type="checkbox" name="show_on_home" value="1" style="width:auto; margin:0;">
    Show on Home Page
</label>

<button class="btn">Add Product</button>
</form>

<hr>

<table>
<thead>
<tr>
<th>ID</th><th>Image</th><th>Name</th>
<th>Category / Subcategory</th>
<th>Price</th><th>Stock</th><th>Home?</th><th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $res->fetch_assoc()): ?>
<tr>
<td><?php echo e($row['id']); ?></td>
<td>
<img src="../<?php echo $row['image'] ?: 'uploads/default.png'; ?>" height="50">
</td>
<td><?php echo e($row['name']); ?></td>
<td>
<?php echo e($row['catname']); ?> /
<?php echo e($row['subname'] ?? '—'); ?>
</td>
<td>₹<?php echo number_format($row['price'],2); ?></td>
<td><?php echo e($row['stock']); ?></td>
<td><?php echo $row['show_on_home'] ? '✅' : '❌'; ?></td>
<td>
<a href="products_edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
<a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<script>
document.getElementById('category_select').addEventListener('change', function(){
    fetch('ajax_get_subcategories.php?cat='+this.value)
    .then(res=>res.json())
    .then(data=>{
        let s = document.getElementById('subcat_select');
        s.innerHTML = '<option value="">-- none --</option>';
        data.forEach(r=>{
            let o = document.createElement('option');
            o.value = r.id;
            o.textContent = r.name;
            s.appendChild(o);
        });
    });
});
document.getElementById('category_select').dispatchEvent(new Event('change'));
</script>

<?php include 'footer.php'; ?>
