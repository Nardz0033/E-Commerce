<?php include "../includes/header.php"; ?>

<?php
// 🔐 PROTECT PAGE
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<h2 style="text-align:center; margin:20px;">📦 My Orders</h2>

<?php
$sql = "SELECT * FROM orders 
        WHERE user_id='$user_id' 
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {

    while($order = mysqli_fetch_assoc($result)) {

        $order_id = $order['order_id'];

        echo "<div style='border:1px solid #ccc; padding:15px; margin:15px; border-radius:10px; background:#fff;'>";

        echo "<h3>🧾 Order #".$order_id."</h3>";
        echo "<p>💰 Total: ₱".$order['total']."</p>";
        echo "<p>📅 Date: ".$order['created_at']."</p>";

        // GET ORDER ITEMS
        $items_sql = "SELECT oi.*, p.name 
                      FROM order_items oi
                      JOIN products p ON oi.product_id = p.id
                      WHERE oi.order_id='$order_id'";

        $items_result = mysqli_query($conn, $items_sql);

        echo "<h4>🛍 Items:</h4>";

        while($item = mysqli_fetch_assoc($items_result)) {
            echo "<div style='padding-left:15px;'>";

            echo "• ".$item['name'];
            echo " | ₱".$item['price'];

            echo "</div>";
        }

        echo "</div>";
    }

} else {
    echo "<p style='text-align:center;'>No orders yet 🛒</p>";
}
?>

<?php include "../includes/footer.php"; ?>
