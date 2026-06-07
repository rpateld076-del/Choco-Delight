<?php
require_once 'config.php';
require_login();
$msg=''; $err='';

if (isset($_POST['action']) && $_POST['action']=='add') {
    $category_id = intval($_POST['category_id']);
    $name = $_POST['name']; $desc = $_POST['description'];
    $stmt = $mysqli->prepare("INSERT INTO subcategories (category_id,name,description) VALUES (?,?,?)");
    $stmt->bind_param('iss',$category_id,$name,$desc);
    if ($stmt->execute()) $msg='Added';
    else $err='Add failed';
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM subcategories WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    header('Location: subcategories.php'); exit;
}

include 'includes.php';
$cats = $mysqli->query("SELECT id,name FROM categories")->fetch_all(MYSQLI_ASSOC);
$res = $mysqli->query("SELECT s.*, c.name as catname FROM subcategories s LEFT JOIN categories c ON s.category_id=c.id ORDER BY s.created_at DESC");
?>
<div class="card">
  <h2>Manage Subcategory</h2>
  <?php if ($msg): ?><div class="small" style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div class="small" style="color:red"><?php echo e($err); ?></div><?php endif; ?>

  <div class="top-actions">
    <form method="post" style="flex:1;max-width:560px">
      <input type="hidden" name="action" value="add">
      <div class="row"><label>Category</label>
        <select name="category_id" required>
          <?php foreach($cats as $c): ?>
            <option value="<?php echo e($c['id']); ?>"><?php echo e($c['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="row"><label>Name</label><input type="text" name="name" required></div>
      <div class="row"><label>Description</label><textarea name="description" rows="2"></textarea></div>
      <div class="row"><button class="btn" type="submit">Add Subcategory</button></div>
    </form>
  </div>

  <table>
    <thead><tr><th>ID</th><th>Category</th><th>Name</th><th>Desc</th><th>Action</th></tr></thead>
    <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo e($row['id']); ?></td>
        <td><?php echo e($row['catname']); ?></td>
        <td><?php echo e($row['name']); ?></td>
        <td><?php echo e($row['description']); ?></td>
        <td><a href="subcategories_edit.php?id=<?php echo e($row['id']); ?>">Edit</a> | <a href="?delete=<?php echo e($row['id']); ?>" onclick="return confirmDelete()">Delete</a></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
