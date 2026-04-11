<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "mysqli_connect.php";

// 🛒 CART COUNT (database cart system)
$cart_count = 0;

if(isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    $sqlCart = "SELECT SUM(quantity) AS total FROM cart WHERE user_id='$uid'";
    $resCart = mysqli_query($conn, $sqlCart);
    $rowCart = mysqli_fetch_assoc($resCart);

    $cart_count = $rowCart['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop</title>
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<header class="navbar">

    <div class="logo">🛒 NardzShop</div>

    <nav>

        <!-- HOME -->
        <a href="../index.php">Home</a>

        <!-- PRODUCTS -->
        <a href="../products/products.php">Products</a>

        <!-- CART -->
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="../products/cart.php">
                🛒 Cart (<?php echo $cart_count; ?>)
            </a>
        <?php endif; ?>

        <!-- AUTH LINKS -->
        <?php if(isset($_SESSION['user_id'])): ?>

            <!-- DASHBOARD -->
            <a href="../users/dashboard.php">Dashboard</a>

            <!-- ORDERS -->
            <a href="../users/orders.php">Orders</a>

            <!-- ADMIN ONLY -->
            <?php if($_SESSION['user_level'] == 1): ?>
                <a href="../admin/admin_add_product.php">Admin</a>
                <a href="../admin/admin_orders.php">All Orders</a>
            <?php endif; ?>

            <!-- LOGOUT -->
            <a href="../users/logout.php">Logout</a>

        <?php else: ?>

            <a href="../users/login.php">Login</a>
            <a href="../users/register.php">Register</a>

        <?php endif; ?>

    </nav>

</header>

<hr>
