<?php
require_once "../includes/config.inc.php";

if (isset($_SESSION['user_id'])) {
    header("Location: /users/dashboard.php");
    exit();
}

$error = '';

if (isset($_POST['login'])) {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please fill in all fields.";
    } else {
        $res = db_query($conn, "SELECT user_id, first_name, email, pass, user_level FROM users WHERE email=? LIMIT 1", 's', $email);
        if ($res && $row = $res->fetch_assoc()) {
            if (password_verify($password, $row['pass'])) {
                session_regenerate_id(true);
                $_SESSION['user_id']    = (int)$row['user_id'];
                $_SESSION['name']       = $row['first_name'];
                $_SESSION['email']      = $row['email'];
                $_SESSION['user_level'] = (int)$row['user_level'];
                header("Location: /users/dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<?php include "../includes/header.php"; ?>

<main class="auth-page">
    <div class="auth-card">
        <h2>Sign In</h2>
        <p class="auth-subtitle">Welcome back to NardzShop</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo e($error); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Registration successful! You can now log in.</div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                       value="<?php echo e(trim($_POST['email'] ?? '')); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Your password" required>
            </div>
            <button type="submit" name="login" class="btn-primary btn-full">Sign In</button>
        </form>

        <div class="auth-links">
            <a href="/users/forgot_password.php">Forgot your password?</a>
            &middot;
            <a href="/users/register.php">Create an account</a>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
