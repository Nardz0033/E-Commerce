<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/db.php";

$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $res = db_query($conn, "SELECT COALESCE(SUM(quantity), 0) AS total FROM cart WHERE user_id=?", 'i', $uid);
    if ($res && $row = $res->fetch_assoc()) {
        $cart_count = (int)$row['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NardzShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header class="navbar">
    <a href="/index.php" class="logo">NardzShop</a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
        <span></span><span></span><span></span>
    </button>
    <nav id="navMenu">
        <a href="/index.php">Home</a>
        <a href="/products/products.php">Products</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/products/cart.php" class="nav-cart">
                Cart
                <?php if ($cart_count > 0): ?>
                    <span class="cart-badge"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </a>
            <a href="/users/dashboard.php">Dashboard</a>
            <a href="/users/orders.php">Orders</a>
            <?php if ((int)$_SESSION['user_level'] === 1): ?>
                <a href="/admin/admin_add_product.php" class="nav-admin">Admin</a>
                <a href="/admin/admin_orders.php" class="nav-admin">All Orders</a>
            <?php endif; ?>
            <a href="/users/logout.php" class="nav-logout">Logout</a>
        <?php else: ?>
            <a href="/users/login.php">Login</a>
            <a href="/users/register.php" class="nav-cta">Register</a>
        <?php endif; ?>
    </nav>
</header>

<script>
document.getElementById('navToggle').addEventListener('click', function() {
    document.getElementById('navMenu').classList.toggle('open');
});
</script>
