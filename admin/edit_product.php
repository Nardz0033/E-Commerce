<?php include "../includes/header.php"; ?>

<?php
// 🔐 ONLY ADMIN CAN ACCESS
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 1) {
    die("❌ Access denied");
}

// CHECK ID
if(!isset($_GET['id'])) {
    die("❌ No product selected");
}

$id = $_GET['id'];

// GET PRODUCT DATA
$sql = "SELECT * FROM products WHERE id='$id' LIMIT 1";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0) {
    die("❌ Product not found");
}

$product = mysqli_fetch_assoc($result);
?>

<h2>✏ Edit Product</h2>

<form method="POST">
    <label>Product Name</label><br>
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br><br>

    <label>Price</label><br>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br><br>

    <button type="submit" name="update">Update Product</button>
</form>

<?php
// UPDATE PRODUCT
if(isset($_POST['update'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $update = "UPDATE products 
               SET name='$name', price='$price' 
               WHERE id='$id'";

    if(mysqli_query($conn, $update)) {
        echo "<p style='color:green;'>✅ Product updated successfully!</p>";
        echo "<a href='products.php'>⬅ Back to Products</a>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<?php include "../includes/footer.php"; ?>
