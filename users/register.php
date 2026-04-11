<?php include "../includes/header.php"; ?>

<?php
// IF ALREADY LOGGED IN
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<h2>📝 Register</h2>

<form method="POST">
    <input type="text" name="first_name" placeholder="First Name" required><br><br>

    <input type="text" name="last_name" placeholder="Last Name" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>

    <button type="submit" name="register">Register</button>
</form>

<?php
if(isset($_POST['register'])) {

    $first = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass1 = $_POST['password'];
    $pass2 = $_POST['confirm_password'];

    // CHECK PASSWORD MATCH
    if($pass1 !== $pass2) {
        echo "<p style='color:red;'>❌ Passwords do not match!</p>";
        exit();
    }

    // CHECK EMAIL EXISTS
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0) {
        echo "<p style='color:red;'>❌ Email already exists!</p>";
        exit();
    }

    // HASH PASSWORD
    $hashed_pass = password_hash($pass1, PASSWORD_DEFAULT);

    // INSERT USER
    $sql = "INSERT INTO users (first_name, last_name, email, pass, user_level)
            VALUES ('$first', '$last', '$email', '$hashed_pass', 0)";

    if(mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>✅ Registered successfully! You can now login.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<?php include "../includes/footer.php"; ?>
