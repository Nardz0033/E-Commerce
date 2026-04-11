<?php
include "../includes/config.inc.php";

// 🔐 PROTECT PAGE (NO OUTPUT BEFORE THIS)
if(!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include "../includes/header.php"; ?>

<h2 style="text-align:center; margin:20px;">🛍 Products</h2>

<div class="product-grid">

<?php
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {
?>

        <div class="product-card">

            <h3><?php echo htmlspecialchars($row['name']); ?></h3>

            <p class="price">₱<?php echo $row['price']; ?></p>

            <!-- ADD TO CART (DATABASE CART) -->
            <a class="btn-cart" href="cart.php?add=<?php echo $row['id']; ?>">
                🛒 Add to Cart
            </a>

            <!-- ADMIN CONTROLS -->
            <?php if($_SESSION['user_level'] == 1): ?>
                <div class="admin-actions">
                    <a href="../admin/edit_product.php?id=<?php echo $row['id']; ?>">✏ Edit</a> |
                    <a href="../admin/delete_product.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Delete this product?')">❌ Delete</a>
                </div>
            <?php endif; ?>

        </div>

<?php
    }

} else {
    echo "<p style='text-align:center;'>No products available.</p>";
}
?>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
