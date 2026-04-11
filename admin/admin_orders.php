<?php include "../includes/header.php"; ?>

<?php
// 🔐 ADMIN ONLY ACCESS
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 1) {
    die("❌ Access denied");
}
?>

<h2 style="text-align:center; margin:20px;">🛠 All Customer Orders</h2>

<div style="padding:20px;">

<?php
$sql = "SELECT o.order_id, o.total, o.created_at,
               u.first_name, u.last_name, u.email
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {
?>

    <div style="
        background:white;
        padding:15px;
        margin-bottom:15px;
        border-radius:10px;
        box-shadow:0 3px 10px rgba(0,0,0,0.1);
    ">

        <h3>📦 Order #<?php echo $row['order_id']; ?></h3>

        <p>👤 Customer:
            <?php echo $row['first_name'] . " " . $row['last_name']; ?>
        </p>

        <p>📧 Email: <?php echo $row['email']; ?></p>

        <p>💰 Total: ₱<?php echo $row['total']; ?></p>

        <p>📅 Date: <?php echo $row['created_at']; ?></p>

    </div>

<?php
    }

} else {
    echo "<p style='text-align:center;'>No orders found.</p>";
}
?>

</div>

<?php include "../includes/footer.php"; ?>
