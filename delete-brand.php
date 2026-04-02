<?php
session_start();
if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}

$brand_id = (int)($_GET['id'] ?? 0);
include("db.php");

$sql = "DELETE FROM watch_brands WHERE brand_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $brand_id);
$stmt->execute();

header("Location: index.php");
exit;
?>
