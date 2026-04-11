<?php include "../includes/header.php"; ?>

<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}
?>

<h2 style="text-align:center; margin:20px;">🛍 Our Products</h2>

<div class="product-grid">

<?php
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
?>

    <div class="product-card">

        <h3><?php echo $row['name']; ?></h3>

        <p class="price">₱<?php echo $row['price']; ?></p>

        <a class="btn-cart" href="cart.php?add=<?php echo $row['id']; ?>">
            🛒 Add to Cart
        </a>

        <?php if($_SESSION['user_level'] == 1): ?>
            <div class="admin-actions">
                <a href="../admin/edit_product.php?id=<?php echo $row['id']; ?>">✏ Edit</a>
                <a href="../admin/delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete product?')">❌ Delete</a>
            </div>
        <?php endif; ?>

    </div>

<?php } ?>

</div>

<?php include "../includes/footer.php"; ?>
<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ADD TO CART (DB)
if(isset($_GET['add'])) {

    $pid = $_GET['add'];

    $check = mysqli_query($conn, "SELECT * FROM cart 
              WHERE user_id='$user_id' AND product_id='$pid'");

    if(mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart 
            SET quantity = quantity + 1 
            WHERE user_id='$user_id' AND product_id='$pid'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity)
        VALUES ('$user_id', '$pid', 1)");
    }

    header("Location: cart.php");
    exit();
}

// REMOVE ITEM
if(isset($_GET['remove'])) {
    $pid = $_GET['remove'];

    mysqli_query($conn, "DELETE FROM cart 
    WHERE user_id='$user_id' AND product_id='$pid'");

    header("Location: cart.php");
    exit();
}
?>

<h3>Your Cart</h3>

<?php
$sql = "SELECT c.*, p.name, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$total = 0;

if(mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {

        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;

        echo "<div>";
        echo $row['name']." | ₱".$row['price']." x ".$row['quantity'];
        echo " = ₱".$subtotal;
        echo " <a href='cart.php?remove=".$row['product_id']."'>❌ Remove</a>";
        echo "</div>";
    }

    echo "<hr><h3>Total: ₱".$total."</h3>";
    echo "<a href='checkout.php'>✅ Checkout</a>";

} else {
    echo "🛒 Cart is empty.";
}
?>

<?php include "../includes/footer.php"; ?>
