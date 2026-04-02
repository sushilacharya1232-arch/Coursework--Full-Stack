<?php
session_start();
if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}

include 'db.php';

$brand_id = (int)($_POST['brand_id'] ?? 0);
$brand_name = trim($_POST['brand_name'] ?? '');
$brand_description = trim($_POST['brand_description'] ?? '');
$country = trim($_POST['country'] ?? '');
$founded_year = (int)($_POST['founded_year'] ?? 0);

$sql = "UPDATE watch_brands
        SET brand_name = ?,
            brand_description = ?,
            country = ?,
            founded_year = ?
        WHERE brand_id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssii", $brand_name, $brand_description, $country, $founded_year, $brand_id);
$stmt->execute();

header("Location: index.php");
exit;
?>
