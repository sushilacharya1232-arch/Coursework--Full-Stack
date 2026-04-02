<?php
session_start();
if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}

include 'db.php';
$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT * FROM watch_brands WHERE brand_id = $id";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Brand</title>
</head>
<body>
<h1>Update Watch Brand</h1>
<form action="update-brand.php" method="post">
  <input type="hidden" name="brand_id" value="<?= $row['brand_id'] ?>">

  <label>Brand Name:</label><br>
  <input type="text" name="brand_name" value="<?= htmlspecialchars($row['brand_name']) ?>" required><br><br>

  <label>Description:</label><br>
  <textarea name="brand_description" rows="5" cols="40" required><?= htmlspecialchars($row['brand_description']) ?></textarea><br><br>

  <label>Country:</label><br>
  <input type="text" name="country" value="<?= htmlspecialchars($row['country']) ?>" required><br><br>

  <label>Founded Year:</label><br>
  <input type="number" name="founded_year" value="<?= htmlspecialchars($row['founded_year']) ?>" required><br><br>

  <input type="submit" value="Update Brand">
</form>
</body>
</html>
