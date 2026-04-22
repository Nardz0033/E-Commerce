<?php
if (!isset($conn)) {
    $conn = new mysqli("127.0.0.1", "root", "root123", "ecommerce");
    if ($conn->connect_error) {
        error_log("DB connection failed: " . $conn->connect_error);
        die("Database connection error. Please try again later.");
    }
    $conn->set_charset("utf8mb4");
}

function db_query(mysqli $conn, string $sql, string $types = '', ...$params): mysqli_result|bool {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error . " | SQL: " . $sql);
        return false;
    }
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false && $conn->errno === 0) {
        $stmt->close();
        return true;
    }
    $stmt->close();
    return $result;
}

function db_exec(mysqli $conn, string $sql, string $types = '', ...$params): bool {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error . " | SQL: " . $sql);
        return false;
    }
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function db_insert_id(mysqli $conn): int {
    return (int)$conn->insert_id;
}

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function require_login(): void {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/users/login.php");
        exit();
    }
}

function require_admin(): void {
    require_login();
    if ((int)$_SESSION['user_level'] !== 1) {
        http_response_code(403);
        die("<p style='color:red; text-align:center; padding:40px;'>Access denied. Admins only.</p>");
    }
}
