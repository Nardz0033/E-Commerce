<?php include "../includes/header.php"; ?>

<?php
// 🔐 ONLY ADMIN CAN ACCESS
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 1) {
    die("<h3 style='color:red;'>❌ Access denied</h3>");
}
?>

<h2>🛠 Add New Product</h2>

<div style="max-width:400px; margin:auto;">

<form method="POST">

    <label>Product Name</label><br>
    <input type="text" name="name" required style="width:100%; padding:8px;"><br><br>

    <label>Price</label><br>
    <input type="number" step="0.01" name="price" required style="width:100%; padding:8px;"><br><br>

    <button type="submit" name="add" style="width:100%; padding:10px; background:#007bff; color:white; border:none;">
        ➕ Add Product
    </button>

</form>

</div>

<?php
if(isset($_POST['add'])) {

    // SAFE INPUT
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];

    // INSERT PRODUCT
    $sql = "INSERT INTO products (name, price)
            VALUES ('$name', '$price')";

    if(mysqli_query($conn, $sql)) {
        echo "<p style='color:green; text-align:center;'>✅ Product added successfully!</p>";

        // redirect after 1 second
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'admin_add_product.php';
                }, 1000);
              </script>";

    } else {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<?php include "../includes/footer.php"; ?>
