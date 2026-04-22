<?php
require_once "../includes/config.inc.php";

if (isset($_SESSION['user_id'])) {
    header("Location: /users/dashboard.php");
    exit();
}

$error   = '';
$success = '';
$fields  = ['first_name' => '', 'last_name' => '', 'email' => ''];

if (isset($_POST['register'])) {
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass1 = $_POST['password'] ?? '';
    $pass2 = $_POST['confirm_password'] ?? '';

    $fields = ['first_name' => $first, 'last_name' => $last, 'email' => $email];

    if ($first === '' || $last === '' || $email === '' || $pass1 === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($pass1) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($pass1 !== $pass2) {
        $error = "Passwords do not match.";
    } else {
        $res = db_query($conn, "SELECT user_id FROM users WHERE email=? LIMIT 1", 's', $email);
        if ($res && $res->num_rows > 0) {
            $error = "An account with that email already exists.";
        } else {
            $hashed = password_hash($pass1, PASSWORD_DEFAULT);
            $ok = db_exec($conn, "INSERT INTO users (first_name, last_name, email, pass, user_level) VALUES (?,?,?,?,0)", 'ssss', $first, $last, $email, $hashed);
            if ($ok) {
                header("Location: /users/login.php?registered=1");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<?php include "../includes/header.php"; ?>

<main class="auth-page">
    <div class="auth-card">
        <h2>Create Account</h2>
        <p class="auth-subtitle">Join NardzShop today</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="John"
                           value="<?php echo e($fields['first_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Doe"
                           value="<?php echo e($fields['last_name']); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                       value="<?php echo e($fields['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password <small>(min. 6 characters)</small></label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required>
            </div>
            <button type="submit" name="register" class="btn-primary btn-full">Create Account</button>
        </form>

        <div class="auth-links">
            Already have an account?
            <a href="/users/login.php">Sign in</a>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
