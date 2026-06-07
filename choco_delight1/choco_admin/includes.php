
<?php
// includes.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Choco Delight Admin Panel</title>
  <style>
    :root{--brown:#3e2723;--brown2:#6d4c41;--muted:#efebe9}
    *{box-sizing:border-box}
    body{font-family:Arial,Helvetica,sans-serif;margin:0;background:#f7f3f0}
    header{background:var(--brown);color:#fff;padding:12px 20px;display:flex;align-items:center;justify-content:space-between}
    header h1{font-size:18px;margin:0}
    .wrap{display:flex;min-height:calc(100vh - 56px)}
    nav.sidebar{width:240px;background:var(--brown);color:#fff;padding:18px}
    nav.sidebar a{display:block;color:#fff;padding:10px;border-radius:6px;text-decoration:none;margin-bottom:8px;background:transparent}
    nav.sidebar a:hover{background:var(--brown2)}
    main{flex:1;padding:20px}
    .card{background:#fff;padding:16px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.06);margin-bottom:16px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:8px;border:1px solid #eee;text-align:left}
    form .row{margin-bottom:10px}
    label{display:block;font-weight:600;margin-bottom:6px}
    input[type=text],input[type=email],input[type=number],select,textarea{width:100%;padding:8px;border:1px solid #ddd;border-radius:4px}
    .btn{display:inline-block;padding:8px 12px;background:var(--brown2);color:#fff;border:none;border-radius:6px;cursor:pointer}
    .btn.danger{background:#c62828}
    .right{float:right}
    .small{font-size:13px;color:#666}
    .top-actions{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
  </style>
  <script>
    function confirmDelete() {
      return confirm('Are you sure?');
    }
  </script>
</head>
<body>
  <header>
    <h1>Choco Delight Admin</h1>
    <div>
      <?php if (isset($_SESSION['admin_name'])): ?>
        <span style="margin-right:12px">Hello, 
        <a href="profile.php" style="color:#fff;margin-right:12px">Profile</a>
        <a href="logout.php" style="color:#fff">Logout</a>
      <?php else: ?>
        <a href="login.php" style="color:#fff">Login</a>
      <?php endif; ?>
    </div>
  </header>
  <div class="wrap">
    <nav class="sidebar">
      <a href="index.php">Dashboard</a>
      <a href="categories.php">Manage Category</a>
      <a href="subcategories.php">Manage Subcategory</a>
      <a href="products.php">Manage Product</a>
      <a href="customers.php">Manage Customer</a>
      <a href="gallery.php">Manage Gallery</a>
      <a href="orders.php">Manage Order</a>
      <a href="payments.php">Manage Payment</a>
      <a href="invoice.php">Generate Invoice</a>
      <a href="feedback.php">Manage Feedback</a>
      <a href="delivery.php">Manage Delivery Person</a>
      <a href="manage_contact.php">Manage Contact</a>
      <a href="reports.php">Generate Report</a>
    </nav>
    <main>
