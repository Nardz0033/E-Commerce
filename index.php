<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple E-Commerce</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="logo">🛒 NardzShop</div>

    <nav>
        <a href="index.php">Home</a>
        <a href="products/products.php">Products</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="users/dashboard.php">Dashboard</a>
            <a href="users/logout.php">Logout</a>
        <?php else: ?>
            <a href="users/login.php">Login</a>
            <a href="users/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<!-- HERO SECTION -->
<section class="hero">
    <h1>Welcome to NardzShop 🛍</h1>
    <p>My final project in PC223</p>
    <a href="products/products.php" class="btn">Shop Now</a>
</section>

<!-- FEATURES -->
<section class="features">
    <div class="card">
        <h3>🚀 Fast Shopping</h3>
        <p>Quick and easy product browsing</p>
    </div>

    <div class="card">
        <h3>🔒 Secure Login</h3>
        <p>Your data is safe with us</p>
    </div>

    <div class="card">
        <h3>🛒 Smart Cart</h3>
        <p>Save products and checkout anytime</p>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>© 2026 NardzShop | Built with PHP & MariaDB in Termux</p>
</footer>

</body>
</html>
