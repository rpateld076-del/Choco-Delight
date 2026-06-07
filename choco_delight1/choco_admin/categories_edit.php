<?php
require_once 'config.php';
require_login();
$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: categories.php'); exit; }

$msg=''; $err='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; $desc = $_POST['description'];
    $stmt = $mysqli->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
    $stmt->bind_param('ssi',$name,$desc,$id);
    if ($stmt->execute()) $msg='Updated';
    else $err='Update failed';
    $stmt->close();
}

$stmt = $mysqli->prepare("SELECT name,description FROM categories WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($name,$desc);
$stmt->fetch();
$stmt->close();

include 'includes.php';
?>
<div class="card">
  <h2>Edit Category</h2>
  <?php if ($msg): ?><div class="small" style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div class="small" style="color:red"><?php echo e($err); ?></div><?php endif; ?>

  <form method="post">
    <div class="row"><label>Name</label><input type="text" name="name" value="<?php echo e($name); ?>" required></div>
    <div class="row"><label>Description</label><textarea name="description" rows="3"><?php echo e($desc); ?></textarea></div>
    <div class="row"><button class="btn" type="submit">Save</button> <a href="categories.php" class="small">Back</a></div>
  </form>
</div>
<?php include 'footer.php'; ?>
