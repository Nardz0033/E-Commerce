<?php
include "../includes/config.inc.php";

/* IF ALREADY LOGGED IN */
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

/* LOGIN PROCESS (MUST BE BEFORE ANY HTML OUTPUT) */
if(isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['pass'])) {

            // SET SESSION
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['first_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_level'] = $row['user_level'];

            // REDIRECT IMMEDIATELY
            header("Location: dashboard.php");
            exit();

        } else {
            $error = "❌ Wrong password!";
        }

    } else {
        $error = "❌ Email not found!";
    }
}
?>

<?php include "../includes/header.php"; ?>

<h2>🔐 Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<?php
// SHOW ERROR (IF ANY)
if(isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<p>
    <a href="forgot_password.php">Forgot Password?</a>
</p>

<?php include "../includes/footer.php"; ?>
