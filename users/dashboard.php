<?php include "../includes/header.php"; ?>

<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="dashboard">

<h2>👋 Welcome, <?php echo $_SESSION['name']; ?></h2>

<p>Email: <?php echo $_SESSION['email']; ?></p>

<div class="dashboard-grid">

    <div class="dash-card">
        <h3>🛍 Products</h3>
        <a href="../products/products.php">Browse</a>
    </div>

    <div class="dash-card">
        <h3>🛒 Cart</h3>
        <a href="../products/cart.php">View</a>
    </div>

    <div class="dash-card">
        <h3>📦 Orders</h3>
        <a href="orders.php">My Orders</a>
    </div>

    <?php if($_SESSION['user_level'] == 1): ?>
    <div class="dash-card admin">
        <h3>🛠 Admin Panel</h3>
        <a href="../admin/admin_add_product.php">Add Product</a><br>
        <a href="../admin/admin_orders.php">View Orders</a>
    </div>
    <?php endif; ?>

</div>

</div>

<?php include "../includes/footer.php"; ?>
