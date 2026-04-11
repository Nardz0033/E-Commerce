<?php
include "../includes/config.inc.php";

// 🔐 CHECK LOGIN
if(!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

// 🔐 CHECK ADMIN ONLY
if($_SESSION['user_level'] != 1) {
    die("❌ Access denied. Admins only.");
}

// 🔐 CHECK IF ID EXISTS
if(!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Invalid product ID.");
}

$id = intval($_GET['id']);

// 🔥 DELETE PRODUCT
$sql = "DELETE FROM products WHERE id = $id";

if(mysqli_query($conn, $sql)) {
    header("Location: ../products/products.php?msg=deleted");
    exit();
} else {
    echo "❌ Error deleting product: " . mysqli_error($conn);
}
?>
