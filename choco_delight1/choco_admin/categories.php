<?php
require_once 'config.php';
require_login();
$msg = $err = '';

if (isset($_POST['action']) && $_POST['action']=='add') {
    $name = $_POST['name']; $desc = $_POST['description'];
    $stmt = $mysqli->prepare("INSERT INTO categories (name,description) VALUES (?,?)");
    $stmt->bind_param('ss',$name,$desc);
    if ($stmt->execute()) $msg = "Category added";
    else $err = "Add failed";
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    header('Location: categories.php');
    exit;
}

include 'includes.php';
$res = $mysqli->query("SELECT * FROM categories ORDER BY created_at DESC");
?>
<div class="card">
  <h2>Manage Category</h2>
  <?php if ($msg): ?><div class="small" style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div class="small" style="color:red"><?php echo e($err); ?></div><?php endif; ?>

  <div class="top-actions">
    <form method="post" style="flex:1;max-width:520px">
      <input type="hidden" name="action" value="add">
      <div class="row"><label>Name</label><input type="text" name="name" required></div>
      <div class="row"><label>Description</label><textarea name="description" rows="2"></textarea></div>
      <div class="row"><button class="btn" type="submit">Add Category</button></div>
    </form>
  </div>

  <table>
    <thead><tr><th>ID</th><th>Name</th><th>Desc</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo e($row['id']); ?></td>
        <td><?php echo e($row['name']); ?></td>
        <td><?php echo e($row['description']); ?></td>
        <td>
          <a href="categories_edit.php?id=<?php echo e($row['id']); ?>">Edit</a> |
          <a href="?delete=<?php echo e($row['id']); ?>" onclick="return confirmDelete()">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
