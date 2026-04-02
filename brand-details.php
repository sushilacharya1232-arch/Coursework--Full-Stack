<?php
include("db.php");
$id = (int)($_GET['id'] ?? 0);

$sql = "SELECT * FROM watch_brands WHERE brand_id = {$id}";
$rst = mysqli_query($mysqli, $sql);
$a_row = mysqli_fetch_assoc($rst);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Brand Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h1><?= htmlspecialchars($a_row['brand_name']) ?></h1>
      <p><strong>Country:</strong> <?= htmlspecialchars($a_row['country']) ?></p>
      <p><strong>Founded:</strong> <?= htmlspecialchars($a_row['founded_year']) ?></p>
      <p><?= nl2br(htmlspecialchars($a_row['brand_description'])) ?></p>
      <a href="index.php" class="btn btn-secondary">&lt;&lt; Back to list</a>
    </div>
  </div>
</div>
</body>
</html>
