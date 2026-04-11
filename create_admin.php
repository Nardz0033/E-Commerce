<?php
include "includes/mysqli_connect.php";

mysqli_query($conn, "DELETE FROM users WHERE email='nardz@gmail.com'");

$pass = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, last_name, email, pass, user_level)
VALUES ('Admin', 'Nardz', 'nardz@gmail.com', '$pass', 1)";

mysqli_query($conn, $sql);

echo "Admin recreated successfully";
?>
