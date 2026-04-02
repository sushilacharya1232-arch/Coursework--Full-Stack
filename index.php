<?php
session_start();

if (
    !isset($_SESSION['loggedin']) ||
    $_SESSION['loggedin'] !== true ||
    !isset($_SESSION['agent']) ||
    $_SESSION['agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? '')
) {
    header("Location: login-form.php");
    exit;
}

include("db.php");

$sql = "SELECT * FROM watch_brands ORDER BY founded_year DESC";
$results = mysqli_query($mysqli, $sql);

if (!$results) {
    die("Database error: " . htmlspecialchars(mysqli_error($mysqli)));
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Watch Brands</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: linear-gradient(135deg, #f8f9fa, #e9ecef);
  font-family: 'Segoe UI', Tahoma, sans-serif;
}
.brand-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: #ffffff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}
.brand-table thead tr {
  background: linear-gradient(135deg, #111827, #374151);
}
.brand-table thead th {
  color: white;
  padding: 16px;
}
.brand-table td {
  padding: 16px;
  border-bottom: 1px solid #e5e7eb;
}
.brand-table tbody tr:nth-child(even) {
  background: #f9fafb;
}
.brand-table tbody tr:hover {
  background: #f3f4f6;
}
.brand-link {
  color: #0d6efd;
  text-decoration: none;
  font-weight: 600;
}
.brand-link:hover {
  text-decoration: underline;
}
</style>
</head>
<body>

<script>
if (!sessionStorage.getItem('tabLoggedIn')) {
    window.location.href = 'login-form.php';
}
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Luxury Watch Brands</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <div class="ms-auto d-flex align-items-center">
        <form class="d-flex me-3" action="search-brands.php" method="post">
          <input class="form-control form-control-sm me-2" type="text" name="keywords" placeholder="Search brand">
          <button class="btn btn-sm btn-outline-light" type="submit">Go</button>
        </form>

        <ul class="navbar-nav me-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="ajaxDropdown" role="button" data-bs-toggle="dropdown">
              AJAX Features
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="bootstrap-ajax-dropdown.html">Dropdown Example</a></li>
              <li><a class="dropdown-item" href="bootstrap-ajax-modal.html">Modal Example</a></li>
            </ul>
          </li>
        </ul>

        <span class="text-white me-3">Logged in as <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
        <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="d-flex justify-content-between mb-3">
    <h2 class="h4">Watch Brand Collection</h2>
    <a href="add-brand-form.php" class="btn btn-success btn-sm">+ Add Brand</a>
  </div>

  <table class="brand-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Brand Name</th>
        <th>Country</th>
        <th>Founded</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td><?= (int)$row['brand_id'] ?></td>
        <td><a class="brand-link" href="brand-details.php?id=<?= (int)$row['brand_id'] ?>"><?= htmlspecialchars($row['brand_name']) ?></a></td>
        <td><?= htmlspecialchars($row['country']) ?></td>
        <td><?= htmlspecialchars($row['founded_year']) ?></td>
        <td>
          <a class="btn btn-warning btn-sm" href="edit-brand-form.php?id=<?= (int)$row['brand_id'] ?>">Edit</a>
          <a class="btn btn-outline-danger btn-sm" href="delete-brand.php?id=<?= (int)$row['brand_id'] ?>" onclick="return confirm('Delete this brand?');">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
