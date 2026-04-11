<?php include "../includes/config.inc.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>🔐 Reset Password</h2>

<?php
$token = $_GET['token'] ?? '';

if($token == '') {
    die("Invalid token");
}
?>

<form method="POST">
    <input type="password" name="new_password" placeholder="New Password" required><br><br>
    <button type="submit" name="update">Update Password</button>
</form>

<?php
if(isset($_POST['update'])) {

    $newpass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $get = mysqli_query($conn, "SELECT * FROM password_resets WHERE token='$token'");

    if(mysqli_num_rows($get) > 0) {

        $row = mysqli_fetch_assoc($get);
        $email = $row['email'];

        mysqli_query($conn, "UPDATE users SET pass='$newpass' WHERE email='$email'");

        mysqli_query($conn, "DELETE FROM password_resets WHERE token='$token'");

        echo "<p style='color:green;'>✅ Password updated successfully</p>";

    } else {
        echo "<p style='color:red;'>❌ Invalid token</p>";
    }
}
?>

<?php include "../includes/footer.php"; ?>
