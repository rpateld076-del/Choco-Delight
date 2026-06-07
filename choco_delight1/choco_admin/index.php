<?php
require_once 'config.php';
require_login();

include 'includes.php';
?>
<div class="card">
  <h2>Dashboard</h2>
  <p>Welcome, <b><?php echo e($_SESSION['admin_name'] ?? 'Admin'); ?></b>!</p>
  <p>Use the sidebar to manage your store.</p>
</div>

<?php include 'footer.php'; ?>
