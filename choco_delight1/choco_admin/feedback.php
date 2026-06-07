<?php
require_once 'config.php';
require_login();



if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM feedback WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close();
    header('Location: feedback.php'); exit;
}
include 'includes.php';
$res = $mysqli->query("SELECT * FROM feedback ORDER BY created_at DESC");
?>
<div class="card">
  <h2>Manage Feedback</h2>
  <?php if (isset($msg) && $msg): ?><div style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if (isset($err) && $err): ?><div style="color:red"><?php echo e($err); ?></div><?php endif; ?>



  <table>
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Rating</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo e($r['id']); ?></td>
        <td><?php echo e($r['customer_name']); ?></td>
        <td><?php echo e($r['email']); ?></td>
        <td><?php echo e($r['message']); ?></td>
        <td><?php echo e($r['rating']); ?></td>
        <td><?php echo e($r['created_at']); ?></td>
        <td>
            <a href="feedback_reply.php?id=<?php echo e($r['id']); ?>" class="btn" style="padding:4px 8px; font-size:12px;">Reply</a>
            <a href="?delete=<?php echo e($r['id']); ?>" onclick="return confirmDelete()" class="btn danger" style="padding:4px 8px; font-size:12px;">Remove</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
