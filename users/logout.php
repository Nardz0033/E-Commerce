<?php
session_start();

// CLEAR ALL SESSION DATA
$_SESSION = [];

// DESTROY SESSION
session_unset();
session_destroy();

// OPTIONAL: remove session cookie for full cleanup
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// REDIRECT TO HOME PAGE
header("Location: ../index.php");
exit();
?>
