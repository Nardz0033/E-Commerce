<?php include "../includes/config.inc.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>🔑 Forgot Password</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Enter your email" required><br><br>
    <button type="submit" name="reset">Generate Reset Link</button>
</form>

<?php
if(isset($_POST['reset'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0) {

        $token = bin2hex(random_bytes(16));

        mysqli_query($conn, "INSERT INTO password_resets (email, token)
        VALUES ('$email', '$token')");

        echo "<p>✅ Reset Link:</p>";
        echo "<a href='reset_password.php?token=$token'>Reset Password</a>";

    } else {
        echo "<p style='color:red;'>❌ Email not found</p>";
    }
}
?>

<?php include "../includes/footer.php"; ?>
