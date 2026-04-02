<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: add-brand-form.php");
    exit;
}

$brand_name = trim($_POST['BrandName'] ?? '');
$brand_description = trim($_POST['BrandDescription'] ?? '');
$country = trim($_POST['Country'] ?? '');
$founded_year = isset($_POST['FoundedYear']) ? (int)$_POST['FoundedYear'] : null;

if ($brand_name === '' || $brand_description === '' || $country === '' || $founded_year === null) {
    echo "<h3>Missing required fields.</h3>";
    echo "<p><a href='add-brand-form.php'>Back to form</a></p>";
    exit;
}

require 'db.php';

$sql = "INSERT INTO watch_brands (brand_name, brand_description, country, founded_year)
        VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo "<h3>Database error.</h3>";
    echo "<p>" . htmlspecialchars($mysqli->error) . "</p>";
    exit;
}

$stmt->bind_param("sssi", $brand_name, $brand_description, $country, $founded_year);

if (!$stmt->execute()) {
    echo "<h3>Could not save brand.</h3>";
    echo "<p>" . htmlspecialchars($stmt->error) . "</p>";
    exit;
}

header("Location: index.php");
exit;
?>
