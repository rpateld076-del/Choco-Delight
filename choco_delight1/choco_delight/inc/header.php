<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Choco Delight</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
  <div class="container header-flex">

    <!-- LOGO -->
    <h1 class="logo">
      <a href="index.php">Choco Delight</a>
    </h1>

    <!-- NAVBAR -->
    <nav class="main-nav">
      <ul class="nav-menu">

        <li><a href="index.php">Home</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact Us</a></li>


        <?php if (is_logged_in()): ?>
          <li>
            <a href="cart.php">
              Cart(
              <?php
                echo isset($_SESSION['cart'])
                  ? array_sum(array_column($_SESSION['cart'], 'qty'))
                  : 0;
              ?>
              )
            </a>
          </li>
          <li><a href="my_orders.php">My Orders</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="register.php">Register</a></li>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>

      </ul>
    </nav>

  </div>
</header>

<main class="container">
