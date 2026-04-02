<?php
session_start();
require "db.php";

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 5) {
    die("Too many failed login attempts. Try again later.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login-form.php");
    exit;
}

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Invalid CSRF token.");
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    $_SESSION['login_error'] = "Please fill in all fields.";
    header("Location: login-form.php");
    exit;
}

$sql = "SELECT id, username, password_hash FROM users WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($password, $user['password_hash'])) {
    $_SESSION['login_attempts']++;
    $_SESSION['login_error'] = "Invalid username or password.";
    header("Location: login-form.php");
    exit;
}

$_SESSION['loggedin'] = true;
$_SESSION['username'] = $user['username'];
$_SESSION['user_id'] = $user['id'];
$_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';

session_regenerate_id(true);
$_SESSION['login_attempts'] = 0;

echo "<script>
    sessionStorage.setItem('tabLoggedIn', 'true');
    window.location.href = 'index.php';
</script>";
exit;
?>
