<header class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <span class="logo">🍫</span>
            <div class="brand-text">
                <span class="brand-name">ChocoDelight</span>
                <span class="brand-subtitle">Delivery</span>
            </div>
        </div>
        
        <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <nav class="nav-menu" id="navMenu">
            <a href="delivery_dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'delivery_dashboard.php' ? 'active' : ''; ?>">
                <span class="nav-icon">🏠</span>
                <span>Dashboard</span>
            </a>
            <a href="delivery_orders.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'delivery_orders.php' ? 'active' : ''; ?>">
                <span class="nav-icon">📦</span>
                <span>Orders</span>
            </a>
            <a href="delivery_logout.php" class="nav-link logout-link">
                <span class="nav-icon">🚪</span>
                <span>Logout</span>
            </a>
        </nav>
        
        <div class="nav-user">
            <div class="user-avatar">👤</div>
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['delivery_name'] ?? 'Partner'); ?></span>
                <span class="user-role">Delivery Partner</span>
            </div>
        </div>
    </div>
</header>