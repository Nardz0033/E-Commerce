<?php include "../includes/header.php"; ?>
<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// GET CART ITEMS
$sql = "SELECT c.*, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$total = 0;
$items = [];

while($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;

    $items[] = $row;
}

// CREATE ORDER
if($total > 0) {

    mysqli_query($conn, "INSERT INTO orders (user_id, total)
    VALUES ('$user_id', '$total')");

    $order_id = mysqli_insert_id($conn);

    // INSERT ITEMS
    foreach($items as $item) {
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, price)
        VALUES ('$order_id', '".$item['product_id']."', '".$item['price']."')");
    }

    // CLEAR CART
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

    echo "<h3>✅ Order placed successfully!</h3>";
    echo "<p>Total Paid: ₱$total</p>";
    echo "<a href='dashboard.php'>Back to Home</a>";

} else {
    echo "Cart is empty.";
}
?>

<?php include "../includes/footer.php"; ?>
