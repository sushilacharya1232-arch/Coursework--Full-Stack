<?php
session_start();
if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Watch Brand</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h1>Add a Watch Brand</h1>
  <form action="add-brand.php" method="post">
    <div class="mb-3">
      <label for="BrandName" class="form-label">Brand Name</label>
      <input type="text" class="form-control" id="BrandName" name="BrandName" required>
    </div>
    <div class="mb-3">
      <label for="BrandDescription" class="form-label">Description</label>
      <textarea class="form-control" id="BrandDescription" name="BrandDescription" rows="5" required></textarea>
    </div>
    <div class="mb-3">
      <label for="Country" class="form-label">Country</label>
      <input type="text" class="form-control" id="Country" name="Country" required>
    </div>
    <div class="mb-3">
      <label for="FoundedYear" class="form-label">Founded Year</label>
      <input type="number" class="form-control" id="FoundedYear" name="FoundedYear" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Brand</button>
  </form>
</div>
</body>
</html>
