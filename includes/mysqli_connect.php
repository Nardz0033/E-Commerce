<?php
// DATABASE CONNECTION ONLY (NO OUTPUT)

$conn = mysqli_connect("127.0.0.1", "root", "root123", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
